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

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];

use think\console\command\optimize\Route as OptimizeRoute;
use think\Route;
// //商品添加
// Route::get('goods_creat','admin/goods/creat',['ext' => 'html']);
// Route::post('goods_save','admin/goods/save',['ext' => 'html']);

// //商品修改
// Route::get('good_update:id','admin/goods/edit',['ext' => 'html'],['id' =>'\d+']);
// Route::post('goods_save','admin/goods/save',['ext' => 'html']);

// //商品查询
// Route::get('goods_index','admin/goods/index',['ext' => 'c']);
// //商品删除
// Route::get('goods_delete','admin/goods/delete',['ext' => 'c']);
// //进入页
// Route::get('index','admin/index/index',['ext' => 'c']);
Route::resource('goods','admin/goods',['ext => html'],['id' => '\d+']);
Route::resource('news','api/news',['ext => html'],['id' => '\d+']);
Route::resource('api_goods','api/goods',['ext => html'],['id' => '\d+']);
//商品类型管理
Route::resource('goodstype','admin/goodstype',['ext => html'],['id' => '\d+']);
Route::resource('attribute','admin/attribute',['ext => html'],['id' => '\d+']);
Route::resource('user','admin/user',['ext => html'],['id' => '\d+']);
//api
Route::get('api/v1/news','api/News/index');
Route::get('api/v1/detail','api/News/detail');