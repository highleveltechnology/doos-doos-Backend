<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registration\RegisterController;
use App\Http\Controllers\Registration\LoginController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\userController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\CarsFeaturesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderBookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DriverPriceController;
use App\Http\Controllers\UserNotifyController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserPlanController;
use App\Http\Controllers\CompanyController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//------------------------------------reset_pass_verfiy_email------------------------------------------------------------------
Route::post('sendOTP', [AuthController::class, 'sendOTP'])->name('sendOTP');
Route::post('receiveOTP', [AuthController::class, 'receiveOTP'])->name('receiveOTP');
Route::post('resetpassword', [AuthController::class, 'resetpassword'])->name('resetpassword');
Route::post('verfiy_email', [AuthController::class, 'verfiy_email'])->name('verfiy_email');

//------------------------------------------------------------------------------------------------


Route::middleware('auth:sanctum')->group(function () {


        #MAJD FROM HERE

     Route::get('driver_price/show', [DriverPriceController::class, 'index']);


     Route::prefix('user/subscribe')->group(function () {
            Route::post('/store', [UserPlanController::class, 'store']);
            Route::get('/hasActiveSubscription', [UserPlanController::class, 'hasActiveSubscription']);
            Route::get('/filter', [UserPlanController::class, 'index']);
        });




     Route::prefix('user/company')->group(function () {
            Route::post('/store', [CompanyController::class, 'store']);
            Route::put('/update', [CompanyController::class, 'updateMyCompany']);
            Route::get('/index', [CompanyController::class, 'getMyCompany']);
        });








    Route::prefix('profile')->group(function () {

        // Route::resource('profile', ProfileController::class);
        Route::post('store_profile', [ProfileController::class, 'store']);
        Route::post('update_my_profile', [ProfileController::class, 'update']);
        Route::get('get_my_profile', [ProfileController::class, 'index']);
    });

    Route::middleware('check_admin')->group(function () {


        Route::prefix('admin')->group(function () {

        Route::post('send_notify', [UserNotifyController::class, 'send_notify']);

        });

        Route::prefix('admin/profile')->group(function () {



            Route::get('get_my_profile', [ProfileController::class, 'get_my_profile']);
            Route::get('get_user_profile/{id}', [ProfileController::class, 'get_user_profile']);
        });


        Route::prefix('admin/user')->group(function () {
            Route::get('get_all', [userController::class, 'get_all']);

            Route::get('get_info/{id}', [userController::class, 'get_info']);
        });

        Route::prefix('admin/booking')->group(function () {

            Route::post('change_status_admin/{id}', [OrderBookingController::class, 'change_status_admin']);
            Route::post('change_is_paid/{id}', [OrderBookingController::class, 'change_is_paid']);
        });

        Route::prefix('admin/cars/booking')->group(function () {
            Route::get('get_all_filter', [OrderBookingController::class, 'get_all_filter']);

            Route::prefix('order')->group(function () {
                Route::get('show/{id}', [OrderBookingController::class, 'show']);
            });
        });


        Route::prefix('admin/driver_price')->group(function () {
            Route::post('update', [DriverPriceController::class, 'update']);
            Route::get('show', [DriverPriceController::class, 'index']);
        });



        Route::prefix('admin/profile')->group(function () {



            Route::get('get_my_profile', [ProfileController::class, 'get_my_profile']);
            Route::get('get_user_profile/{id}', [ProfileController::class, 'get_user_profile']);
        });



        #Majd from here
        Route::prefix('admin/plan')->group(function () {
            Route::post('/store', [PlanController::class, 'store']);
            Route::put('/update/{plan}', [PlanController::class, 'update']);
            Route::delete('/delete/{plan}', [PlanController::class, 'delete']);
            Route::get('/index', [PlanController::class, 'index']);
        });


        Route::prefix('admin/subscribe')->group(function () {
                Route::get('/index', [UserPlanController::class, 'adminIndex']);
                Route::post('/mark_as_paid/{user_plan_id}', [UserPlanController::class, 'adminActivateSubscription']);

        });





    });






    Route::get('Get_my_info', [userController::class, 'Get_my_info']);
    Route::get('get_all', [userController::class, 'get_all']);
    Route::post('update_my_info/{id}', [userController::class, 'update_my_info']);


    Route::get('get_all_mycars', [CarsController::class, 'get_all_mycars']);

    Route::delete('deleteCar/{id}', [CarsController::class, 'destroy']);

    Route::post('updateCarFeatures/{id}', [CarsController::class, 'updateCarFeatures']);
    Route::post('updateCar/{id}', [CarsController::class, 'updateCar']);



    Route::prefix('cars')->group(function () {


        Route::post('storeCar', [CarsController::class, 'storeCar']);





    });


    Route::prefix('user/my_notification')->group(function () {

        Route::get('mark_read', [UserNotifyController::class, 'mark_read']);

    });
    Route::prefix('user')->group(function () {
        Route::get('my_notification', [UserNotifyController::class, 'my_notification']);

    });
    Route::prefix('user/review')->group(function () {

        Route::post('my_review', [ReviewController::class, 'my_review']);
        Route::delete('delete_user/{id}', [ReviewController::class, 'delete_user']);
        Route::post('update_review/{id}', [ReviewController::class, 'update_review']);
    });



    Route::prefix('owner/review')->group(function () {

        Route::post('my_review', [ReviewController::class, 'my_review']);
        Route::delete('delete_owner/{id}', [ReviewController::class, 'delete_owner']);
    });

    Route::prefix('owner/booking/bookings')->group(function () {
        Route::post('change_status_owner/{id}', [OrderBookingController::class, 'change_status_owner']);
    });


    Route::prefix('renter/booking/bookings')->group(function () {

        Route::post('change_status_renter/{id}', [OrderBookingController::class, 'change_status_renter']);
    });



    Route::prefix('renter/cars/bookings')->group(function () {



        Route::get('my_booking', [OrderBookingController::class, 'myBooking']);
        Route::post('store/{id}', [OrderBookingController::class, 'store']);
        Route::get('my_order', [OrderBookingController::class, 'my_order']);
        Route::get('show/{id}', [OrderBookingController::class, 'show']);





        Route::prefix('my_order')->group(function () {

            Route::get('show/{id}', [OrderBookingController::class, 'show_my_order']);
            Route::post('update_status/{id}', [OrderBookingController::class, 'update_status']);
        });
    });




});






Route::post('register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forget-password', [ForgetPasswordController::class, 'forgetPassword']);
Route::post('/reset-password', [ForgetPasswordController::class, 'resetPasswordByVerifyOtp']);


Route::get('cars/index', [CarsController::class, 'index']);

Route::post('cars/filter', [CarsController::class, 'filterCars']);
Route::get('cars/calendar/{id}', [OrderBookingController::class, 'calendar']);
Route::get('cars/show_features/{id}', [CarsFeaturesController::class, 'show_features']);


Route::get('plan/index', [PlanController::class, 'index']);



















Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');


/*
Route::group(['middleware' => ['web']], function () {
    Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect']);
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
});
*/


/*Route::group(['middleware' => ['web']], function () {
    Route::get('auth/facebook/redirect', [FacebookController::class, 'redirect']);
    Route::get('auth/facebook/callback', [FacebookController::class, 'callback']);
});
*/
