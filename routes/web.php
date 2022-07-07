<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
echo phpinfo();die;
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
        return view('about_us');
    });
    Route::get('/about-us', function () {
        return view('about_us');
    });
    Route::get('/contact', function () {
        $user = session("auth-user");
        return view('contact_us',compact('user'));
    });
    Route::get('/personal-dashboard', [AuthController::class, 'personalDashboard']);
    Route::get('/resources', function () {
        return view('recources');
    });
    Route::get('/action-plan',[AuthController::class,'action_plan_print']);
    Route::get('/export-report',[AuthController::class,'export_report']);
    Route::get('/steps', function () {
        return view('steps');
    });
    Route::get('/myActionPlans',[AuthController::class, 'actionPlans']);
    Route::get('/privacy',[AuthController::class, 'privacy']);
    Route::get('/driver-action-plans',[AuthController::class, 'actionPlansDriver']);
    Route::GET('logout',[AuthController::class, 'logout']);
    Route::GET('delete-action/{action_id}/{action_type}', [AuthController::class, 'deleteAction']);
    Route::POST('save-action-plan',[AuthController::class, 'save_action_plan']);
    Route::POST('save-action-plan-two',[AuthController::class, 'save_action_plan_two']);
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/forget-password', function () {
    return view('forget_password');
});
Route::POST('submit_login',[AuthController::class, 'login']);