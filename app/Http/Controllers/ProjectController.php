<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use DB;
use App\Project;
use JWTAuth;

class ProjectsController extends Controller
{

	public function encrypt_decrypt($action, $string) {

		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'This is my secret key';
		$secret_iv = 'This is my secret iv';
		// hash
		$key = hash('sha256', $secret_key);

		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if( $action == 'decrypt' ) {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

    public function index(){

		$Projects = DB::table('ldeq_projects')->get();
    	
    	return $Projects;	

    }

    public function details($Id){

		$Project = Project::find($Id);
		$Project->FtpPass = $this->encrypt_decrypt('decrypt', $Project->FtpPass);
		$Project->DbPass = $this->encrypt_decrypt('decrypt', $Project->DbPass);
		$Project->WpPass = $this->encrypt_decrypt('decrypt', $Project->WpPass);
    	return ['data' => $Project];

    }

    public function create(Request $Request){

		$EncryptedFtpPass = $this->encrypt_decrypt('encrypt', $Request->header('projectftppass'));
		$EncryptedDbPass = $this->encrypt_decrypt('encrypt', $Request->header('projectdbpass'));
		$EncryptedWpPass = $this->encrypt_decrypt('encrypt', $Request->header('projectwppass'));

		$Project = DB::table('ldeq_projects')->insert([
			'ProjectName' => $Request->header('projectname'),
			'ProjectUrl' => $Request->header('projecturl'),
			'FtpHost' => $Request->header('projectftphost'),
			'FtpUser' => $Request->header('projectftpuser'),
			'FtpPass' => $EncryptedFtpPass,
			'DbHost' => $Request->header('projectdbhost'),
			'DbUser' => $Request->header('projectdbuser'),
			'DbPass' => $EncryptedDbPass,
			'WpUser' => $Request->header('projectwpuser'),
			'WpPass' => $EncryptedWpPass
		]);

    	return response()->json($Project, 201);

    }

    public function update(Request $Request, $Id){

		$EncryptedFtpPass = $this->encrypt_decrypt('encrypt', $Request->header('projectftppass'));
		$EncryptedDbPass = $this->encrypt_decrypt('encrypt', $Request->header('projectdbpass'));
		$EncryptedWpPass = $this->encrypt_decrypt('encrypt', $Request->header('projectwppass'));

		$Project = DB::table('ldeq_projects')->where('Id', $Id)->update([
			'ProjectName' => $Request->header('projectname'),
			'ProjectUrl' => $Request->header('projecturl'),
			'FtpHost' => $Request->header('projectftphost'),
			'FtpUser' => $Request->header('projectftpuser'),
			'FtpPass' => $EncryptedFtpPass,
			'DbHost' => $Request->header('projectdbhost'),
			'DbUser' => $Request->header('projectdbuser'),
			'DbPass' => $EncryptedDbPass,
			'WpUser' => $Request->header('projectwpuser'),
			'WpPass' => $EncryptedWpPass
		]);

		// $Project->update($Request->all());

    	return response()->json($Project, 200);

    }

    public function delete(Request $Request, $Id){
		
		$Project = DB::table('ldeq_projects')->where('id', $Id)->delete();

    	return response()->json("OK");

    }
}
