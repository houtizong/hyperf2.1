@extends('layouts.homebase')
@section('tdk')
<title>{{$tdk['title']}}</title>
<meta name="keywords" content="{{$tdk['keywords']}}" />
<meta name="description" content="{{$tdk['description']}}" />
@endsection
@section('css')
@parent
@endsection
@section('content')

    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="row clearfix">
                <div class="col-md-4 column"></div>
                <div class="col-md-4 column">
                    <h1 style="padding: 5rem;font-weight: bold;font-size: 20px;">{{$tdk['title']}}</h1>
                    <dl>

                        技术博客集是2021年4月份上线的，本站是个人站，<br>
                        本站数据是基于大数据采集等爬虫技术为基础助力分享知识，<br>
                        网站定位是一个技术发烧友个人捣鼓分享站，技术分享，互联网分享等。
                        <br>
                        <br>
                        架构技术：<br>
                        后端基于Hyperf2.1框架开发<br>
                        前端使用Bootstrap可视化布局系统生成
                        <br>
                        <br>
                        网站主要作用：<br>
                        1.互联网，编程技术分享及讨论交流，内置聊天系统;<br>
                        2.测试交流框架等问题，比如：Hyperf、Laravel、TP、beego;
                        <br>
                        <br>
                        站长邮箱：<br>
                        514224527@qq.com;
                        <br>
                        <br>
                        侵权处理：<br>
                        本站数据是基于大数据采集等爬虫技术为基础助力分享知识，<br>如有侵权请发邮件到站长邮箱，站长会尽快处理
                        <p></p>
                    </dl>
                </div>
                <div class="col-md-4 column"></div>
            </div>
        </div>
    </div>

@endsection
@section('js')
@parent
@endsection











