<?php

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
Route::get('dashboard', array('uses'=>'MailerController@dashboard'))->name('admin.dashboard');
Route::get('index', array('uses'=>'MailerController@index'))->name('admin.index');
Route::get('create', array('uses'=>'MailerController@create'))->name('admin.create');
Route::get('show/{message}', array('uses'=>'MailerController@show'))->name('admin.show');
Route::post('create', array('uses'=>'MailerController@store'));
  // Route::get('admin', array('uses'=>'MailerController@index'))->name('admin');

