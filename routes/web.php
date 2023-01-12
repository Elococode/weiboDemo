<?php

use Illuminate\Support\Facades\Route;

// Static pages
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

// Users
Route::get('/signup', 'UsersController@create')->name('signup');
Route::resource('/users', 'UsersController');

// Sessions
Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store')->name('login');
Route::delete('/logout', 'SessionsController@destroy')->name('logout');

// Comfirmation
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

// Reset password
Route::get('password/reset','PasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email','PasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}','PasswordController@showRequestForm')->name('password.reset');
Route::post('password/reset','PasswordController@reset')->name('password.update');