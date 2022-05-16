<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['verified_token'])->group(function () {
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/about-us', function () {
        return view('about_us');
    });
    Route::get('/contact', function () {
        return view('contact_us');
    });
    Route::get('/personal-dashboard', [AuthController::class, 'personalDashboard']);
    Route::get('/resources', function () {
        return view('recources');
    });
    Route::get('/action-plan',[AuthController::class,'action_plan_print']);
    Route::get('/steps', function () {
        return view('steps');
    });
    Route::get('/myActionPlans',[AuthController::class, 'actionPlans']);
    Route::GET('logout',[AuthController::class, 'logout']);
    Route::GET('delete-action/{action_id}', [AuthController::class, 'deleteAction']);
    Route::GET('save-action-plan/{plan_id}',[AuthController::class, 'save_action_plan']);
});
Route::get('/login', function () {
    return view('login');
});
Route::POST('submit_login',[AuthController::class, 'login']);