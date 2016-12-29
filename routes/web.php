<?php

/*
 * 路由中的API为提供相关的API接口
 * Admin为后台管理接口
 * */
Route::get('/', 'Admin\AdminController@index');
Route::get('API/', 'Text\TextController@index');
Route::post('API/book', 'Text\TextController@getBook');
Route::post('API/login', 'Text\TextController@getToken');
Route::post('API/myBook', 'Text\TextController@getUserBook');
Route::post('Admin/alogin', 'Admin\AdminController@login');
Route::get('Admin/index', 'Admin\AdminController@aIndex');
Route::get('Admin/manger', 'Admin\AdminController@bookIndex');
Route::get('Admin/userManger', 'Admin\AdminController@userIndex');
Route::get('Admin/bookDel', 'Admin\AdminController@bookDel');
Route::get('Admin/userDel', 'Admin\AdminController@userDel');
Route::post('Admin/addBook', 'Admin\AdminController@addBook');