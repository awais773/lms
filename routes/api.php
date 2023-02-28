<?php

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

   // admin //

Route::post('adminRegister',[App\Http\Controllers\api\AdminAuthController::class,'adminRegister']);
Route::post('adminlogin',[App\Http\Controllers\api\AdminAuthController::class,'adminlogin']);
Route::get('dashboard',[App\Http\Controllers\api\AdminAuthController::class,'dashboard']);


  // user //

Route::post('register',[App\Http\Controllers\api\AuthController::class,'register']);
Route::post('login',[App\Http\Controllers\api\AuthController::class,'login']);
Route::post('/forgotPassword', [App\Http\Controllers\api\AuthController::class, 'forgotPassword']);
Route::post('/updatePassword', [App\Http\Controllers\api\AuthController::class, 'updatePassword']);
Route::get('/fileGet', [App\Http\Controllers\api\SubjectController::class, 'fileGet']);
Route::post('/addFile', [App\Http\Controllers\api\SubjectController::class, 'addFile']);




Route::middleware('auth:api')->group(function () {
Route::post('/update/profile', [App\Http\Controllers\api\AuthController::class, 'updateProfile']);
Route::post('/update/AdminProfile', [App\Http\Controllers\api\AdminAuthController::class, 'adminProfile']);
Route::post('/otp/verify', [App\Http\Controllers\api\AuthController::class, 'otpVerification']);
Route::get('get-user',[App\Http\Controllers\api\AuthController::class,'userInfo']);
Route::get('/logout',[App\Http\Controllers\api\AuthController::class,'logout']);
Route::get('/instructor',[App\Http\Controllers\api\AuthController::class,'instructor']);
Route::get('/student',[App\Http\Controllers\api\AuthController::class,'student']);
Route::get('/status/{id}',[App\Http\Controllers\api\AuthController::class,'status']);


Route::apiResource('coures', App\Http\Controllers\api\CourceController::class);
Route::apiResource('packages', App\Http\Controllers\api\PackageController::class);
Route::apiResource('promotions', App\Http\Controllers\api\PromotionController::class);
Route::apiResource('subjects', App\Http\Controllers\api\SubjectController::class);
Route::apiResource('contacts', App\Http\Controllers\api\ContactController::class);
Route::apiResource('services', App\Http\Controllers\api\ServiceController::class);
Route::apiResource('ads', App\Http\Controllers\api\AdsController::class);
Route::apiResource('roles', App\Http\Controllers\api\RoleController::class);
Route::apiResource('userAdd', App\Http\Controllers\api\UserAddController::class);
Route::apiResource('categories', App\Http\Controllers\api\CategoryController::class);


       // rating //

Route::post('/ratings/{user}',[App\Http\Controllers\api\RatingController::class,'store']);
Route::get('/rating/{user}',[App\Http\Controllers\api\RatingController::class,'getRating']);

});
