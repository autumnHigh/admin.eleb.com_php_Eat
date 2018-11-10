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
    return view('session.add');
});



//抽奖系列的路由
    //抽奖活动表

Route::resource('event','Admins\EventController');
    //抽奖活动奖品
/*Route::post('evps/insert/{event}','Admins\EventPrizeController@insert')->name('evps.insert');*/
Route::get('evps/add/{event}','Admins\EventPrizeController@add')->name('evps.add');

Route::resource('evps','Admins\EventPrizeController');
Route::get('evps/lottery/{evenps}','Admins\EventPrizeController@lottery')->name('evps.lottery');
//Route::resource('evps/evember/{evembers}','Admins\EventPrizeController@evember')->name('evps.evember');

    //抽奖活动报名表
Route::resource('eventmem','Admins\EventMemberController');


//平台活动的路由
Route::resource('active','Admins\ActiveController');

//上传文件到阿里云oss存储的路由
Route::post('upload','Admins\UpController@upload')->name('upload');

Route::resource('shopcategories','Admins\ShopCategoriesController');
Route::resource('shops','Admins\ShopsController');
//Route::post('uploader','Admins\ShopsCategoriesController@uploader')->name('uploader');

Route::resource('user','Admins\UserController');
Route::resource('user','Admins\UserController');
Route::get('user/new/{user}','Admins\UserController@new')->name('user.new');
Route::get('user/warning/{user}','Admins\UserController@warning')->name('user.warning');


Route::resource('audit','Admins\AuditController');
//错误信息界面路由
Route::get('admin/error','Admins\AdminController@error')->name('admin.error');
Route::resource('admin','Admins\AdminController');

//Route::resource('session','Admins\SessionController');
Route::get('session/dess','Admins\SessionController@dess')->name('session.dess');
Route::get('session/create','Admins\SessionController@create')->name('session.create');
Route::post('session/store','Admins\SessionController@store')->name('session.store');
Route::get('login','Admins\SessionController@login')->name('login');

//members会员模块 所需节点
Route::resource('mems','Admins\MemsController');
Route::get('mems/info/{mem}','Admins\MemsController@info')->name('mems.info');


//统计订单数据接口
Route::get('order/week','Admins\OrderController@week')->name('order.week');
Route::get('order/threemonth','Admins\OrderController@threemonth')->name('order.threemonth');
//统计一周的商家菜品的销量统计
Route::get('order/weekMenu','Admins\OrderController@weekMenu')->name('order.weekMenu');
//统计三个月的商家菜品的销售统计
Route::get('order/threeMonthMenu','Admins\OrderController@threeMonthMenu')->name('order.threeMonthMenu');
//统计三个月的商家销售报表
Route::get('order/threeMonthK','Admins\OrderController@threeMonthK')->name('order.threeMonthK');

//最近一周商户商家销量统计
Route::get('order/weekShop','Admins\OrderController@weekShop')->name('order.weekShop');

//添加权限
Route::resource('permission','Admins\PermissionController');
//添加权限人员
Route::resource('role','Admins\RoleController');

//添加导航栏的所需节点

Route::get('nav/twomenu','Admins\NavController@twomenu')->name('nav.twomenu');
Route::post('nav/twostore','Admins\NavController@twostore')->name('nav.twostore');
Route::get('nav/list','Admins\NavController@list')->name('nav.list');
Route::resource('nav','Admins\NavController');


//错误页面路由模块