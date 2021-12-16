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
                <div class="col-md-12 column">
                    <div class="row clearfix">
                        <h3 style="padding: 5px;font-weight: bold;">在线生成网址url二维码</h3>
                        <p>使用方式：</p>
                        <p>在网站链接后面?url=你自己要生成二维码的链接</p>
                        <p>默认会生成https://www.zongscan.com/的二维码</p>
                        <p>下载：</p>
                        <p>自行下载该二维码，直接把鼠标移动到二维码图片上面，右击另存为下载</p>
                        <img src="{{$img}}" alt="二维码">
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
            <div class="h-clear"></div>
            @include('layouts.homelinks')
        </div>
    </div>

@endsection
@section('js')
    @parent
@endsection












