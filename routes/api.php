<?php

use App\Models\Kelurahan;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/kelurahan/{id}", function ($id) {
    $kelurahan = Kelurahan::where("kecamatan_id", $id)->get();
    return response()->json($kelurahan);
});

Route::get("/incident_count/kelurahan/{id}", function ($id) {
    $kelurahan = Kelurahan::where("kecamatan_id", $id)->withCount('incident')->get();
    return response()->json($kelurahan);
});
