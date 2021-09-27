<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\NurseController;


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

Route::post('reference/login', [ReferenceController::class, 'login']);
Route::post('/nurse/login', [NurseController::class, 'login']);
Route::post('/nurse/register', [NurseController::class, 'register']);

Route::group(['middleware' => ['auth:nurses']], function () {
    Route::put('/nurse/update', [NurseController::class, 'update']);
    Route::delete('/nurse/delete', [NurseController::class, 'destroy']);
    Route::post('/reference/create', [ReferenceController::class, 'store']);
    Route::post('/nurse/reference/update/{email}', [ReferenceController::class, 'ref_update']);

});


Route::group(['middleware' => ['auth:references']], function () {
    Route::put('/reference/update/{id}/{rid}', [ReferenceController::class, 'update']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
