<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('pracovisko');
});

Auth::routes();

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/updatedb', [App\Http\Controllers\GroupsPeopleController::class, 'updatedb'])->name('updatedb');
Route::get('/importUsers', [App\Http\Controllers\GroupsPeopleController::class, 'importUsers'])->name('importUsers');

Route::get('/pracovisko', 'App\Http\Controllers\PracoviskoController@index')->name('pracovisko');
Route::get('/pracoviskoLimit/{number}', 'App\Http\Controllers\PracoviskoController@indexLimit')->name('pracoviskoLimit');

Route::get('/pracoviskoDev', 'App\Http\Controllers\HomeController@pracovisko')->name('pracovisko');

Route::get('/detail', 'App\Http\Controllers\ProjectDetailController@create')->name('project_detail_create');
Route::POST('/detail', 'App\Http\Controllers\ProjectDetailController@store')->name('project_detail_create_save');

Route::get('/detail/{id}', 'App\Http\Controllers\ProjectDetailController@index')->name('project_detail');
Route::POST('/detail/{id}', 'App\Http\Controllers\ProjectDetailController@store')->name('project_detail_create');

Route::get('/detailDev/{id}', 'App\Http\Controllers\HomeController@project_detail')->name('project_detail_dev');

Route::get('/store', 'App\Http\Controllers\ProjectDetailController@store')->name('pracovisko');
//Route::POST('/detail_save/{id}', 'App\Http\Controllers\ProjectDetailController@store')->name('pracovisko');

Route::POST('/delete_projekt/{id}', [\App\Http\Controllers\ProjectDetailController::class, 'delete'])->name('delete');

Route::get('/test', 'App\Http\Controllers\HomeController@testCreate')->name('test-create');

Route::get('/odapa/aktivity_report', 'App\Http\Controllers\ODaPA\AktivityReport\AktivityReport@generateJson')->name('test-create');

Route::get('/users_problem', [App\Http\Controllers\GroupsPeopleController::class, 'test'])->name('test');
Route::get('/importManagers', [App\Http\Controllers\GroupsPeopleController::class, 'importManagers'])->name('importManagers');
Route::get('/test_page', [\App\Http\Controllers\JunkTraining\TestingController::class, 'index'])->name('get-rights-for-project');
Route::get('/test_page2', [\App\Http\Controllers\JunkTraining\TestingController::class, 'test2'])->name('test2');

Route::get('/export/{type}/{id}', [\App\Http\Controllers\ExportController::class, 'export'])->name('export');
Route::get('/export/{type}', [\App\Http\Controllers\ExportController::class, 'export_odapa'])->name('export_odapa');

Route::get('/testing-dates', [\App\Http\Controllers\ImportController::class, 'index'])->name('testing-index');

Route::get('/server-time', function () {
    return [
        'server_time' => now(),
        'timezone' => config('app.timezone')
    ];
});

