<?php

use Illuminate\Support\Facades\Route;

// Static pages
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

// Users
Route::get('/signup', 'UsersController@create')->name('signup');
Route::resource('/users', 'UsersController');
