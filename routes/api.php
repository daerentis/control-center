<?php

use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('versions', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'application' => 'required',
        'version' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $validated = $validator->safe()->only(['application', 'version']);

    $version = Version::updateOrCreate(
        ['application' => $validated['application']],
        $validated
    );

    return response()->json($version, 201);
});
