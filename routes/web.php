
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
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



Route::get('task', [EmployeeController::class, 'index']);
Route::post('store', [EmployeeController::class, 'store']);
Route::post('edit', [EmployeeController::class, 'edit']);
Route::post('delete', [EmployeeController::class, 'destroy']);