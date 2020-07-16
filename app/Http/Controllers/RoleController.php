<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\Location;
use App\BusinessUnit;
use DataTables;

class RoleController extends Controller
{
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
		
	      $rdata= Role::select([
          'roles.id',
          'business_unit',
	      'location',
          'client', 'site', 'agency'])
          ->join('business_units', 'business_units.id', '=', 'roles.business_unit_id')
	      ->join('locations', 'locations.id', '=', 'roles.location_id')
           ->get();
			return DataTables::of($rdata)
					->addColumn('action', function($rdata){
						$button ='<button type="button"
						name="edit" id="'.$rdata->id.'"
						class="edit btn btn-primary btn-sm edit
						">Edit</button> ';
						$button .=' <button type="button"
						name="delete" id="'.$rdata->id.'"
						class="delete btn btn-danger btn-sm delete
						">Delete</button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('roles',compact('business_ids'));
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
