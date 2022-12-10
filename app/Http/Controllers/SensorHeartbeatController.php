<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\SensorHeartbeat;
use Exception;
use Illuminate\Http\Request;

class SensorHeartbeatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sensors-api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SensorHeartbeat  $sensorHeartbeat
     * @return \Illuminate\Http\Response
     */
    public function show(SensorHeartbeat $sensorHeartbeat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SensorHeartbeat  $sensorHeartbeat
     * @return \Illuminate\Http\Response
     */
    public function edit(SensorHeartbeat $sensorHeartbeat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SensorHeartbeat  $sensorHeartbeat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SensorHeartbeat $sensorHeartbeat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SensorHeartbeat  $sensorHeartbeat
     * @return \Illuminate\Http\Response
     */
    public function destroy(SensorHeartbeat $sensorHeartbeat)
    {
        //
    }

    public function heartbeat(Request $request) 
    {
        try {
            $request->validate([
                'uuid' => 'required'
            ]);

            $credential = $request->input('uuid');
            $sensor = Sensor::where('uuid', $credential)->first();
            $data = SensorHeartbeat::where('sensor_id', $sensor->id)->first();
            if(!$data) {
                $data = new SensorHeartbeat();
                $data->sensor_id = $sensor->id;
                $data->last_seen = now();
                $data->save();
                return response()->json([
                    'code' => 200,
                    'message' => 'OK',
                    'data' => $data,
                ],200);
            } else {
                $data->last_seen = now();
                $data->save();
                return response()->json([
                    'code' => 200,
                    'message' => 'OK',
                    'data' => $data,
                ],200);
            }
        } catch(Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage()
            ],500);
        }
    }
}
