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

      // testimonial
Route::post('Addtestimonial',[App\Http\Controllers\api\AdminAuthController::class,'Addtestimonial']);
Route::get('TestimonialGet',[App\Http\Controllers\api\AdminAuthController::class,'TestimonialGet']);
Route::get('TestimonialGet/{id}',[App\Http\Controllers\api\AdminAuthController::class,'TestimonialShow']);
Route::delete('TestimonialDestroy/{id}',[App\Http\Controllers\api\AdminAuthController::class,'TestimonialDestroy']);
Route::get('/instructor',[App\Http\Controllers\api\AuthController::class,'instructor']);
Route::get('/student',[App\Http\Controllers\api\AuthController::class,'student']);

  // user //

Route::post('register',[App\Http\Controllers\api\AuthController::class,'register']);
Route::post('login',[App\Http\Controllers\api\AuthController::class,'login']);
Route::post('/forgotPassword', [App\Http\Controllers\api\AuthController::class, 'forgotPassword']);
Route::post('/updatePassword', [App\Http\Controllers\api\AuthController::class, 'updatePassword']);
Route::get('/fileGet', [App\Http\Controllers\api\SubjectController::class, 'fileGet']);
Route::get('/dependencies', [App\Http\Controllers\api\SubjectController::class, 'dependencies']);
Route::post('/addFile', [App\Http\Controllers\api\SubjectController::class, 'addFile']);
Route::put('/update/profile/{id}', [App\Http\Controllers\api\AuthController::class, 'updateProfile']);
Route::get('/getOneTeacher/{id}',[App\Http\Controllers\api\AuthController::class,'getOneTeacher']);


Route::apiResource('subjects', App\Http\Controllers\api\SubjectController::class);
Route::apiResource('resourses', App\Http\Controllers\api\ResourseController::class);
Route::post('/resoursesUpdate/{id}', [App\Http\Controllers\api\ResourseController::class, 'update']);

           //// course
Route::post('/couresUpdate/{id}', [App\Http\Controllers\api\ResourseController::class, 'update']);
Route::apiResource('coures', App\Http\Controllers\api\CourceController::class);
Route::get('/indexgetTeacher/{id}', [App\Http\Controllers\api\CourceController::class, 'indexgetTeacher']);


Route::apiResource('dacuments', App\Http\Controllers\api\DacumentController::class);
Route::post('/dacumentsUpdate/{id}', [App\Http\Controllers\api\DacumentController::class, 'update']);



               //blogs  

Route::post('addBlog',[App\Http\Controllers\api\AdminAuthController::class,'addBlog']);
Route::get('blogGet',[App\Http\Controllers\api\AdminAuthController::class,'blogGet']);
Route::get('blogGet/{id}',[App\Http\Controllers\api\AdminAuthController::class,'show']);
Route::delete('blogDestroy/{id}',[App\Http\Controllers\api\AdminAuthController::class,'blogDestroy']);
Route::post('blogUpdate/{id}',[App\Http\Controllers\api\AdminAuthController::class,'update']);

Route::middleware('auth:api')->group(function () {
Route::post('/update/AdminProfile', [App\Http\Controllers\api\AdminAuthController::class, 'adminProfile']);
Route::post('/otp/verify', [App\Http\Controllers\api\AuthController::class, 'otpVerification']);
Route::get('get-user',[App\Http\Controllers\api\AuthController::class,'userInfo']);
Route::get('/logout',[App\Http\Controllers\api\AuthController::class,'logout']);

Route::get('/status/{id}',[App\Http\Controllers\api\AuthController::class,'status']);
Route::delete('/delete/{id}',[App\Http\Controllers\api\AuthController::class,'delete']);
Route::get('/getTeacher',[App\Http\Controllers\api\AuthController::class,'getTeacher']);

       //     
Route::delete('reviewDestroy/{id}',[App\Http\Controllers\api\AdminAuthController::class,'reviewDestroy']);
Route::post('reviewAdd',[App\Http\Controllers\api\AdminAuthController::class,'reviewAdd']);
Route::get('ReviewGet',[App\Http\Controllers\api\AdminAuthController::class,'ReviewGet']);


Route::apiResource('packages', App\Http\Controllers\api\PackageController::class);
Route::apiResource('promotions', App\Http\Controllers\api\PromotionController::class);
Route::apiResource('subjects', App\Http\Controllers\api\SubjectController::class);
Route::apiResource('contacts', App\Http\Controllers\api\ContactController::class);
Route::apiResource('services', App\Http\Controllers\api\ServiceController::class);
Route::apiResource('ads', App\Http\Controllers\api\AdsController::class);
Route::apiResource('roles', App\Http\Controllers\api\RoleController::class);
Route::apiResource('userAdd', App\Http\Controllers\api\UserAddController::class);
Route::apiResource('categories', App\Http\Controllers\api\CategoryController::class);
Route::apiResource('payment', App\Http\Controllers\api\PaymentController::class);


       // rating //

Route::post('/ratings/{user}',[App\Http\Controllers\api\RatingController::class,'store']);
Route::get('/rating/{user}',[App\Http\Controllers\api\RatingController::class,'getRating']);

});
