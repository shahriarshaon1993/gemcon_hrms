<?php

// use Illuminate\Http\Request;
// use Symfony\Component\Routing\Route;

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




Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index')->name('home');
Route::get('/employee_data','ApiController@index');
Route::post('/find_employee_data','ApiController@find_employee_data');



//Route::get('members/{num}','memberController@index');
Route::get('members','memberController@index');

Route::post('admin/login','Auth\AdminLoginController@login');

Route::post('user/login','Auth\UserLoginController@login');

Route::post('admin/logout','Auth\AdminLoginController@logout');

Route::post('member/search','memberController@search');

Route::post('admin/home','AdminController@index');

Route::post('member','memberController@store');

Route::put('member','memberController@store');

Route::get('member/{id}','memberController@show');

Route::delete('member/{id}','memberController@destroy');


