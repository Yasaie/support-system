<?php

namespace App\Http\Controllers\Config;

use App\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{

	/**
	 * ConfigController constructor.
	 */
	public function __construct(){
		$this->middleware('auth');
	}

	protected function generalConfigsName(){
    	return [
			'site_name',
			'site_logo_src',
			'site_logo_alt',
			'main_address',
			/*'site_address',*/
			'site_description',
			'site_keywords',
			'site_rules',
			'site_landing_page_status',
			'site_guest_ticket_status',
			'site_registration_status',
			'email_verification_status',
			'mobile_verification_status',
			'email_notification_status',
			'sms_notification_status',
		];
	}

    /**
     * Display a listing of the resource.
     *
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function generalConfigs()
    {
    	// Check policy
    	$this->authorize('general',Config::class);

		$names=$this->generalConfigsName();
		$configs=Config::whereIn('name',$names)->get();
        if(request()->expectsJson()){
        	return response()->json($configs);
        }

        return view('config.general')->with('configs',$configs);
    }

	public function validateGeneralConfigs(Request $request){
		return Validator::make($request->all(),[
			'site_name' => 'nullable',
			'site_logo_src' => 'nullable|url',
			'site_logo_alt' => 'nullable|string',
			'main_address' => 'nullable|url',
			'site_address' => 'nullable|url',
			'site_description' => 'nullable|string',
			'site_keywords' => 'nullable|string',
			'site_rules' => 'required|string|min:50',
			'site_landing_page_status' => 'nullable|boolean',
			'site_guest_ticket_status' => 'nullable|boolean',
			'site_registration_status' => 'nullable|boolean',
			'email_verification_status' => 'nullable|boolean',
			'mobile_verification_status' => 'nullable|boolean',
			'email_notification_status' => 'nullable|boolean',
			'sms_notification_status' => 'nullable|boolean',
		]);
	}

	/**
     * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function updateGeneralConfigs(Request $request)
    {
    	// Check policy
    	$this->authorize('general',Config::class);

        $validator=$this->validateGeneralConfigs($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$names=$this->generalConfigsName();
		foreach($names as $name){
			$config=Config::where('name','=',$name)->get();
			if($config->isEmpty()){
				continue;
			}

			$data=[
				'value'=>$request->input($name),
			];

			$config->first()->update($data);
		}

        $configs=Config::whereIn('name',$names);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'configs'=>$configs,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('config.general');
    }

	protected function emailConfigsName(){
    	return [
			'site_main_email',
			'site_activities_email',
			'site_smtp_server',
			'site_smtp_port',
			'site_smtp_username',
			'site_smtp_password',
		];
	}

    /**
     * Display a listing of the resource.
     *
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function emailConfigs()
    {
    	// Check policy
    	$this->authorize('email',Config::class);

    	$names=$this->emailConfigsName();
        $configs=Config::whereIn('name',$names)->get();
        if(request()->expectsJson()){
        	return response()->json($configs);
        }
        return view('config.email')->with('configs',$configs);
    }

	public function validateEmailConfigs(Request $request){
		return Validator::make($request->all(),[
			'site_main_email'=>'nullable|email',
			'site_activities_email'=>'nullable|email',
			'site_smtp_server'=>'nullable|string',
			'site_smtp_port'=>'nullable|numeric',
			'site_smtp_username'=>'nullable|string',
			'site_smtp_password'=>'nullable|string',
		]);
	}

	/**
     * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function updateEmailConfigs(Request $request)
    {
    	// Check policy
    	$this->authorize('email',Config::class);

        $validator=$this->validateEmailConfigs($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$names=$this->emailConfigsName();
		foreach($names as $name){
			$config=Config::where('name','=',$name)->get();
			if($config->isEmpty()){
				continue;
			}

			$data=[
				'value'=>$request->input($name),
			];

			$config->first()->update($data);
		}

        $configs=Config::whereIn('name',$names);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'configs'=>$configs,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('config.email');
    }

	protected function ticketConfigsName(){
    	return [
			'ticket_remove_status',
			'ticket_attachment_status',
			'ticket_attachment_file_formats',
			'ticket_attachment_file_size',
			'ticket_attachment_file_count',
			'ticket_department_substitution_status',
			'ticket_rating_status',
			'user_close_ticket_status',
			'staff_close_ticket_status',
			'user_remove_ticket_status',
			'staff_remove_ticket_status',
		];
	}

	/**
	 * accepted file formats
	 *
	 * @return array
	 */
	public function attachmentFileFormats(){
    	return [
			'jpg',
			'jpeg',
			'png',
			'txt',
			'html',
			'css',
			'js',
			'json',
			'xml',
			'pdf',
			'psd',
			'al',
			'doc',
			'rtf',
			'ppt',
			'rar',
			'zip',
			'gif',
			'tif',
			'webp',
		];
	}

    /**
     * Display a listing of the resource.
     *
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function ticketConfigs()
    {
    	// Check policy
    	$this->authorize('ticket',Config::class);

    	$names=$this->ticketConfigsName();
        $configs=Config::whereIn('name',$names)->get();
        if(request()->expectsJson()){
        	return response()->json($configs);
        }
        return view('config.ticket')->with(['configs'=>$configs,'attachment_file_formats'=>$this->attachmentFileFormats()]);
    }

	/**
	 * validate ticket configs
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function validateTicketConfigs(Request $request){
		return Validator::make($request->all(),[
			'ticket_remove_status' => 'nullable|boolean',
			'ticket_attachment_status' => 'nullable|boolean',
			'ticket_attachment_file_formats' => 'required|array|in:'.implode(',',$this->attachmentFileFormats()),
			'ticket_attachment_file_size' => 'required|numeric',
			'ticket_attachment_file_count' => 'required|numeric',
			'ticket_department_substitution_status' => 'nullable|boolean',
			'ticket_rating_status' => 'nullable|boolean',
			'user_close_ticket_status' => 'nullable|boolean',
			'staff_close_ticket_status' => 'nullable|boolean',
			'user_remove_ticket_status' => 'nullable|boolean',
			'staff_remove_ticket_status' => 'nullable|boolean',
		]);
	}

	/**
     * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function updateTicketConfigs(Request $request)
    {
    	// Check policy
    	$this->authorize('ticket',Config::class);

        $validator=$this->validateTicketConfigs($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$names=$this->ticketConfigsName();
		foreach($names as $name){
			$config=Config::where('name','=',$name)->get();
			if($config->isEmpty()){
				continue;
			}

			switch($name){
				case 'ticket_attachment_file_formats':
					//array value
					$data=$request->input($name);

					if(is_array($data)){
						$data=implode('|',$data);
					}

					$data=[
						'value'=>$data,
					];

				break;

				default:
					$data=[
						'value'=>$request->input($name),
					];
				break;
			}

			$config->first()->update($data);
		}

        $configs=Config::whereIn('name',$names);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'configs'=>$configs,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('config.ticket');
    }

	/**
	 * @return array
	 */
	protected function smsConfigsName(){
    	return [
			'site_sms_username',
			'site_sms_password',
			'site_sms_number',
		];
	}

    /**
     * Display a listing of the resource.
     *
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function smsConfigs()
    {
    	// Check policy
    	$this->authorize('sms',Config::class);

    	$names=$this->smsConfigsName();
        $configs=Config::whereIn('name',$names)->get();
        if(request()->expectsJson()){
        	return response()->json($configs);
        }
        return view('config.sms')->with('configs',$configs);
    }

	public function validateSmsConfigs(Request $request){
		return Validator::make($request->all(),[
			'site_sms_username' => 'required|string',
			'site_sms_password' => 'required|string',
			'site_sms_number' => 'required|string',
		]);
	}

	/**
     * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function updateSmsConfigs(Request $request)
    {
    	// Check policy
    	$this->authorize('sms',Config::class);

        $validator=$this->validateSmsConfigs($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$names=$this->smsConfigsName();
		foreach($names as $name){
			$config=Config::where('name','=',$name)->get();
			if($config->isEmpty()){
				continue;
			}

			$data=[
				'value'=>$request->input($name),
			];

			$config->first()->update($data);
		}

        $configs=Config::whereIn('name',$names);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'configs'=>$configs,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('config.sms');
    }





	/**
	 * @return array
	 */
	protected function templateConfigsName(){
    	return [
			'widget1_title',
			'widget1_content',

			'widget2_title',
			'widget2_content',

			'widget3_title',
			'widget3_content',
		];
	}

    /**
     * Display a listing of the resource.
     *
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function templateConfigs()
    {
    	// Check policy
    	$this->authorize('template',Config::class);

    	$names=$this->templateConfigsName();
        $configs=Config::whereIn('name',$names)->get();
        if(request()->expectsJson()){
        	return response()->json($configs);
        }
        return view('config.template')->with('configs',$configs);
    }

	public function validateTemplateConfigs(Request $request){
		return Validator::make($request->all(),[
			'widget1_title'=>'required|string',
			'widget1_content'=>'required|string',

			'widget2_title'=>'required|string',
			'widget2_content'=>'required|string',

			'widget3_title'=>'required|string',
			'widget3_content'=>'required|string',
		]);
	}

	/**
     * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function updateTemplateConfigs(Request $request)
    {
    	// Check policy
    	$this->authorize('template',Config::class);

        $validator=$this->validateTemplateConfigs($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$names=$this->templateConfigsName();
		foreach($names as $name){
			$config=Config::where('name','=',$name)->get();
			if($config->isEmpty()){
				continue;
			}

			$data=[
				'value'=>$request->input($name),
			];

			$config->first()->update($data);
		}

        $configs=Config::whereIn('name',$names);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'configs'=>$configs,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('config.template');
    }
}
