<?php

namespace App\Http\Controllers\Media;

use App\Media;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
trait Upload
{
	public function addFile($name,$size){
		$storagePath  = Storage::disk($this->storageDisk)->getDriver()->getAdapter()->getPathPrefix();
		$file_name=pathinfo($name,PATHINFO_FILENAME);
		$file_ext=mb_strtolower(pathinfo($name,PATHINFO_EXTENSION));
		$file_mime=mb_strtolower(pathinfo($name,PATHINFO_EXTENSION));
		$user_id=Auth::id();
		$counter=0;
		do{
			$file_address=$storagePath.DIRECTORY_SEPARATOR.$file_name.($counter>0?('_'.($counter)):'').'.'.$file_ext;
			$counter++;
		}while(File::isFile($file_address)&&File::exists($file_address));
		$file_realName=File::name($file_address);
		$data=array(
					'user_id'=>$user_id,
					'name'=>$file_name,
					'size'=>$size,
					'extension'=>$file_ext,
					'mime'=>$file_mime,
					'real_name'=>$file_realName,
					'upload_path'=>$file_address,
					'complete_at'=>null,
					'resume_at'=>Carbon::now()->format('Y-m-d H:i:s'),
				);
		$media=Media::create($data);
		if($media->exists()){
			return $media->id;
		}
	}

	public function getFile($id){
		$media=Media::find($id);
		if(empty($media)){
			return;
		}
		$key=0;
		$output=array();

		$output['id']=$media->id;

		@clearstatcache();

		if(File::exists($media->upload_path)){
			$output['chunkPointer']=File::size($media->upload_path);
		}else{
			$output['chunkPointer']=0;
		}

		$output['complete']=$media->completed();
		$output['pause']=$media->resumed();

		$output['address']=$media->upload_path;
		$output['ext']=$media->extension;
		$output['last_try']=$media->updated_at;
		$output['added_on']=$media->created_at;

		$output['file']['name']=$media->name.'.'.$media->extension;
		$output['file']['size']=$media->size;

		return $output;
	}

	public function processUpload(Request $request){
		$action=$request->input('action');
		$msg=array('hasError'=>false,'error'=>'');
		try{
			switch($action){
				case 'delete':
					$id=$request->input('id');
					if(empty($id)||!is_numeric($id)){
						$msg['hasError']=true;
						$msg['error']='file id not Found';
					}else{
						$data=$this->getFile($id);
						if(empty($data)){
							$msg['hasError']=true;
							$msg['error']='file not Found';
						}else{
							if(File::exists($data['address'])){
								File::delete($data['address']);
							}

							$media=Media::find($id);
							if(empty($media)){
								$msg['hasError']=true;
								$msg['error']='file not Found';
							}else{
								$media->delete();
								$msg['delete']=$id;
							}
						}
					}
				case 'add':
					$name=$request->input('name');
					$size=$request->input('size');
					$extension=mb_strtolower(pathinfo($name,PATHINFO_EXTENSION));
					if(empty($name)){
						$msg['hasError']=true;
						$msg['error']=trans('general.file_name_not_valid');
					}elseif(empty($size)||$size<=0||$size>$this->maxFileSize){//check file size
						$msg['hasError'] = true;
						$msg['error'] = trans('general.file_size_not_valid',['size'=>$this->maxFileSize]);
					}elseif(!in_array($extension,$this->allowedFileExtensions)){//check file extension
						$msg['hasError'] = true;
						$type=implode(',',$this->allowedFileExtensions);
						$msg['error'] = trans('general.file_type_not_valid',['type'=>$type]);
					}else{
						$id=$this->addFile($name,$size);
						$msg['id']=$id;
					}
					break;
				case 'get':
					$id=$request->input('id');
					if(empty($id)||!is_numeric($id)){
						$msg['hasError']=true;
						$msg['error'] = trans('general.file_not_found');
					}else{
						$data=$this->getFile($id);

						if(!empty($data)){
							$msg['data']=$data;
						}
					}
					break;
				case 'upload':
					$id=$request->input('id');
					$name=$request->input('name');
					$extension=mb_strtolower(pathinfo($name,PATHINFO_EXTENSION));
					$size=$request->input('size');
					$start=$request->input('start');
					$end=$request->input('end');
					$data=$request->file('media');
					if(empty($id)||!is_numeric($id)) {
						$msg['hasError'] = true;
						$msg['error'] = trans('general.file_not_found');
					}elseif(empty($data)){
						$msg['hasError'] = true;
						$msg['error'] = trans('general.file_not_found');
					}elseif(empty($name)){
						$msg['hasError']=true;
						$msg['error']=trans('general.file_name_not_valid');
					}elseif(empty($size)||$size<=0||$size>$this->maxFileSize){//check file size
						$msg['hasError'] = true;
						$msg['error'] = trans('general.file_size_not_valid',['size'=>$this->maxFileSize]);
					}elseif(!in_array($extension,$this->allowedFileExtensions)){//check file extension
						$msg['hasError'] = true;
						$type=implode(',',$this->allowedFileExtensions);
						$msg['error'] = trans('general.file_type_not_valid',['type'=>$type]);
					}elseif($start<0){
						$msg['hasError']=true;
						$msg['error']='file has a wrong start point';
					}elseif(empty($end)||$end<0){
						$msg['hasError']=true;
						$msg['error']='file has wrong end point';
					}else{
						$fileInfo=$this->getFile($id);
						if(empty($data)){
							$msg['hasError'] = true;
							$msg['error'] = trans('general.file_not_found');
						}else{
							if(is_uploaded_file($data->getPathname())){
								//complete percent:
								$msg['progressPercent']=intval(($end/$size)*100);
								$media=Media::findOrFail($id);
								if($msg['progressPercent']=='100'){
									$media->markAsUnresumed()->markAsCompleted();
								}else{
									$media->markAsresumed()->markAsUncompleted();
								}
								$tempFile = fopen($data->getPathname(), 'r');
								flock($tempFile, LOCK_EX);
								$uploadedData = fread($tempFile, $end - $start + 1);
								flock($tempFile, LOCK_UN);
								$file = fopen($fileInfo['address'], 'a');
								flock($file, LOCK_EX);
								fwrite($file, $uploadedData);
								flock($file, LOCK_UN);
								fclose($tempFile);
								fclose($file);

								//return file info:
								$data=$this->getFile($id);
								if(!empty($data)){
									$msg['data']=$data;
								}
							}
						}
					}
					break;
				default:
					$msg['hasError']=true;
					$msg['error']='action is not valid';
					break;
			}
		}catch(\Exception $e){
			$msg['hasError']=true;
			$msg['error']=$e->getMessage();
		}finally{
			return $msg;
		}
	}
}