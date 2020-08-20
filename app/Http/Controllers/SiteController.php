<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Location;
use App\Client;
use App\Site;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
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
       $sites= Site::with('clients')->where("active",1)->get();
	   $clients=Client::where("active",1)->get();
	 
	   if($request->ajax())
		{
			return DataTables::of($sites)
					->addColumn('action', function($sites){
						$button ='<button type="button"
						name="edit" id="'.$sites->id.'"
						class="edit btn btn-primary btn-sm edit
						"><img src="../css/img/edit-icon.png" /></button> ';
						$button .=' <button type="button"
						name="delete" id="'.$sites->id.'"
						class="delete btn btn-danger btn-sm delete
						"><img src="../css/img/remove-icon.png" /></button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('sites',compact('clients'));
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
		'site_name'=> 'required|regex:/^[a-zA-Z0-9 ]+$/|min:3|max:50|unique:sites,site_name,'.$request->id,
		'site_client'=> 'required'
		]);
		
		$siteCli=[];
        $site=Site::updateOrCreate(['id' => $request->id],['site_name' => $request->site_name, 'created_by'=>Auth::user()->id]); 
		$siteCli=$request->site_client;
		$site->clients()->sync($siteCli);
		return response()->json(['success'=>'Site Sucessfully Updated']);
		
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
        $Site = Site::find($id);
	    $site11=$Site->clients()->get()->pluck('pivot')->toArray();
		foreach($site11 as $cliid){ $lid[]=$cliid['client_id'];}
		$clientss=implode(',',$lid);
		$Site['clientss'] = $clientss;
        return response()->json($Site);
		
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
        Site::where("id", $id)->update(["active" => 0]);
		return response()->json(['success'=>'Site deleted!']);
		
    }
}
