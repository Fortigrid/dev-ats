<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DataTables;
use App\User;
use App\Location;
use App\BusinessUnit;
use App\Client;
use App\Site;
use App\Agency;
use Illuminate\Support\Facades\Gate;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
		$user=Auth::user();
		Session::put('userdetails', $user);
		/* if($request->ajax())
		{
			if ($user->role=='admin')
			
			$data= User::latest('id')->where('status','1')->get(['id', 'username', 'email', 'role']);
		    elseif($user->role=='consult')
			
			$data= User::latest('id')->where('role','consult')->get(['id', 'username', 'email', 'role']);
			else
			
			$data= User::latest('id')->get(['id', 'username', 'email', 'role']);
			return DataTables::of($data)
					->addColumn('action', function($data){
						$button ='<button type="button"
						name="edit" id="'.$data->id.'"
						class="edit btn btn-primary btn-sm
						">Edit</button> ';
						$button1=' <button type="button"
						name="delete" id="'.$data->id.'"
						class="delete btn btn-danger btn-sm
						">Delete</button>';
						if(Gate::allows('view-user')){
							return $button . $button1;
						}
						else{
							return null;
						}
						
					})
					->rawColumns(['action'])
					->make(true);
		}
		
		
		
        return view('home');*/
		return redirect('/recruitment/managead');
    }
	
	public function getPivotval($ids,$mTab,$pTab,$field){
		
		 $values=[];
		 $totPival=[];
		 $val='';
		 $valArray=[];
		 $values=$mTab::find($ids);
		 //echo $vv="$values->$pTab";
		
		 foreach($values as $value){
			
			if($pTab=='clients()')
			$totPival[]=$value->clients()->get()->pluck('pivot')->toArray();
			if($pTab=='sites()')
			$totPival[]=$value->sites()->get()->pluck('pivot')->toArray();
			if($pTab=='agencies()')
			$totPival[]=$value->agencies()->get()->pluck('pivot')->toArray();
		  }
		 foreach($totPival as $getVal){
			  foreach($getVal as $valId) $valArray[]=$valId[$field];
			  
		 }
		  $val=implode(',',array_unique($valArray));
		  
		  return $val;
		
	}
	
	public function getval(Request $request){
		$ff=[];
		if($request->business_unit !=''){
		
		 //$vv=Location::whereIN('business_unit_id',$request->business_unit)->get('id')->toArray();
		 foreach($request->business_unit as $colname)
		 $vv[]=DB::table('locations')->whereRaw('FIND_IN_SET(?,business_unit_id)', [$colname])->get('id');
		 $hh=json_decode(json_encode($vv), true);
		 foreach($hh as $ids) 
		 {
			foreach($ids as $id)
			
			$ff[]=json_decode(json_encode($id['id']), true);
		 }
		 $mm=implode(',',array_unique($ff));
		 $getv['loc']=implode(',',$ff);
		 $nn=explode(',',$mm);
		 $mTab='App\Location';
		 $pTab="clients()";
		 $field='client_id';
		 $getv['client']=$this->getPivotval($nn,$mTab,$pTab,$field);
		 
		 $nn1=explode(',',$getv['client']);
		 $mTab1='App\Client';
		 $pTab1="sites()";
		 $field1='site_id';
		 $getv['site']=$this->getPivotval($nn1,$mTab1,$pTab1,$field1);
		  
		 $nn2=explode(',',$getv['site']);
		 $mTab2='App\Site';
		 $pTab2="agencies()";
		 $field2='agency_id';
		 $getv['agency']=$this->getPivotval($nn2,$mTab2,$pTab2,$field2);
         
		 
		return response()->json($getv);
		}
		else{
			return response()->json();
		}
	}
}
