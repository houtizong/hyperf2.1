<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');
//关于我们
Router::get('/about', 'App\Controller\IndexController::about');


Router::get('/cat/{cid}', 'App\Controller\CatController::index');
Router::get('/art/{aid}', 'App\Controller\ArtController::index');
Router::post('/art/comment', 'App\Controller\ArtController::comment');
Router::post('/art/dianzan', 'App\Controller\ArtController::dianzan');

//用户
Router::addGroup('/user/',function (){
    //登录
    Router::addRoute(['GET', 'POST', 'HEAD'], 'login', 'App\Controller\UserController@login');
    //注册
    Router::addRoute(['GET', 'POST', 'HEAD'],'register','App\Controller\UserController@register');
    //退出
    Router::get('logout','App\Controller\UserController@logout');
    //个人中心
    Router::get('center','App\Controller\UserController@center');
    //编辑用户信息
    Router::addRoute(['GET', 'POST', 'HEAD'],'edituser','App\Controller\UserController@edituser');
    //发布文章
    Router::addRoute(['GET', 'POST', 'HEAD'],'addart','App\Controller\UserController@addart');
    //编辑文章
    Router::addRoute(['GET', 'POST', 'HEAD'],'editart/{aid}','App\Controller\UserController@editart');

    //mq 推送rabbit
    Router::addRoute(['GET'],'torabbitmsg','App\Controller\UserController@torabbitmsg');

    //订阅
    //Router::post('subscribe','App\Controller\UserController@subscribe');
    Router::addRoute(['GET', 'POST'],'subscribe','App\Controller\UserController@subscribe');

    //个人信息
    Router::get('{user_id}','App\Controller\UserController@userinfo');

    //发验证邮件 验证码
    Router::post('sendemail','App\Controller\UserController@sendemail');


    //Router::get('index','App\Controller\UserController@index');
    //Router::post('store','App\Controller\UserController@store');
    //Router::get('update','App\Controller\UserController@update');
    //Router::post('delete','App\Controller\UserController@delete');
});

//ws
Router::addServer('ws', function () {
    Router::get('/ws', 'App\Controller\WebSocketController');
});


//测试专用控制器
//Router::get('/test', 'App\Controller\TestController@index');

//长链接转段链接 跳转
Router::get('/to/{shortcode}', 'App\Controller\ToolsController@jumpurl');
