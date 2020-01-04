<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;

class ProjectController extends Controller
{
    public function store(){
    	$files = Request::file('file');
    	// $firstline = fopen($files, 'r');

		$csv = str_getcsv(file_get_contents($files));    	
    	// dd($csv);
    	// dd($files);


    	// return response()->json(compact('csv'));
    	return view('home', compact('csv'));
    }
}
