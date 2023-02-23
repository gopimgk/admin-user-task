<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\employeeController;
use App\Http\Middleware\employeeMiddleware;

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

Route::get('/', function () {
    return view('welcome');
});
//login home pages routes
Route::get('login', [employeeController::class,'index']);
Route::post('dashboard',[employeeController::class,'checklogin']);
Route::get('logout',[employeeController::class,'logout']);

//admin route add middleware 
Route::group(['middleware'=>'empmiddleware'],function(){

       Route::get('admindashboard', function () {
             return view('admindashboard')->name('admindashboard');
             });
       Route::get('userdashbord', function () {
              return view('userdashboard')->name('userdashboard');
             });

       Route::get('updateemp', [employeeController::class,'updateemp'])->name('updateemp');
       Route::post('edit', [employeeController::class,'edit'])->name('edit');
       Route::post('empupdate', [employeeController::class,'empupdate'])->name('empupdate');
       
       Route::get('empcreate', function () {
              return view('employeecreate');
              });
       Route::post('empcreate',[employeeController::class,'empcreate']);

       Route::get('emplist',[employeeController::class,'emplist']);
       Route::get('nonUsers',[employeeController::class,'nonUsers']);
     
       });

// Route::get('updateemp', [employeeController::class,'updateemp'])->name('updateemp');
// Route::post('edit', [employeeController::class,'edit'])->name('edit');
// Route::post('empupdate', [employeeController::class,'empupdate'])->name('empupdate');

//     Route::get('empcreate', function () {
//     return view('employeecreate');
// });

//     Route::get('emplist',[employeeController::class,'emplist']);
// Route::get('admindashbord', function () {
//     return view('admindashbord')->name('admindashbord');
// });



// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');