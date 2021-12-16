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

    <div class="col-md-8 column">
        <!-- 正方ad -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4802265324400044" data-ad-slot="1693614294" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>

        <div class="row clearfix">
            <div class="col-md-6 column">
                <div class="list-group">
                    <h2><a href="/tools/qrcode?url=https://www.zongscan.com/" class="list-group-item active">在线二维码生成</a></h2>
                    <a href="/tools/qrcode?url=https://www.zongscan.com/" class="list-group-item">在线帮助您轻松生成QR码。该功能基于endroid/qr-code组件包<br>
                        <span class="badge" style="font-weight: 100;color: #888;background-color: #fff;"><i class="icon ion-eye"></i>&nbsp; 2.1k</span><span style="font-size: 8px;color:#cccccc;">2021-05-18 14:50:03</span>
                    </a>
                </div>
            </div>

            <div class="col-md-6 column">
                <div class="list-group">
                    <h2><a href="/tools/externallink" class="list-group-item active">自动发布外链(暂未开放)</a></h2>
                    <a href="/tools/externallink" class="list-group-item">自动发布外链(暂未开放)<br>...<br>
                        <span class="badge" style="font-weight: 100;color: #888;background-color: #fff;"><i class="icon ion-eye"></i>&nbsp; 0</span><span style="font-size: 8px;color:#cccccc;">2021-07-07 14:50:03</span>
                    </a>
                </div>
            </div>

            <div class="col-md-6 column">
                <div class="list-group">
                    <h2><a href="/tools/phpcode" class="list-group-item active">PHP在线代码运行工具</a></h2>
                    <a href="/tools/phpcode" class="list-group-item">在线编译、运行 PHP 代码<br><br>
                        <span class="badge" style="font-weight: 100;color: #888;background-color: #fff;"><i class="icon ion-eye"></i>&nbsp; 1.1k</span><span style="font-size: 8px;color:#cccccc;">2021-07-16 11:50:03</span>
                    </a>
                </div>
            </div>

            <div class="col-md-6 column">
                <div class="list-group">
                    <h2><a href="/tools/shortlinks" class="list-group-item active">在线生成短网址</a></h2>
                    <a href="/tools/shortlinks" class="list-group-item">此功能可以帮您把长长的网址压缩成更短的url<br><br>
                        <span class="badge" style="font-weight: 100;color: #888;background-color: #fff;"><i class="icon ion-eye"></i>&nbsp; 0.6k</span><span style="font-size: 8px;color:#cccccc;">2021-08-12 15:07:03</span>
                    </a>
                </div>
            </div>

            <div class="col-md-6 column">
                <div class="list-group">
                    <h2><a href="/tools" class="list-group-item active">待开发</a></h2>
                    <a href="/tools" class="list-group-item">待开发<br>...<br>
                        <span class="badge" style="font-weight: 100;color: #888;background-color: #fff;"><i class="icon ion-eye"></i>&nbsp; 0</span><span style="font-size: 8px;color:#cccccc;">2021-05-18 14:50:03</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 column" style="list-style: none">
        @include('layouts.homeinfosubscribe')
        {{--new hot--}}
        @if(isset($new_art))
        <div class="tabbable h-block" id="tabs-871724">
            <ul class="nav nav-tabs">
                <li><a href="#panel-941265" data-toggle="tab">最新文章</a></li>
                <li class="active"><a href="#panel-813310" data-toggle="tab">最热文章</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane h-block" id="panel-941265">
                    @foreach($new_art as $item)
                        <ol><a href="/art/{{$item->art_id}}" target="_blank">{{$item->title}} <span class="badge" style="font-weight: 100;color: #888;background-color: #fff;">&nbsp;{{format_date($item->pubtime)}}</span></a></ol>
                    @endforeach
                </div>
                <div class="tab-pane active h-block" id="panel-813310">
                    @foreach($hot_art as $item)
                        <ol><a href="/art/{{$item->art_id}}" target="_blank">{{$item->title}} <span class="badge" style="font-weight: 100;color: #888;background-color: #fff;"><i class="icon ion-eye"></i>&nbsp;{{$item->view}}</span></a></ol>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <p class="h-block">
            <!-- 横向ad -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4802265324400044" data-ad-slot="1118187462" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </p>
        <div class="h-clear"></div>
        @include('layouts.homelinks')
    </div>
</div>

@endsection
@section('js')
@parent
@endsection







