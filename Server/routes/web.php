<?php

/*
 * 路由中的API为提供相关的API接口
 * Admin为后台管理接口
 * */
//API获取所有书的列表
Route::get('API/', 'Text\TextController@index');
//API获得用户Token用于之后的具体请求
Route::post('API/login', 'Text\TextController@getToken');
//API获得个人书签和最近阅读
Route::post('API/books', 'Text\TextController@getUserBook');
//API具体书本初始化阅读和下一页操作请求API
Route::post('API/nextPage', 'Text\TextController@nextPage');
//书本上一页操作请求
Route::post('API/beforePage', 'Text\TextController@beforePage');
//书本跳转某页
Route::post('API/otherPage', 'Text\TextController@otherPage');
//管理登录界面
Route::get('/', 'Admin\AdminController@index');
//管理登录并且获得登录状态
Route::post('Admin/alogin', 'Admin\AdminController@login');
//管理界面主页
Route::get('Admin/index', 'Admin\AdminController@aIndex');
//管理书籍页面
Route::get('Admin/manger', 'Admin\AdminController@bookIndex');
//书籍管理删除方法
Route::get('Admin/bookDel', 'Admin\AdminController@bookDel');
//书籍管理，书籍上传
Route::post('Admin/addBook', 'Admin\AdminController@addBook');
//管理用户界面
Route::get('Admin/userManger', 'Admin\AdminController@userIndex');
//用户管理删除界面
Route::get('Admin/userDel', 'Admin\AdminController@userDel');
