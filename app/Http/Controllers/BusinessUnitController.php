<?php

namespace App\Http\Controllers;

use App\BusinessUnit;
use Illuminate\Http\Request;
use DataTables;


class BusinessUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$data= BusinessUnit::latest()->get();
		
        if($request->ajax())
		{
			//$data= BusinessUnit::latest()->get();
			return DataTables::of($data)
					->addColumn('action', function($data){
						$button ='<button type="button"
						name="edit" id="'.$data->id.'"
						class="edit btn btn-primary btn-sm edit
						">Edit</button> ';
						$button .=' <button type="button"
						name="delete" id="'.$data->id.'"
						class="delete btn btn-danger btn-sm delete
						">Delete</button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('business_units',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get Method
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
        'business_unit' => 'required|unique:business_units,business_unit,'.$request->id      
		]);
        
		BusinessUnit::updateOrCreate(['id' => $request->id],['business_unit' => $request->business_unit]);
		return response()->json(['success'=>'Bsuiness saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessUnit $businessUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessUnit $businessUnit)
    {
		$id = explode('/', $_SERVER['REQUEST_URI']);
        $Business = BusinessUnit::find($id[2]);
        return response()->json($Business);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessUnit $businessUnit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessUnit $businessUnit)
    {
		$id = explode('/', $_SERVER['REQUEST_URI']);
        BusinessUnit::find($id[2])->delete();
        return response()->json(['success'=>'Customer deleted!']);
    }
}
