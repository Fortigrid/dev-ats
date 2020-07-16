<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class SinglePageController extends Controller
{
    public function index() {
	
    return view('layouts.master');
}
}
