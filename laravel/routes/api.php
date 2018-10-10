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

Route::get('/company/{id}', function($id) {
    $company = App\Company::find($id);

    return $company;
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

Route::patch('/company/{id}', function($id, Request $request) {
    try {
        $company = App\Company::findOrFail($id);
        $company->name = $request->name;
        $company->website = $request->website;
        $company->phone = $request->phone;
        $company->social_linked_in = $request->linked_in;
        $company->social_twitter = $request->twitter;
        $company->social_facebook = $request->facebook;
        $company->about = $request->about;
        $company->save();

        return response()->json([
            'status' => true,
            'message' => "Edited company successfully!",
            'data' => [
                'country' => $company
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

Route::delete('/country/{id}', function($id) {
    try {

        App\Country::destroy($id);

        return response()->json([
            'status' => true,
            'message' => "Deleted country successfully!",
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

Route::get('/statuses', function() {
    return App\Status::all();
});

Route::get('/status/{id}', function($id) {
    $status = App\Status::find($id);

    return $status;
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

Route::get('/educationlevel/{id}', function($id) {
    $educationLevel = App\Educationlevel::find($id);

    return $educationLevel;
});

Route::delete('/educationlevel/{id}', function($id) {
    try {

        App\EducationLevel::destroy($id);

        return response()->json([
            'status' => true,
            'message' => "Deleted education level successfully!",
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

Route::patch('/educationlevel/{id}', function($id, Request $request) {
    try {
        $educationLevel = App\EducationLevel::findOrFail($id);
        $educationLevel->description = $request->description;
        $educationLevel->save();

        return response()->json([
            'status' => true,
            'message' => "Edited education level successfully!",
            'data' => [
                'country' => $educationLevel
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

Route::get('/subdivisiontype/{id}', function($id) {
    $subdivisionType = App\CountrySubdivisionType::find($id);

    return $subdivisionType;
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
Route::patch('/subdivisiontype/{id}', function($id, Request $request) {
    try {
        $subdivisionType = App\CountrySubdivisionType::findOrFail($id);
        $subdivisionType->name = $request->name;
        $subdivisionType->save();

        return response()->json([
            'status' => true,
            'message' => "Edited country subdivision type successfully!",
            'data' => [
                'country' => $subdivisionType
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

Route::get('/country/{id}', function($id) {
    $countries = App\Country::with('countrySubdivisionTypes')->with('countrySubdivisionItems')->find($id);

    return $countries;
});

Route::post('/country', function(Request $request) {
    try {
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

Route::patch('/country/{id}', function($id, Request $request) {
    try {
        $country = App\Country::findOrFail($id);
        $country->name = $request->name;
        $country->abbreviation = $request->abbreviation;
        $country->country_subdivision_types_id = $request->country_subdivision_types_id;
        $country->save();

        return response()->json([
            'status' => true,
            'message' => "Edited country successfully!",
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

Route::patch('/countrysubdivisionitem/{id}', function($id, Request $request) {
    try {
        $countrySubdivisionItem = App\CountrySubdivisionItem::findOrFail($id);
        $countrySubdivisionItem->country_id = $request->country_id;
        $countrySubdivisionItem->name = $request->name;
        $countrySubdivisionItem->abbreviation = $request->abbreviation;
        $countrySubdivisionItem->save();

        return response()->json([
            'status' => true,
            'message' => "Edited country subdivision item successfully!",
            'data' => [
                'country' => $countrySubdivisionItem
            ]
        ], 200);

    } catch (\Exception $ex) {

        return response()->json([
            'status' => false,
            'message' => $ex->getMessage()
        ], 404);

    }
});

Route::get('/countrysubdivisionitem/{id}', function($id) {
    $countrySubdivisionItem = App\CountrySubdivisionItem::find($id);

    return $countrySubdivisionItem;
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
