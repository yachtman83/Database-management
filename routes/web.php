<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/all/desc', function () {
    return 'all desc';
});
Route::get('/user/{name}/{id?}', function ($name, $id) {
    return 'name id';
});
Route::get('/user/all', function () {
    return 'all';
});
