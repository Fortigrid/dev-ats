<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Location;
use App\Client;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
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
		
       $clients= Client::with('locations')->where("active",1)->get();
	   $locations=Location::where("active",1)->get();
	   if($request->ajax())
		{
			return DataTables::of($clients)
					->addColumn('action', function($clients){
						$button ='<button type="button"
						name="edit" id="'.$clients->id.'"
						class="edit btn btn-primary btn-sm edit
						"><img src="../css/img/edit-icon.png" /></button> ';
						$button .=' <button type="button"
						name="delete" id="'.$clients->id.'"
						class="delete btn btn-danger btn-sm delete
						"><img src="../css/img/remove-icon.png" /></button>';
						return $button;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('clients',compact('locations'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //return response()->json(['success'=>$request->client_location]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
	 //'location_id' => 'required|exists:client_location,location_id'
    public function store(Request $request)
    {
		$request->validate([
		'client_name'=> 'required|regex:/^[a-zA-Z0-9 ]+$/|min:3|max:50|unique:clients,client_name,'.$request->id,
		'client_location' => 'required'
		]);
		
		$cliLoc=[];
        $client=Client::updateOrCreate(['id' => $request->id],['client_name' => $request->client_name, 'created_by'=>Auth::user()->id ]);
		$cliLoc=$request->client_location;
		$client->locations()->sync($cliLoc);
		return response()->json(['success'=>'Client Sucessfully Updated']);
		
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
		//Getting client and its location from pivot table
        $Client = Client::find($id);
	    $client1=$Client->locations()->get()->pluck('pivot')->toArray();
		//print_r($client1);
		foreach($client1 as $locid){ $lid[]=$locid['location_id'];}
		$locationss=implode(',',$lid);
		$Client['locationss'] = $locationss;
        return response()->json($Client);
		
		
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
		
        //Client::find($id)->delete();
		Client::where("id", $id)->update(["active" => 0]);

        return response()->json(['success'=>'Client deleted!']);
		
    }
}
