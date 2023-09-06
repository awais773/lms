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

// Route::get('auth', [AuthController::class, 'redirectToAuth']);
// Route::get('auth/callback', [AuthController::class, 'handleAuthCallback']);

Route::get('/auth',[App\Http\Controllers\api\AuthController::class,'redirectToAuth']);
Route::get('auth/callback',[App\Http\Controllers\api\AuthController::class,'handleAuthCallback']);


   // admin //

Route::post('adminRegister',[App\Http\Controllers\api\AdminAuthController::class,'adminRegister']);
Route::delete('deleteUsers',[App\Http\Controllers\api\AdminAuthController::class,'deleteUser']);
Route::post('adminlogin',[App\Http\Controllers\api\AdminAuthController::class,'adminlogin']);
Route::get('dashboard',[App\Http\Controllers\api\AdminAuthController::class,'dashboard']);
Route::get('/invoiceShowAdmin', [App\Http\Controllers\api\OfferController::class, 'invoiceShowAdmin']);
Route::get('/invoiceShowAdminId/{id}', [App\Http\Controllers\api\OfferController::class, 'invoiceShowAdminId']);

Route::get('ReviewGet',[App\Http\Controllers\api\AdminAuthController::class,'ReviewGet']);
Route::get('ReviewGet/{id}',[App\Http\Controllers\api\AdminAuthController::class,'ReviewshowId']);
Route::get('ReviewStatus',[App\Http\Controllers\api\AdminAuthController::class,'ReviewStatus']);
Route::delete('reviewDestroy/{id}',[App\Http\Controllers\api\AdminAuthController::class,'ReviewStatus']);
Route::post('reviewUpdate/{id}',[App\Http\Controllers\api\AdminAuthController::class,'reviewUpdate']);


      // testimonial
Route::post('Addtestimonial',[App\Http\Controllers\api\AdminAuthController::class,'Addtestimonial']);
Route::get('TestimonialGet',[App\Http\Controllers\api\AdminAuthController::class,'TestimonialGet']);
Route::get('TestimonialGet/{id}',[App\Http\Controllers\api\AdminAuthController::class,'TestimonialShow']);
Route::delete('TestimonialDestroy/{id}',[App\Http\Controllers\api\AdminAuthController::class,'TestimonialDestroy']);
Route::get('/instructor',[App\Http\Controllers\api\AuthController::class,'instructor']);
Route::get('/student',[App\Http\Controllers\api\AuthController::class,'student']);

  // user //

Route::post('register',[App\Http\Controllers\api\AuthController::class,'register']);
Route::post('registers',[App\Http\Controllers\api\AuthController::class,'registers']);
Route::post('login',[App\Http\Controllers\api\AuthController::class,'login']);
Route::post('newlogin',[App\Http\Controllers\api\AuthController::class,'newlogin']);
Route::post('/forgotPassword', [App\Http\Controllers\api\AuthController::class, 'forgotPassword']);
Route::post('/updatePassword', [App\Http\Controllers\api\AuthController::class, 'updatePassword']);
Route::get('/fileGet', [App\Http\Controllers\api\SubjectController::class, 'fileGet']);
Route::post('/addFile', [App\Http\Controllers\api\SubjectController::class, 'addFile']);
Route::get('/getOneTeacher/{id}',[App\Http\Controllers\api\AuthController::class,'getOneTeacher']);
Route::post('/resendEmail',[App\Http\Controllers\api\AuthController::class,'resendEmail']);


Route::apiResource('subjects', App\Http\Controllers\api\SubjectController::class);
Route::apiResource('resourses', App\Http\Controllers\api\ResourseController::class);
Route::apiResource('categories', App\Http\Controllers\api\CategoryController::class);
Route::post('/resoursesUpdate/{id}', [App\Http\Controllers\api\ResourseController::class, 'update']);

             //// qualigication

Route::apiResource('qualification', App\Http\Controllers\api\QualificationController::class);

           //// course
Route::post('/couresUpdate/{id}', [App\Http\Controllers\api\ResourseController::class, 'update']);
Route::get('/indexgetTeacher/{id}', [App\Http\Controllers\api\CourceController::class, 'indexgetTeacher']);
Route::post('/filter_course', [App\Http\Controllers\api\CourceController::class, 'search']);
Route::get('/allSearch', [App\Http\Controllers\api\CourceController::class, 'allSearch']);
Route::get('/gernalSearch', [App\Http\Controllers\api\CourceController::class, 'GernalSearch']);


Route::apiResource('dacuments', App\Http\Controllers\api\DacumentController::class);
Route::post('/dacumentsUpdate/{id}', [App\Http\Controllers\api\DacumentController::class, 'update']);

Route::get('/dependenciesAll', [App\Http\Controllers\api\SubjectController::class, 'dependenciesAll']);


               //blogs  

