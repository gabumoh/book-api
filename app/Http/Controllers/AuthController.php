<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;

class AuthController extends Controller
{

    /**
     * login API
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

    	$input = $request->all();

    	$validator = Validator::make($input, [
    		'email' => 'required|email',
    		'password' => 'required',
    	]);

    	if ($validator->fails()) {
    		
    		return response()->json($validator->errors(), 417);

    	}

    	$credentials = $request->only(['email', 'password']);

    	if (Auth::attempt($credentials)) {
			
			$user = Auth::user();
			$success['token'] = $user->createToken('MyApp')->accessToken;

			return response()->json(['success' => $success], 200);
		}

		else {

			return response()->json(['error' => 'Unauthorized'], 401);
		}

    }

    /**
     * register API
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

    	$input = $request->all();

    	$validator = Validator::make($input, [
    		'name' => 'required',
			'email' => 'required|email',
			'password' => 'required',
			'c_password' => 'required|same:password',
    	]);

    	if ($validator->fails()) {
    		
    		return response()->json($validator->errors(), 417);

    	}

    	$user = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    	]);

    	$success['name'] = $user->name;
    	$success['token'] = $user->createToken('MyApp')->accessToken;

    	return response()->json(['success' => $success], 200);

    }

    /**
	 * admin login API
	 * @return \Illuminate\Http\Response
	 */
	public function adminLogin(Request $request)
	{

		$input = $request->all();

		$validator = Validator::make($input, [
			'email' => 'required|email',
			'password' => 'required',
		]);

		if ($validator->fails()) {
			
			return response()->json($validator->errors(), 417);
		}

		$credentials = $request->only(['email', 'password']);

		if (Auth::attempt($credentials)) {
			
			$user = Auth::user();
			$success['token'] = $user->createToken('MyApp', ['*'])->accessToken;

			return response()->json(['success' => $success], 200);
		}

		else {

			return response()->json(['error' => 'Unauthorized'], 401);
		}

	}

	/**
	 * admin register API
	 * @return \Illuminate\Http\Response
	 */
	public function adminRegister(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required',
			'c_password' => 'required|same:password',
		]);

		if ($validator->fails()) {
			
			return response()->json($validator->errors(), 417);

		}

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
		]);

		$success['name'] = $user->name;
		$success['token'] = $user->createToken('MyApp', ['*'])->accessToken;

		return response()->json(['success' => $success], 200);

	}

}
