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

Route::get('/', function () {
    return view('welcome');
});
//粉丝列表  经过标签页进
Route::get('wecaht/access','WechatController@index');
//登录 微信授权
Route::get('wecaht/login','WechatController@login');
Route::get('wecaht/login_code','WechatController@login_code');
Route::get('wecaht/code','WechatController@code');
//标签管理
Route::get('wechat/tog_list','TogController@tog_list');
Route::get('wechat/add_tog','TogController@add_tog');
Route::post('wechat/do_tog','TogController@do_tog');
Route::get('wechat/update_tog','TogController@update_tog');
Route::post('wechat/do_update_tog','TogController@do_update_tog');
Route::get('wechat/del_tog','TogController@del_tog');
//给粉丝打标签
Route::post('wechat/add_user','TogController@add_user');
//查看粉丝标签
Route::get('wechat/user_tag','TogController@user_tag');
//批量为用户取消标签
Route::post('wechat/on_user_tag','TogController@on_user_tag');
//标签下的粉丝
Route::get('wechat/tag_user','TogController@tag_user');