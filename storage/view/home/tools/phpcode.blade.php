@extends('layouts.homebase')
@section('tdk')
    <title>{{$tdk['title']}}</title>
    <meta name="keywords" content="{{$tdk['keywords']}}" />
    <meta name="description" content="{{$tdk['description']}}" />
@endsection
@section('css')
    <style type="text/css">
        /*html, body {height: 100%;}*/
        /** {margin: 0px; padding: 0px;}*/
        #main {height: calc(60% - 50px);}
        #editor, #wall, #result {width: calc(50% - 30px); height: 100%; font-size: 14px; float: left;}
        #wall {width: 30px; background-color: #FBF1D3;}
        #result {height: calc(100% - 10px); padding: 5px; overflow-y: auto;}
        #header, #header-left, #header-right {height: 50px; line-height: 50px; background-color: #FBF1D3; float: left;}
        #header {width: 100%;}
        #header-left {width: 50%; font-size: 18px; text-align: center;}
        #btn {padding: 3px 5px; margin: 10px 30px 5px 0; cursor: pointer; float: right;}
    </style>
    @parent
@endsection
<script src="/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
@section('content')
    <div class="row clearfix">

        <div class="col-md-8 column">
            <!-- 正方ad -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4802265324400044" data-ad-slot="1693614294" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>

            <div class="row clearfix">
                <div class="col-md-12 column">
                    <div class="row clearfix" style="padding: 15px;">
                        <div id="header">
                            <div id="header-left">PHP在线代码运行工具
                                <button type="submit" id="btn" class="btn btn-default">执行代码 [RUN]</button>
                            </div>
                        </div>
                        <div id="main">
                            <div id="editor"></div>
                            <div id="wall"></div>
                            <div id="result"></div>
                        </div>
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
    <script type="text/javascript">
        var editor = ace.edit("editor");
        //console.log(editor);
        editor.setTheme("ace/theme/solarized_light");
        editor.session.setMode("ace/mode/php");
        editor.setValue("<\?php \n\t",1);
    </script>
    <script type="text/javascript">
        var btn = document.getElementById('btn');
        btn.onclick = function()
        {
            var xhr = null;
            if(window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            } else if(window.ActiveXObject) {
                xhr = new ActiveXObject('Microsoft.XMLHTTP');
            }
            xhr.onreadystatechange = function() {
                //console.log(xhr);
                if(xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('result').innerHTML = xhr.response;
                }
            }
            xhr.open('POST', `runcode`, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('code=' + editor.getValue());
        }
    </script>
    @parent
@endsection












