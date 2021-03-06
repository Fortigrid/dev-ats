<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Location;
use App\BusinessUnit;
use App\Client;
use App\Site;
use App\Agency;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
		#$business_ids= BusinessUnit::where("active",1)->get()->toArray();
		$business_ids = Cache::remember('bus', 60, function () {
			return BusinessUnit::where("active",1)->get()->toArray();
		});
		#$locations=Location::where("loc",1)->get();
		$locations = Cache::remember('loc', 60, function () {
			return Location::where("active",1)->get();
		});
		#$clients= Client::with('locations')->where("active",1)->get();
		$clients = Cache::remember('cli', 60, function () {
			return Client::with('locations')->where("active",1)->get();
		});
		
		#$sites= Site::with('clients')->where("active",1)->get();
		$sites = Cache::remember('sit', 60, function () {
			return Site::with('clients')->where("active",1)->get();
		});
		
		#$agencies= Agency::with('sites')->where("active",1)->get();
		$agencies = Cache::remember('ag', 60, function () {
			return Agency::with('sites')->where("active",1)->get();
		});
		
		$rdata = Cache::remember('rol', 60, function () {
			return Role::where("active",1)->get();
		});
		
        if($request->ajax())
		{
			#$rdata=Role::all();
			
	      
			return DataTables::of($rdata)
					->addColumn('action', function($rdata){
						$button ='<button type="button"
						name="edit" id="'.$rdata->id.'"
						class="edit btn btn-primary btn-sm edit
						"><img src="../css/img/edit-icon.png" /></button> ';
						$button .=' <button type="button"
						name="delete" id="'.$rdata->id.'"
						class="delete btn btn-danger btn-sm delete
						"><img src="../css/img/remove-icon.png" /></button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('roles',compact('business_ids','locations','clients','sites','agencies'));
		
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
		'role_name'=> 'required|unique:roles,role_name,'.$request->id,
		'role_business_unit'=> 'required',
		'role_location'=> 'required',
		'role_client'=> 'required',
		'role_site'=> 'required',
		'role_agency'=> 'required'
		]);
		
		$roleLoc=[];
		$roleCli=[];
		$roleSite=[];
		$roleAgen=[];
		$roleBus=[];
        $role=Role::updateOrCreate(['id' => $request->id],['role_name' => $request->role_name, 'created_by'=>Auth::user()->id ]);
		//location
		$roleLoc=$request->role_location;
		$role->locations()->sync($roleLoc);
		//client
		$roleCli=$request->role_client;
		$role->clients()->sync($roleCli);
		//site
		$roleSite=$request->role_site;
		$role->sites()->sync($roleSite);
		//agency
		$roleAgency=$request->role_agency;
		$role->agencies()->sync($roleAgency);
		//businessunit
		$roleBus=$request->role_business_unit;
		$role->business_units()->sync($roleBus);
		
		return response()->json(['success'=>'Role Sucessfully Updated']);
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
		$lid=$cid=$sid=$aid=$bid=[];
		//Getting client and its location from pivot table
        $Role = Role::find($id);
	    //location
		$role1=$Role->locations()->get()->pluck('pivot')->toArray();
		foreach($role1 as $locid){ $lid[]=$locid['location_id'];}
		$locations=implode(',',$lid);
		$Role['locations'] = $locations;
		
		//client
		$role2=$Role->clients()->get()->pluck('pivot')->toArray();
		foreach($role2 as $locid1){ $cid[]=$locid1['client_id'];}
		$clients=implode(',',$cid);
		$Role['clients'] = $clients;
		
		//site
		$role3=$Role->sites()->get()->pluck('pivot')->toArray();
		foreach($role3 as $locid2){ $sid[]=$locid2['site_id'];}
		$sites=implode(',',$sid);
		$Role['sites'] = $sites;
		
		//agency
		$role4=$Role->agencies()->get()->pluck('pivot')->toArray();
		foreach($role4 as $locid3){ $aid[]=$locid3['agency_id'];}
		$agencies=implode(',',$aid);
		$Role['agencies'] = $agencies;
		
		//business_ids
		$role5=$Role->business_units()->get()->pluck('pivot')->toArray();
		foreach($role5 as $locid4){ $bid[]=$locid4['business_unit_id'];}
		$business=implode(',',$bid);
		$Role['business'] = $business;
		
		
        return response()->json($Role);
		
		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     
        //Client::find($id)->delete();
		Role::where("id", $id)->update(["active" => 0]);

        return response()->json(['success'=>'Role deleted!']);
		
    }
}
