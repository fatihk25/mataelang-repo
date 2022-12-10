<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationMemberController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SensorHeartbeatController;
use App\Http\Controllers\UserController;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/login', [SensorController::class, 'login']);
Route::prefix('sensors', ['middleware' => 'sensors-api'])->group(function () {
    Route::post('/login', [SensorController::class, 'login']);
    Route::post('/register', [SensorController::class, 'register']);
    Route::post('/heartbeat', [SensorHeartbeatController::class, 'heartbeat']);
    Route::patch('/update/{id}', [SensorController::class, 'edit']);
});

Route::prefix('assets')->group(function () {
    Route::post('/register', [AssetController::class, 'register']);
    Route::patch('/update/{id}', [AssetController::class, 'edit']);
    Route::get('/{id}', [AssetController::class, 'detail']);
});

Route::prefix('users')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::patch('{id}/edit', [UserController::class, 'edit']);
});

Route::prefix('roles')->group(function () {
    Route::post('/create', [RoleController::class, 'create']);
    Route::post('/permission', [RolePermissionController::class, 'create']);
});

Route::prefix('organizations')->group(function () {
    Route::post('/create', [OrganizationController::class, 'create']);
    Route::patch('/update/{id}', [OrganizationController::class, 'edit']);
    Route::get('{id}/all', [OrganizationController::class, 'get_all']);
    Route::get('/{id}/sensors/all', [OrganizationController::class, 'get_sensor']);
    Route::get('/{id}/assets/all', [OrganizationController::class, 'get_asset']);
    Route::get('/{id}/roles/all', [OrganizationController::class, 'get_role']);
    Route::get('/{id}/users/all', [OrganizationController::class, 'get_user']);
    Route::post('/{id}/users/register', [OrganizationMemberController::class, 'register_user']);
    Route::patch('/{id}/users/edit-user', [OrganizationMemberController::class, 'edit_user']);
    Route::post('/{id}/create-admin', [OrganizationController::class, 'create_admin']);
    Route::get('/{id}', [OrganizationController::class, 'profile']);
});