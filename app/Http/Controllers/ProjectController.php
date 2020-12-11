<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use DB;
use App\Project;
use JWTAuth;

class ProjectsController extends Controller
{

    public function index(){

    	$Projects = DB::table('ldeq_projects')->get();
    	
    	return $Projects;	

    }

    public function details($Id){

    	return Project::find($Id);

    }

    public function create(Request $Request){

    	$Project = Project::create($request->all());
    	return response()->json($Project, 201);

    }

    public function update(Request $Request, $Id){

    	$Project = Project::findOrFail($Id);
    	$Project->update($Request->all());

    	return response()->json($Project, 200);

    }

    public function delete(Request $Request, $Id){

    	$Project = Project::findOrFail($Id);
    	$Project->delete();

    	return response()->json($Project, 204);

    }
}
