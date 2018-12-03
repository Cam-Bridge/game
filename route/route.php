<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


Route::alias('index','admin/index/index');
Route::get('admin/index/welcome','admin/index/welcome');

//Route::get('admin/index','admin/index/index');
//Route::get('admin/information','admin/information/index');
Route::group('admin',function(){
	Route::get('index/welcome','index/welcome');

    Route::get('carshop/ueditor','carshop/ueditor');
    Route::get('carshop/question','carshop/question');


    Route::get('business/connerSubmit','business/connerSubmit');
    Route::get('business/fits','business/fits');
    Route::get('business/connerSubmit','business/connerSubmit');



    Route::get('card/applyList','card/applyList');



    Route::get('qualifications/apply','qualifications/apply');



    Route::get('station/getpoint','station/getpoint');


    Route::get('money/classify','money/classify');

    Route::get('tel/sos','tel/sos');
    Route::get('tel/insurance','tel/insurance');


    Route::get('message/message','message/message');


    Route::get('active/active','active/active');


    Route::get('appointment/appointment','appointment/appointment');

	Route::get('banner/banner','banner/banner');
	Route::get('banner/bannerAdd','banner/bannerAdd');





    Route::get('player/edit','player/edit');
    Route::get('player/upload','player/upload');

    Route::get('information/index','information/index');
    Route::get('information/create','information/create');
    Route::get('information/delete','information/delete');
    Route::get('information/edit','information/edit');
    Route::get('information/upload','information/upload');

    Route::get('game/index','game/index');
    Route::get('game/create','game/create');
    Route::get('game/adds','game/adds');
    Route::get('game/score','game/score');
    Route::get('game/delete','game/delete');
    Route::get('game/edit','game/edit');
    Route::get('game/read','game/read');
    Route::get('game/upload','game/upload');
    Route::get('game/data','game/data');
    Route::get('game/find','game/find');
    Route::get('game/download','game/download');
    Route::get('game/cha','game/cha');



})->prefix('admin/');


Route::group('index',function (){
	Route::get('index/index','index/index');
})->prefix('index');

