<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
     /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login']);
    }

    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $customer = Customer::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        $token = JWTAuth::fromUser($customer);

        if($customer) {
            return response()->json([
                'success' => true,
                'user'    => $customer,
                'token'   => $token
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email or Password is incorrect'
            ], 401);
        }
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 201);
    }

    /**
     * getUser
     *
     * @return void
     */
    public function refreshToken(Request $request)
    {
        //refresh "token"
        $refreshToken = JWTAuth::refresh(JWTAuth::getToken());

        //set user dengan "token" baru
        $user = JWTAuth::setToken($refreshToken)->toUser();

        //set header "Authorization" dengan type Bearer + "token" baru
        $request->headers->set('Authorization','Bearer '.$refreshToken);

        //response data "user" dengan "token" baru
        return response()->json([
            'success' => true,
            'user'    => $user,
            'token'   => $refreshToken,  
        ], 200);
    }

    public function getUser()
    {
        return response()->json([
            'success' => true,
            'user'    => auth()->user()
        ], 200);
    }

    public function updateProfile(Request $request){

        $auth = auth()->guard('api')->user();
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|unique:customers,email,'.$auth->id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $update = Customer::find($auth->id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->save();

        if($update) {

            return response()->json([
                'success' => true,
                'message' => 'update Customer Berhasil',
                'user'    => auth()->user()
            ], 200);
            //return with Api Resource

        }

        return response()->json([
            'success' => false,
            'message' => 'update Customer Gagal',
            'user'    => auth()->user()
        ], 201);

        //return failed with Api Resource
        // return new CustomerResource(false, 'Register Customer Gagal!', null);
    }

    public function updatePassword(Request $request)
    {
        // Validasi request
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->guard('api')->user();

        // Periksa apakah password lama sesuai
        if (!Hash::check($request->oldpassword, $user->password)) {
            return response()->json(['error' => 'Password lama tidak sesuai'], 422);
        }

        // Update password pengguna
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'update Password Customer Berhasil',
            'user'    => auth()->user()
        ], 200);
    }
}
