<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Location;
use App\Client;
use App\Site;
use App\Agency;
use DataTables;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
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
       $agencies= Agency::with('sites')->where("active",1)->get();
	   $sites=Site::where("active",1)->get();
	   if($request->ajax())
		{
			return DataTables::of($agencies)
					->addColumn('action', function($agencies){
						$button ='<button type="button"
						name="edit" id="'.$agencies->id.'"
						class="edit btn btn-primary btn-sm edit
						">Edit</button> ';
						$button .=' <button type="button"
						name="delete" id="'.$agencies->id.'"
						class="delete btn btn-danger btn-sm delete
						">Delete</button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('agencies',compact('sites'));
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
		'agency_name'=> 'required|unique:agencies,agency_name,'.$request->id,
		'agency_site'=> 'required'
		]);
		
		$agenSite=[];
        $agency=Agency::updateOrCreate(['id' => $request->id],['agency_name' => $request->agency_name, 'created_by'=>Auth::user()->id]); 
		$agenSite=$request->agency_site;
		$agency->sites()->sync($agenSite);
		return response()->json(['success'=>'Agency Sucessfully Updated']);
		
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
		
		$lid=array();
        $Agency = Agency::find($id);
	    $agen11=$Agency->sites()->get()->pluck('pivot')->toArray();
		foreach($agen11 as $cliid){ $lid[]=$cliid['site_id'];}
		$sitess=implode(',',$lid);
		$Agency['sitess'] = $sitess;
        return response()->json($Agency);
		
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
	 
       Agency::where("id", $id)->update(["active" => 0]);
	   return response()->json(['success'=>'Agency deleted!']);
	 
    }
}
