<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DataTables;
use App\User;
use Illuminate\Support\Facades\Gate;

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
		 if($request->ajax())
		{
			if ($user->user_role=='admin')
			$data= User::latest()->get(['id', 'name', 'email', 'user_role']);
		    elseif($user->user_role=='client')
			$data= User::latest()->where('user_role','client')->get(['id', 'name', 'email', 'user_role']);
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
		
		
		
        return view('home');
    }
}
