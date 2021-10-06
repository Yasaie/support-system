<?php

namespace App\Http\Controllers\Rate;

use App\Rate;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RateController extends Controller
{

	/**
	 * CountryController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * validate rate request
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function validateRate(Request $request){
		return Validator::make($request->all(),[
			'id'	=>'required|numeric',
			'type'	=>'required|in:users,tickets',
			'rate' 	=>'required|numeric',
		]);
	}

	/**
	 * validate if rateable item is exists
	 *
	 * @param Request $request
	 * @param $table
	 * @return mixed
	 */
	public function validateRateable(Request $request,$table){
		return Validator::make($request->all(),[
			'id'=>'required|exists:'.$table.',id,deleted_at,NULL',
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
    public function store(Request $request){
        $validator=$this->validateRate($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$id=$request->input('id');
		$type=$request->input('type');//type == table's name
		$rate=$request->input('rate');

        $validator=$this->validateRateable($request,$type);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'rate'=>$rate,
			'user_id'=>Auth::id(),
		];

		switch($type){
			case 'users': //rate users
				$rate=User::find($id)->rates()->where('user_id',$data['user_id'])->first();
				if($rate){
					//update former rate
					$rate->update($data);
				}else{
					//add new rate
					$rate=User::find($id)->rates()->create($data);
				}
				break;
			case 'tickets': //rate tickets

				$ticket=Ticket::find($id);

				$rate=$ticket->rates()->where('user_id',$data['user_id'])->first();
				if($rate){
					//update former rate
					$rate->update($data);
				}else{
					//add new rate
					$rate=Ticket::find($id)->rates()->create($data);
				}

				break;
		}

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'rate'=>$rate,
			]);
        }

        Session::flash('success',$status);

		return redirect()->back()->with($request->all());
    }

}
