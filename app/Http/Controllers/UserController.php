<?php

namespace App\Http\Controllers;

use App\Models\OrganizationMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'login', 
            'logout',
        ]]);
    }

    public function login(Request $request) {
        try {
            $request->validate([
                'email' => ['required','email'],
                'password' => ['required'],
            ]);
            $email = $request->input('email');
            $password = $request->input('password');
            $data = User::where('email', $email)->first();
    
            if(Hash::check($password, $data->password))
            {
                if(! $token = auth()->login($data)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                } else {
                    $user = User::where('email', $request->email)->first();
                    $user->save();
                    return $this->respondWithToken($token, $data);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Login failed'
                ],401);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'Login failed'
            ],401);
        }
    }

    public function edit(Request $request, $id) {
        $request->validate([
            'name' => ['string'],
            'email' => ['string', 'email'],
            'password' => ['string'],
            'phone_number' => ['string'],
            'photo' => ['string']
        ]);

        try {
            $data = User::findOrFail($id);
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->password = Hash::make($request->input('password'));
            $data->phone_number = $request->input('phone_number');
            $data->photo = $request->input('photo');
            $data->save();

            return response()->json([
                'code ' => 200,
                'message' => 'success',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'failed',
                'data' => $e
            ], 500);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$data)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'data' => $data
        ]);
    }
}
