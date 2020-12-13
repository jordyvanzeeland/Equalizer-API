<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use DB;
use App\System;
use JWTAuth;

class SystemsController extends Controller
{

    public function index(){

    	$Systems = DB::table('ldeq_systems')->get();
    	
    	return $Systems;	

    }

    public function details($Id){

    	return System::find($Id);

    }

    public function create(Request $Request){

    	$System = System::create($request->all());
    	return response()->json($System, 201);

    }

    public function update(Request $Request, $Id){

    	$System = System::findOrFail($Id);
    	$System->update($Request->all());

    	return response()->json($System, 200);

    }

    public function delete(Request $Request, $Id){

    	$System = System::findOrFail($Id);
    	$System->delete();

    	return response()->json($System, 204);

    }
}
