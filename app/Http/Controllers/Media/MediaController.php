<?php

namespace App\Http\Controllers\Media;

use App\Media;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{

	public $storageDisk='public';

	public $downloadDelay=1000;//1 sec

	public $maxFileSize;
	public $allowedFileExtensions;

	const ATTACHMENT='attachment';
	const INLINE='inline';

	/**
	 * MediaController constructor.
	 */
	public function __construct(){
		$this->middleware('auth')->except('showAsInline','showAsAttachment','resizeOnAir');

		$this->maxFileSize=config('ticket.attachment.file.size')*1024*1024;
		$this->allowedFileExtensions=config('ticket.attachment.file.formats');

	}

	use Upload;
	use Download;

	/**
     * Display a listing of the resource.
     *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function index(Request $request)
    {
    	// Add policy
		$this->authorize('index',Media::class);

    	$search=$request->input('search');
    	$medias=Auth::user()->medias()->where('real_name','like','%'.$search.'%')
    				 ->orderByDesc('id');
        if($request->expectsJson()){
        	return response()->json($medias->paginate(),200);
        }
        return view('media.index')->with('medias',$medias->simplePaginate());
    }

	/**
	 * validate chunk upload request
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validateChunkMedia(Request $request){
    	return Validator::make($request->all(),[
    		'action'=>'required|string|in:add,upload,get,delete',
			'name'=>'required|string|min:3',
			'size'=>'numeric|max:'.$this->maxFileSize,
			'id'=>'nullable|exists:medias,id',
			'start'=>'nullable|numeric',
			'end'=>'nullable|numeric',
			'media'=>'nullable|file|max:'.$this->maxFileSize,
		]);
    }

	/**
	 * validate simple upload request
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validateMedia(Request $request){
    	return Validator::make($request->all(),[
			'media'=>'required|file|mimes:'.implode(',',$this->allowedFileExtensions).'|max:'.$this->maxFileSize,
		]);
    }

    public function validateMediaName(Request $request){
    	return Validator::make($request->all(),[
    		'name'=>'required',
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function create()
    {
    	// Add policy
		$this->authorize('create',Media::class);

        return view('media.create');
    }

    public function storeChunk(Request $request){

		// Add policy
		$this->authorize('create',Media::class);

        $validator=$this->validateChunkMedia($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		//proccess and save chunks
		$result=$this->processUpload($request);

		/**
		 * return a response after saving each chunk
		 */

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json($result);
        }

        Session::flash('success',$status);

		return redirect()->back()->with($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function store(Request $request)
    {
		// Add policy
		$this->authorize('create',Media::class);

        $validator=$this->validateMedia($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$name=$request->file('media')->getClientOriginalName();
		$size=$request->file('media')->getSize();

		$storagePath  = Storage::disk($this->storageDisk)->getDriver()->getAdapter()->getPathPrefix();
		$file_name=pathinfo($name,PATHINFO_FILENAME);
		$file_ext=pathinfo($name,PATHINFO_EXTENSION);
		$file_mime=pathinfo($name,PATHINFO_EXTENSION);
		$counter=0;
		do{
			$file_address=$storagePath.DIRECTORY_SEPARATOR.$file_name.($counter>0?('_'.($counter)):'').'.'.$file_ext;
			$counter++;
		}while(File::isFile($file_address)&&File::exists($file_address));
		$file_realName=File::name($file_address);

		$path = $request->file('media')->storeAs(
			$this->storageDisk, File::basename($file_address)
		);

		$data=array(
					'user_id'=>Auth::id(),
					'name'=>$file_name,
					'size'=>$size,
					'extension'=>$file_ext,
					'mime'=>$file_mime,
					'real_name'=>$file_realName,
					'upload_path'=>$file_address,
					'complete_at'=>Carbon::now()->format('Y-m-d H:i:s'),
					'resume_at'=>null,
				);

		$media=Media::create($data);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'media'=>$media,
			]);
        }

		Session::flash('success',$status);

		return redirect()->back()->with($request->all());
    }

    /**
     * Display the specified resource.
     *
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function show($id)
    {
    	$media=Media::findOrFail($id);

    	// Add policy
		$this->authorize('view',$media);

        if(request()->expectsJson()){
        	return response()->json([
        		'media'=>$media,
			]);
        }

       	return view('media.show')->with('media',$media);
    }

	/**
	 * show file
	 *
	 * @param $id
	 */
	public function showAsInline($id){
		$media=Media::findOrFail($id);

		if($media->completed()){
			$path=$media->path;
			if(File::exists($path)){
				$this->prepare($path,$this->delay);
			}else{
				//file is not exists:
				return abort(404);
			}
		}else{ // partial uploaded
			//handle partial file download
		}
		//send file as inline
		$name=$media->real_name.'.'.$media->extension;
		$this->processDownload(self::INLINE,$name);
	}

	/**
	 * send file for download
	 *
	 * @param $id
	 */
    public function showAsAttachment($id){
		$media=Media::findOrFail($id);

		if($media->completed()){
			$path=$media->path;
			if(File::exists($path)){
				$this->prepare($path,$this->delay);
			}else{
				//file is not exists:
				return abort(404);
			}
		}else{ // partial uploaded
			//handle partial file download
		}
		//send file as attachment
		$name=$media->real_name.'.'.$media->extension;
		$this->processDownload(self::ATTACHMENT,$name);
    }

	/**
	 * resize and show images
	 *
	 * @param $id
	 * @param int $width
	 * @param int $height
	 */
	public function resizeOnAir($id,$width=128,$height=128){
		$media=Media::findOrFail($id);

		if($media->completed()){
			$path=$media->path;
			if(File::exists($path)){
				//resize
				$image=Image::make($path)->fit($width, $height);
			}else{
				//file is not exists:
				return abort(404);
			}
		}else{ // partial uploaded
			//handle partial file download
			return abort(404);
		}
		//stream output
		return $image->response('jpg',60);
	}

    /**
     * Show the form for editing the specified resource.
     *
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function edit($id)
    {
    	$media=Media::findOrFail($id);

    	// Add policy
		$this->authorize('update',$media);

        if(request()->expectsJson()){
        	return response()->json([
        		'media'=>$media,
			]);
        }

        return view('media.edit')->with('media',$media);
    }

    /**
     * Update the specified resource in storage.
     *
	 * @param Request $request
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function update(Request $request, $id)
    {
        $validator=$this->validateMediaName($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'name'=>$request->input('name'),
		];

    	$media=Media::findOrFail($id);

    	// Add policy
		$this->authorize('update',$media);

		$media->update($data);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'media'=>$media,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('media.edit',$media);
    }

	/**
     * Remove the specified resource from storage.
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function destroy($id)
    {
    	$media=Media::findOrFail($id);

    	// Add policy
		$this->authorize('delete',$media);

		//remove from disk
		if(File::exists($media->path)){
			File::delete($media->path);
		}
		//remove from DB
    	$media->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('media.index');
    }
}
