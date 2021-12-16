@extends('layouts.homebase')
@section('tdk')
<title>{{$tdk['title']}}</title>
<meta name="keywords" content="{{$tdk['keywords']}}" />
<meta name="description" content="{{$tdk['description']}}" />
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/social-share.js/1.0.9/css/share.min.css">
@parent
@endsection
@section('content')

<div class="row clearfix">
    <div class="col-md-8 column">
        <blockquote>
            <h1>{{$detail->title}}</h1>
            <small><a href="/cat/{{$detail->cat_id}}">{{$detail->catname}}</a>  &nbsp/&nbsp <a href="/user/{{$detail->user_id}}">{{$detail->author}}</a> <cite> 发布于 {{format_date($detail->pubtime)}}</cite> &nbsp  <i class="icon ion-eye"></i> {{$detail->view}} </small>
            <!-- 横向ad -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4802265324400044" data-ad-slot="1118187462" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>

            {{--编辑--}}
            @if(isset($session->user_id) && $session->user_id == $detail->user_id)
            <a href="/user/editart/{{$detail->art_id}}" style="float: right;">编辑</a>
            @endif
        </blockquote>
        <dl> {!! $detail->content !!}</dl>
        <style type="text/css">.social-share p{font-size:8px;}</style>
        <div class="social-share"></div>

        <div class="h-clear"></div>
        <div class="clearfix h-block">
            <div class="col-md-6 column">
                @isset($updown['up'])
                    <span class="prev-page">上一篇：<a href="/art/{{$updown['up']->art_id}}">{{$updown['up']->title}}</a></span>
                @endisset
            </div>
            <div class="col-md-6 column">
                @isset($updown['down'])
                    <span class="next-page">下一篇：<a href="/art/{{$updown['down']->art_id}}">{{$updown['down']->title}}</a></span>
                @endisset
            </div>
        </div>
        {{--文章内嵌广告--}}
        {{--<ins class="adsbygoogle" style="display:block; text-align:center;" data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-4802265324400044" data-ad-slot="2102120160"></ins>--}}
        {{--<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>--}}

        <div class="h-clear"></div>
        <p class="h-block"><strong>请勿发布不友善或者负能量的内容。与人为善，比聪明更重要！</strong>
            <form class="h-block" method="post" action="comment" role="form">
                <div class="form-group">
                    <input type="hidden" name="art_id" value="{{ $detail->art_id }}">
                    <div id="div-demo"></div>
                    <textarea name="comment" id="text1" style="display: none">{{ isset($detail->art_id)?$detail->content:'' }}</textarea>
                    <font class="help-block">留言需要登陆哦</font>
                </div>
                <button type="submit" class="btn btn-default">评论</button>
            </form>
        </p>
        <div class="h-clear"></div>

        @foreach($comments as $one)
        <div class="media h-block">
            <a href="#" class="pull-left"><img src="{{$one['face']}}" class="media-object" width="30"/></a>
            <div class="media-body">
                <h4 class="media-heading">{{$one['username']}} <small>{{format_date($one['pubtime'])}}</small></h4><p>{!! $one['comment'] !!}</p>
                <form method="post" action="comment">
                    <input type="hidden" name="fcomment_id" value="{{$one['comment_id']}}">
                    <input type="hidden" name="art_id" value="{{ $detail->art_id }}">
                    <input class="h-block repcomment{{$one['comment_id']}}"  required="" type="text" name="comment" placeholder="请输入..." style="width: 80%">
                    <button style="padding: .78571429em 1.5em;border: none;background-color: #00a0e9;color: #fff;" type="submit">评论</button>
                </form>
                @if(isset($one['sub']))
                    @foreach($one['sub'] as $two)
                    <div class="media">
                        <a href="#" class="pull-left"><img src="{{$two['face']}}" class="media-object" width="30"/></a>
                        <div class="media-body">
                            <h4 class="media-heading">{{$two['username']}} <small>{{format_date($two['pubtime'])}}</small></h4><p>{!! $two['comment'] !!}</p>
                            <a href="javascript:;" title="为此评论点赞" style="color:#ada5a5;font-size: 16px;" onclick="dianzan(this,{{$two['comment_id']}},'')"><i class="icon ion-thumbsup"></i> <span class="rezan">{{$two['zan']}}</span></a>
                            <a href="javascript:;" title="回复 {{$two['username']}}" style="color:#ada5a5;font-size: 16px;" onclick="$('.repcomment{{$one['comment_id']}}').val('@'+'{{$two['username']}}# ');$('.repcomment{{$one['comment_id']}}').focus();"><i class="icon ion-ios-undo"></i></a>
                        </div>
                    </div>
                    @endforeach
                @endif
                <div class="h-clear"></div>
                <a href="javascript:;" title="为此评论点赞" style="color:#ada5a5;font-size: 16px;" onclick="dianzan(this,{{$one['comment_id']}},'')"><i class="icon ion-thumbsup"></i> <span class="rezan">{{$one['zan']}}</span></a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="col-md-4 column">
        @include('layouts.homeinfosubscribe')
        <p class="h-block"><strong>文章归档</strong>
            <ul class="h-block">
            @foreach($file as $item)
                <li>{{$item->time}}</li>
            @endforeach
            </ul>
        </p>
        <p class="h-block">
            <!-- 横向ad -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4802265324400044" data-ad-slot="1118187462" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </p>
        <div class="h-clear"></div>
        <p class="h-block"><strong>文章标签</strong>
        <ul class="h-block"><li>@foreach($tags as $k=>$v) <button type="button" class="btn btn-default"><a href="">{{$v}}</a></button>  @endforeach </li></ul>
        </p>
        <div class="h-clear"></div>
        @include('layouts.homelinks')
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.bootcdn.net/ajax/libs/social-share.js/1.0.9/js/share.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/lrsjng.jquery-qrcode/0.9.5/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/wangeditor@latest/dist/wangEditor.min.js"></script>
<script type="text/javascript">
    $(function (){
        var E = window.wangEditor
        if (document.getElementById('div-demo')) {
            var editor = new E('#div-demo')

            // 配置菜单栏，设置不需要的菜单
            editor.config.excludeMenus = [
                'italic',
                'underline',
                'strikeThrough',
                'indent',
                'emoticon',
                'video'
            ]

            editor.config.uploadImgShowBase64 = true
            editor.config.height = 200

            const $text1 = $('#text1')
            editor.config.onchange = function (html) {
                // 第二步，监控变化，同步更新到 textarea
                $text1.val(html)
            }
            editor.create()
            // 第一步，初始化 textarea 的值
            $text1.val(editor.txt.html())
        }
    });
</script>
@parent
@endsection







