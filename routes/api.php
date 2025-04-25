<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\WebContentController;
use App\Http\Controllers\DepartmentContentroller;
use App\Http\Controllers\PreviousWorkController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SponserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TestimonailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;

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

Route::middleware(['auth:api'])->group(function () {
    // 
    //user route
    Route::get('/user/getall', [UserController::class, 'index']);
    Route::get('/edit/user/{id}', [UserController::class, 'edit']);
    Route::post('/staff', [UserController::class, 'store']);

    //visitor
    Route::get('/countvisitor', [VisitorController::class, 'index']);
    //news
    Route::post('/news/store', [NewsController::class, 'store']);
    Route::post('/news/update/{id}', [NewsController::class, 'update']);
    Route::post('/hidden', [NewsController::class, 'hidden']);
    //event 
    
    Route::post('/event/store', [EventController::class, 'store']);
    Route::post('/event/update/{id}', [EventController::class, 'update']);
    Route::post('/event/hidden', [EventController::class, 'hidden']);
    
    //question 
    Route::post('/answer/{id}', [QuestionController::class, 'answer']);
    Route::get('/question/show/{id}', [QuestionController::class, 'edit']);
    Route::get('/getall/question', [QuestionController::class, 'index']);
    Route::get('/count/question', [QuestionController::class, 'totalquestions']);
    
    //web content 
    Route::post('/webcontent/update/{id}', [WebContentController::class, 'update']);
    
    //departments 
    Route::post('/update/department/{id}', [DepartmentContentroller::class, 'update']);
    
    //privious work route
    Route::post('/store/PreviousWork', [PreviousWorkController::class, 'store']);
    Route::post('/update/PreviousWork/{id}', [PreviousWorkController::class, 'update']);
    Route::post('/work/hidden', [PreviousWorkController::class, 'hidden']);
    
    //user route
    Route::post('/update/user/{id}', [UserController::class, 'update']);
    
    //service route
    Route::post('/service/update/{id}', [ServiceController::class, 'update']);
    
    //resources
    Route::post('/resource/store', [ResourceController::class, 'store']);
    Route::post('/resource/hidden', [ResourceController::class, 'hidden']);
    
    //sebscribers
    Route::post('/subscriber/broadcast', [SubscriptionController::class, 'broadcast']);
    
    //sponsers    
    Route::post('/store/sponser', [SponserController::class, 'store']);
    Route::post('/sponser/hidden', [SponserController::class, 'hidden']);
    
    //testimoniyals route
    Route::post('/store/testimonial', [TestimonailController::class, 'store']);
 Route::post('/store/testimonial', [TestimonailController::class, 'store']);

    Route::put('/testimonials/{id}/hidden', [TestimonailController::class, 'updateHidden']);
    
    
    //banner api
    Route::post('/store/banner', [BannerController::class, 'store']);
    Route::post('/banner/hidden', [BannerController::class, 'hidden']);
    // slider 
    Route::get('/getall/sliders', [SliderController::class, 'index']);
    Route::post('/store/sliders', [SliderController::class, 'store']);
    Route::post('/update/sliders/{id}', [SliderController::class, 'update']);
    Route::post('/delete/sliders/{id}', [SliderController::class, 'destroy']);
    Route::get('/edit/sliders/{id}', [SliderController::class, 'edit']);




Route::get(   'testimonial',               [TestimonailController::class, 'index']);
Route::post(  'testimonial',               [TestimonailController::class, 'store']);
Route::delete('testimonial/hidden',        [TestimonailController::class, 'hidden']);
Route::post(  'testimonial/{id}',          [TestimonailController::class, 'update']);  // or PUT
Route::delete('testimonial/{id}',          [TestimonailController::class, 'destroy']);

 

Route::get('department', [DepartmentContentroller::class, 'index']);
Route::post('department', [DepartmentContentroller::class, 'store']);
Route::get('department/{id}', [DepartmentContentroller::class, 'edit']); // or PUT
Route::delete('department/{id}', [DepartmentContentroller::class, 'destroy']);
Route::put('/department/{id}', [DepartmentContentroller::class, 'update']);


    // Route::post('/staff', [StaffController::class, 'store']);
    Route::delete('/staff/deletes/{id}', [StaffController::class, 'destroy']);
    // new updated and efficent route
    
    
    Route::post('/store/department', [DepartmentContentroller::class, 'store']);
    Route::get('/edit/department/{id}', [DepartmentContentroller::class, 'edit']);    
});

Route::get('users/role/{role}', [UserController::class, 'getUsersByRole']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/resetpassword', [AuthController::class, 'resetlink']);
Route::post('/changepassword/{id}', [AuthController::class, 'changepassword']);

//visitor controller
Route::post('/visiters', [VisitorController::class, 'store']);

//news route
Route::get('/news/getall', [NewsController::class, 'index']);
Route::get('/news/edit/{id}', [NewsController::class, 'edit']);



//events route
Route::get('/event/getall', [EventController::class, 'index']);
Route::get('/event/edit/{id}', [EventController::class, 'edit']);


//qustion route
Route::post('/question/store', [QuestionController::class, 'store']);

//web content route
Route::post('/store/content', [WebContentController::class, 'store']);
Route::get('/getall/content', [WebContentController::class, 'index']);
Route::get('/edit/content/{id}', [WebContentController::class, 'edit']);

//departments route
Route::get('/getall/department', [DepartmentContentroller::class, 'index']);
Route::get('/department/staffs', [DepartmentContentroller::class, 'getStaffs']);

//privious ork wroute
Route::get('/getall/PreviousWork', [PreviousWorkController::class, 'index']);
Route::get('/edit/PreviousWork/{id}', [PreviousWorkController::class, 'edit']);



//service route
Route::get('/service/getall', [ServiceController::class, 'index']);
Route::get('/service/edit/{id}', [ServiceController::class, 'edit']);


//resource controller
Route::get('/resource/getall', [ResourceController::class, 'index']);
Route::get('/resource/delete/{id}', [ResourceController::class, 'edit']);

//subscribers route 
Route::get('/subscriber/getall', [SubscriptionController::class, 'index']);
Route::get('/subscriber/delete/{id}', [SubscriptionController::class, 'edit']);
Route::post('/subscriber/store', [SubscriptionController::class, 'store']);


//sponser route
Route::get('/getall/sponser', [SponserController::class, 'index']);

//tesimonials
Route::get('/getall/testimonial', [TestimonailController::class, 'index']);

//banner route

Route::get('/getall/banner', [BannerController::class, 'index']);
Route::get('/staff/getall', [UserController::class, 'getStaffs']);

