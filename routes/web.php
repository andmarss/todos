<?php

use \Illuminate\Support\Facades\{Auth, Route};

Route::group(['middleware' => 'auth', 'prefix' => 'todo', 'as' => 'todo.'], function () {
    Route::get('/', 'TodoController@index')->name('index');

    Route::post('/create', 'TodoController@store')->name('create');

    Route::middleware('check.todo')->group(function (){
        Route::post('/update/{id}', 'TodoController@update')->name('update');
        Route::post('/delete/{id}', 'TodoController@destroy')->name('delete');
    });
});

Route::group(['middleware' => 'guest'], function () {
    Auth::routes();

    Route::get('/', function (){
        return redirect()->route('login');
    })->name('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
