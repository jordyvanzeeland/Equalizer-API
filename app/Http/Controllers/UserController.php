<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use DB; 

    class UserController extends Controller {

        public function index(){

            $UsersList = DB::table('users')->get();
            
            return $UsersList;   

        }

        // public function authenticate(Request $request)
        // {
        //     $credentials = $request->only('username', 'password');

        //     $user = DB::table('ldeq_users')->where('username', $credentials['username'])->first();
        //     if (!$user || !Hash::check($credentials['password'], $user->password)) {
        //         return response()->json(['error' => 'Invalid credentials'], 401);
        //     }

        //     $token = JWTAuth::fromUser($user);

        //     return response()->json(compact('token'));
        // }

        public function authenticate(Request $request) {
            $credentials = $request->only('username', 'password');

            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }

        public function register(Request $request) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }

        public function getAuthenticatedUser() {
	            try {

	                if (! $user = JWTAuth::parseToken()->authenticate()) {
	                        return response()->json(['user_not_found'], 404);
	                }

	            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

	                    return response()->json(['token_expired'], $e->getStatusCode());

	            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

	                    return response()->json(['token_invalid'], $e->getStatusCode());

	            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

	                    return response()->json(['token_absent'], $e->getStatusCode());

	            }

	            return response()->json(compact('user'));
            }
    }