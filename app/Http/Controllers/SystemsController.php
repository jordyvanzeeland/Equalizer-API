<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use DB;
use App\System;
use JWTAuth;

class SystemsController extends Controller
{

	public function encrypt_decrypt($action, $string) {
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'This is my secret key';
		$secret_iv = 'This is my secret iv';
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

    	$Systems = DB::table('ldeq_systems')->get();
    	
    	return $Systems;	

    }

    public function details($Id){

    	$System = System::find($Id);
		$System->system_password = $this->encrypt_decrypt('decrypt', $System->system_password);

    	return $System;

    }

    public function create(Request $Request){

		$EncryptedPass = $this->encrypt_decrypt('encrypt', $Request->header('systempass'));

		$System = DB::table('ldeq_systems')->insert([
			'system_name' => $Request->header('systemname'),
			'system_url' => $Request->header('systemurl'),
			'system_username' => $Request->header('systemuser'),
			'system_password' => $EncryptedPass
		]);

    	return response()->json($System, 201);

    }

    public function update(Request $Request, $Id){

    	$EncryptedPass = $this->encrypt_decrypt('encrypt', $Request->header('systempass'));

		$System = DB::table('ldeq_systems')->where('id', $Id)->update([
			'system_name' => $Request->header('systemname'),
			'system_url' => $Request->header('systemurl'),
			'system_username' => $Request->header('systemuser'),
			'system_password' => $EncryptedPass
		]);

    	return response()->json($System, 200);

    }

    public function delete(Request $Request, $Id){

    	$Project = DB::table('ldeq_systems')->where('id', $Id)->delete();

    	return response()->json("OK");

    }
}
