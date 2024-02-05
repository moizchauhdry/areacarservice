<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'User'], function () {
	// Route::get('/', 'HomeController@index');
	Route::get('/', function () {
		return redirect()->route('admin.login');
	});
	Route::get('post/{post}', 'PostController@post')->name('post');

	Route::get('post/tag/{tag}', 'HomeController@tag')->name('tag');
	Route::get('post/category/{category}', 'HomeController@category')->name('category');

	//vue routes
	Route::post('getPosts', 'PostController@getAllPosts');
	Route::post('saveLike', 'PostController@saveLike');
});

//Admin Routes
Route::group(['namespace' => 'Admin'], function () {
	Route::get('admin/home', 'HomeController@index')->name('admin.home');
	Route::resource('admin/user', 'UserController');
	Route::resource('admin/role', 'RoleController');
	Route::resource('admin/permission', 'PermissionController');
	Route::resource('admin/post', 'PostController');
	Route::resource('admin/tag', 'TagController');
	Route::resource('admin/category', 'CategoryController');

	// Admin Auth Routes
	Route::get('admin-login', 'Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('admin-login', 'Auth\LoginController@login');
	Route::get('clear/{id}', 'UserController@clear')->name('admin.clear');
	Route::get('reminder/{id}', 'UserController@reminder')->name('admin.reminder');
	Route::get('/resend-invoice-confirmation-mail/{id}', 'UserController@resendInvoiceConfirmationMail')->name('admin.resendInvoiceConfirmationMail');
	Route::get('/send-sms/{id}', 'UserController@sendSms')->name('admin.send-sms');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/invoice/{id}', 'PrintController@invoice')->name('invoice');

Route::get('/signature/{id}', 'PrintController@signature')->name('admin.signature');
Route::post('/signature/upload/{id}', 'PrintController@uploadSignature')->name('admin.signature.upload');
Route::get('/generate/{id}', 'PrintController@generate')->name('admin.generate');
