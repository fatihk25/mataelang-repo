<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function detail($id) {
        $data = Asset::find($id);
        return response()->json([
            'code' => 200,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'organization_id' => ['required'],
            'sensor_id' => ['required'],
            'pic'=> ['required'],
            'description' => ['required']
        ]);

        try {
            $data = new Asset;
            $data->name = $request->input('name');
            $data->organization_id = $request->input('organization_id');
            $data->sensor_id = $request->input('sensor_id');
            $data->pic_id = $request->input('pic');
            $data->description = $request->input('description');
            $data->save();

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

    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'organization_id' => ['required'],
            'sensor_id' => ['required'],
            'pic'=> ['required'],
            'description' => ['required']
        ]);

        try {
            $data = Asset::findOrFail($id);
            $data->name = $request->input('name');
            $data->organization_id = $request->input('organization_id');
            $data->sensor_id = $request->input('sensor_id');
            $data->pic_id = $request->input('pic');
            $data->description = $request->input('description');
            $data->save();

            return response()->json([
                'code ' => 201,
                'message' => 'updated',
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
