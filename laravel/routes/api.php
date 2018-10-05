<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', function () {
    return factory('App\User', 10)->make();
});

Route::get('/companies', function() {
    return App\Company::all();
});

Route::get('/statuses', function() {
    return App\Status::all();
});

Route::post('/status', function(Request $request) {
    try {
        $status = App\Status::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Created status successfully!",
            'data' => [
                'status' => $status
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 200);

    }


});
