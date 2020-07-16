<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function __construct(){
		//$this->middleware('auth');
	}
	
	public function getUser(Request $request){
		
	}
	
    public function viewUserData(Request $request){
		//dd(Auth::user());
		
		
		$getall=User::latest()->paginate();
	     
		return $getall;
		
	}
}
