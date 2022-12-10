<?php

namespace App\Http\Controllers;

use App\Models\OrganizationMember;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrganizationMemberController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function get($id) {
        $data = OrganizationMember::where('organization_id', $id)->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    public function register_user(Request $request, $id)
    {
        $request->validate([
            'name' => ['string'],
            'email' => ['string', 'email', 'unique:users'],
            'password' => ['string'],
            'phone_number' => ['string'],
            'photo' => ['string'],
            'role_id' => ['integer']
        ]);

        try {
            $data = new User;
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->password = Hash::make($request->input('password'));
            $data->phone_number = $request->input('phone_number');
            $data->photo = $request->input('photo');
            $data->save();

            $member = new OrganizationMember;
            $member->organization_id = $id;
            $member->user_id = $data->id;
            $member->role_id = $request->input('role_id');
            $member->save();

            return response()->json([
                'code ' => 201,
                'message' => 'registered',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'error',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function edit_user(Request $request, $id)
    {
        $request->validate([
            'user_id' => ['required', 'integer'],
            'role_id' => ['integer']
        ]);

        try {
            $data = User::findOrfail($request->input('user_id'));
            $member = new OrganizationMember;
            $member->organization_id = $id;
            $member->user_id = $data->id;
            $member->role_id = $request->input('role_id');
            $member->save();

            return response()->json([
                'code ' => 200,
                'message' => 'success',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'error',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function create_admin(Request $request) {
        $request->validate([
            'organization_id' => ['required'],
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'phone_number' => ['required']
        ]);

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->phone_number = $request->input('phone_number');
            $user->photo = Str::random(10);
            $user->save();

            $role = Role::where('name', 'admin')->first();

            $data = new OrganizationMember;
            $data->organization_id = Auth::user()->organization_id;
            $data->user_id = $user->id;
            $data->role = $role->id;
            $data->save();

            return response()->json([
                'code' => 201,
                'message' => 'created',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'error',
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