Route::post('addBlog',[App\Http\Controllers\api\AdminAuthController::class,'addBlog']);
Route::get('blogGet',[App\Http\Controllers\api\AdminAuthController::class,'blogGet']);
Route::get('blogGet/{id}',[App\Http\Controllers\api\AdminAuthController::class,'show']);
Route::delete('blogDestroy/{id}',[App\Http\Controllers\api\AdminAuthController::class,'blogDestroy']);
Route::post('blogUpdate/{id}',[App\Http\Controllers\api\AdminAuthController::class,'update']);
Route::post('/otp/verify', [App\Http\Controllers\api\AuthController::class, 'otpVerification']);
Route::get('/offerGet/{id}', [App\Http\Controllers\api\OfferController::class, 'offerGet']);

        //// invoices

Route::post('/offerStatus/{id}', [App\Http\Controllers\api\OfferController::class, 'invoice']);
Route::get('/invoice', [App\Http\Controllers\api\OfferController::class, 'invoiceGet']);
// Route::get('/invoice/{id}', [App\Http\Controllers\api\OfferController::class, 'invoiceShow']);

    ///  contact
Route::apiResource('contacts', App\Http\Controllers\api\ContactController::class);




Route::middleware('auth:api')->group(function () {
Route::post('/PasswordChanged ', [App\Http\Controllers\api\AuthController::class, 'PasswordChanged']);
Route::post('/update/AdminProfile', [App\Http\Controllers\api\AdminAuthController::class, 'adminProfile']);
Route::get('/logout',[App\Http\Controllers\api\AuthController::class,'logout']);
Route::get('AllUser',[App\Http\Controllers\api\MessageController::class,'AllUser']);
Route::put('/update/profile', [App\Http\Controllers\api\AuthController::class, 'updateProfile']);
Route::post('/handle', [App\Http\Controllers\api\AuthController::class, 'handle']);


Route::get('/status/{id}',[App\Http\Controllers\api\AuthController::class,'status']);
Route::delete('/delete/{id}',[App\Http\Controllers\api\AuthController::class,'delete']);
Route::get('/getTeacher',[App\Http\Controllers\api\AuthController::class,'getTeacher']);
Route::get('/dependencies', [App\Http\Controllers\api\SubjectController::class, 'dependencies']);

       //     
Route::post('reviewAdd',[App\Http\Controllers\api\AdminAuthController::class,'reviewAdd']);
Route::get('ReviewGetTeacher',[App\Http\Controllers\api\AdminAuthController::class,'ReviewGetTeacherAll']);
Route::get('ReviewGetTeacher/{id}',[App\Http\Controllers\api\AdminAuthController::class,'ReviewGetTeacher']);


Route::apiResource('packages', App\Http\Controllers\api\PackageController::class);
Route::apiResource('promotions', App\Http\Controllers\api\PromotionController::class);
Route::apiResource('subjects', App\Http\Controllers\api\SubjectController::class);
Route::apiResource('services', App\Http\Controllers\api\ServiceController::class);
Route::apiResource('ads', App\Http\Controllers\api\AdsController::class);
Route::apiResource('roles', App\Http\Controllers\api\RoleController::class);
Route::apiResource('userAdd', App\Http\Controllers\api\UserAddController::class);
Route::apiResource('payment', App\Http\Controllers\api\PaymentController::class);
Route::apiResource('coures', App\Http\Controllers\api\CourceController::class);


       // rating //

Route::post('/ratings/{user}',[App\Http\Controllers\api\RatingController::class,'store']);
Route::get('/rating/{user}',[App\Http\Controllers\api\RatingController::class,'getRating']);


       //chat

Route::post('/sendMessage', [App\Http\Controllers\api\MessageController::class, 'sendMessage']);
Route::post('chat', [App\Http\Controllers\api\MessageController::class, 'sendUserChat']);
Route::post('messageShow', [App\Http\Controllers\api\MessageController::class, 'messageShow']);
Route::get('updateSeen', [App\Http\Controllers\api\MessageController::class, 'updateSeen']);

    ///  Offer

Route::apiResource('offer', App\Http\Controllers\api\OfferController::class);

      /// strip
Route::post('stripePost', [App\Http\Controllers\api\PaymentController::class, 'stripePost']);


        //// invoices

Route::post('/offerStatus/{id}', [App\Http\Controllers\api\OfferController::class, 'invoice']);
Route::get('/invoice', [App\Http\Controllers\api\OfferController::class, 'invoiceGet']);
Route::get('/invoice/{id}', [App\Http\Controllers\api\OfferController::class, 'invoice']);
Route::get('/invoiceShow', [App\Http\Controllers\api\OfferController::class, 'invoiceShow']);
Route::get('/notificationOffer', [App\Http\Controllers\api\OfferController::class, 'notificationOffer']);



});
