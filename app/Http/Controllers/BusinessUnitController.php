<?php

namespace App\Http\Controllers;

use App\BusinessUnit;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class BusinessUnitController extends Controller
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
		
		$data= BusinessUnit::where('active',1)->latest()->get();
		
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
        
		BusinessUnit::updateOrCreate(['id' => $request->id],['business_unit' => $request->business_unit, 'created_by' => Auth::user()->id]);
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
		
		preg_match_all('!\d+!', $_SERVER['REQUEST_URI'], $matches);
		$getId=implode($matches[0]);
        $Business = BusinessUnit::find($getId);
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
		
		
		preg_match_all('!\d+!', $_SERVER['REQUEST_URI'], $matches);
        //BusinessUnit::find($id[2])->delete();
		BusinessUnit::where("id", $matches)->update(["active" => 0]);
        return response()->json(['success'=>'Business unit deleted!']);
		
    }
}
