<?php

namespace App\Http\Controllers;

use App\Location;
use App\BusinessUnit;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
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
	  $business_ids= BusinessUnit::all(['id','business_unit'])->toArray();
	  if($request->ajax())
		{
			$vv= Location::select([
			'locations.id',
			DB::raw("GROUP_CONCAT(business_unit SEPARATOR ',') as `business_unit`"),
			'state',
			'location'])
			->join('business_units', DB::raw("find_in_set(business_units.id, locations.business_unit_id)"),">",DB::raw("'0'"))
			->where('locations.active',1)
			->groupBy('locations.id')
			->get();
			
			return DataTables::of($vv)
					->addColumn('action', function($vv){
						$button ='<button type="button"
						name="edit" id="'.$vv->id.'"
						class="edit btn btn-primary btn-sm edit
						">Edit</button> ';
						$button .=' <button type="button"
						name="delete" id="'.$vv->id.'"
						class="delete btn btn-danger btn-sm delete
						">Delete</button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('locations',compact('business_ids'));
	  
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
	 //'location' => 'required|unique:locations,location,NULL,state,location,'.$request->id
	 //'location' => 'required',
   # Rule::unique('locations')->ignore($request->location)->where(function ($query) {$query->where('state', $request->state);
    public function store(Request $request)
    {
		$request->validate([
		'business_unit_id'=> 'required',
		'state'=> 'required',
		'location' => 'required|unique:locations,location,'.$request->id
		]);
        
		$location = new Location;
		Location::updateOrCreate(['id' => $request->id],['business_unit_id' => $request->business_unit_id, 'state' => $request->state, 'location' => $request->location, 'created_by'=>Auth::user()->id]);        
        return response()->json(['success'=>'Location saved successfully!']);
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
		
        $Location = Location::find($location->id);
        return response()->json($Location);
		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
		
        #Location::find($location->id)->delete();
		Location::where("id", $location->id)->update(["active" => 0]);
        return response()->json(['success'=>'Location deleted!']);
		
    }
}
