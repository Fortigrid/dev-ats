<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function changePassword(Request $request){
		
		$userDet=User::where('id',Auth::user()->id)->get()->toArray();
		return view('profile.changePassword',compact('userDet'));
	}
	
	public function updatePassword(Request $request){
		
		
		$request->validate([
		 'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);
		$newPass=$request->password;
		$conPass=$request->password_confirmation;
		
		User::where('id',Auth::user()->id)->update(['password'=>bcrypt($newPass)]);
		return redirect('/edit-profile')->with('message', 'Password updated');
	}
}
