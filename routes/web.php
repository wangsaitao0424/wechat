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
//上传微信素材
Route::get('wechat/resources_add','ResourcesController@resources_add');
Route::post('wechat/resources_do','ResourcesController@resources_do');
//接受用户微信发到的信息
Route::any('wechat/event','EventController@event');
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
//公众号调用或第三方平台帮公众号调用对公众号的所有api调用（包括第三方帮其调用）次数进行清零：
Route::get('wechat/clear_api','WechatController@clear_api');
//素材展示
Route::get('wechat/resources_list','ResourcesController@resources_list');
//素材下载
Route::get('wechat/resources_download','ResourcesController@resources_download');
//自定义菜单
Route::get('wechat/wechat_carte','WechatController@wechat_carte');
//添加自定义菜单
Route::get('wechat/add_menu','MenuController@add_menu');
Route::post('wechat/create_menu','MenuController@create_menu');
//加载菜单
Route::get('wecaht/wechat_menu','MenuController@wechat_menu');
//自定义菜单列表
Route::get('wechat/menu_list','MenuController@menu_list');
//删除数据库中的自定义菜单
Route::get('wechat/menu_del','MenuController@menu_del');
//周考
Route::get('week_test/login','LoginController@index');
Route::get('week_test/login_do','LoginController@login_do');
Route::get('week_test/login_code','LoginController@login_code')->middleware('login');
Route::get('week_test/login_news','LoginController@login_news');
//二维码
Route::get('wechat/qrlist','WechatController@qr_lists');
Route::get('wechat/add_qr','WechatController@add_qr');