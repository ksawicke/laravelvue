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

Route::delete('/company/{id}', function($id) {
    try {

        App\Company::destroy($id);

        return response()->json([
            'status' => true,
            'message' => "Deleted company successfully!",
            'data' => [
                'id' => $id
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

Route::post('/company', function(Request $request) {
    try {
        $company = App\Company::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Created company successfully!",
            'data' => [
                'status' => $company
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

Route::get('/statuses', function() {
    return App\Status::all();
});

Route::delete('/status/{id}', function($id) {
    try {

        App\Status::destroy($id);

        return response()->json([
            'status' => true,
            'message' => "Deleted status successfully!",
            'data' => [
                'id' => $id
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
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
        ], 404);

    }
});

// EDUCATION LEVELS
Route::get('/educationlevels', function() {
    return App\EducationLevel::all();
});

Route::post('/educationlevel', function(Request $request) {
    try {
        $educationLevel = App\EducationLevel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Created education level successfully!",
            'data' => [
                'educationLevel' => $educationLevel
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

// COUNTRY SUBDIVISION TYPES
Route::get('/subdivisiontypes', function() {
    return App\CountrySubdivisionType::all();
});

Route::post('/subdivisiontype', function(Request $request) {
    try {
        $subdivisionType = App\CountrySubdivisionType::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Created country subdivision type successfully!",
            'data' => [
                'subdivisionType' => $subdivisionType
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

Route::delete('/subdivisiontype/{id}', function($id) {
    try {

        App\CountrySubdivisionType::destroy($id);

        return response()->json([
            'status' => true,
            'message' => "Deleted subdivision type successfully!",
            'data' => [
                'id' => $id
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

// COUNTRY
Route::get('/countries', function() {
    $countries = App\Country::with('countrySubdivisionTypes')->with('countrySubdivisionItems')->get();

    return $countries;
});

Route::post('/country', function(Request $request) {
    try {
//        dd($request);
        $country = App\Country::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Created country successfully!",
            'data' => [
                'country' => $country
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

// COUNTRY SUBDIVISION ITEMS
Route::post('/countrysubdivisionitem', function(Request $request) {
    try {
        $subdivisionItem = App\CountrySubdivisionItem::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Created country subdivision item successfully!",
            'data' => [
                'subdivisionItem' => $subdivisionItem
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

Route::delete('/countrysubdivisionitem/{id}', function($id) {
    try {

        App\CountrySubdivisionItem::destroy($id);

        return response()->json([
            'status' => true,
            'message' => "Deleted subdivision item successfully!",
            'data' => [
                'id' => $id
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});
