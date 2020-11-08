<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use JWTAuth;

class JobsController extends Controller
{

    public function index(){

    	$JobsList = DB::table('jobs')->get();
    	
    	return $JobsList;	

    }

    public function details($Id){

    	return Job::find($Id);

    }

    public function create(Request $Request){

    	$Job = Job::create($request->all());
    	return response()->json($Job, 201);

    }

    public function update(Request $Request, $Id){

    	$Job = Job::findOrFail($Id);
    	$Job->update($Request->all());

    	return response()->json($Job, 200);

    }

    public function delete(Request $Request, $Id){

    	$Job = Job::findOrFail($Id);
    	$Job->delete();

    	return response()->json($Job, 204);

    }
}
