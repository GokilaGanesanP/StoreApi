<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerformanceController;




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


// Route::controller(AuthController::class)->group(function () {
//     Route::post('login', 'login');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');
// });

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
Route::post('register', [AuthController::class, 'register'])->name('register');



Route::middleware('auth:api')->get('/store', [StoreController::class, 'store_list'])->name('store');
Route::middleware('auth:api')->post('/addstore', [StoreController::class, 'create_store'])->name('addstore');
Route::middleware('auth:api')->post('/getstore', [StoreController::class, 'get_Store'])->name('getstore');
Route::middleware('auth:api')->post('/deletestore', [StoreController::class, 'delete_Store'])->name('deletestore');

Route::middleware('auth:api')->get('/user', [UserController::class, 'user_list'])->name('user');
Route::middleware('auth:api')->post('/getuser', [UserController::class, 'get_User'])->name('getuser');
Route::middleware('auth:api')->post('/updateuser', [UserController::class, 'update_User'])->name('updateuser');
Route::middleware('auth:api')->post('/deleteuser', [UserController::class, 'delete_User'])->name('deleteuser');


Route::middleware('auth:api')->post('/addperformance', [PerformanceController::class, 'create_performance'])->name('addperformance');

Route::middleware('auth:api')->post('/performanceList', [PerformanceController::class, 'performance_list'])->name('performanceList');
Route::middleware('auth:api')->post('/getperformance', [PerformanceController::class, 'get_Performance_id'])->name('getperformance');

Route::middleware('auth:api')->post('/deleteperformance', [PerformanceController::class, 'delete_Performance'])->name('deleteperformance');

Route::middleware('auth:api')->get('/userperformance', [PerformanceController::class, 'get_user_performance'])->name('userperformance');

Route::middleware('auth:api')->get('/storeperformance', [PerformanceController::class, 'get_store_performance'])->name('storeperformance');













//Route::middleware('auth:api','throttle:3,1')->get('/quote', [QuoteController::class, 'index']);
