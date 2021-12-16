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

        <p class="h-block"><strong>发布文章：</strong>
            <form class="h-block" id="myForm" method="post" action="/user/{{isset($detail->art_id)?'editart/'.$detail->art_id:'addart'}}" role="form">
                <div class="form-group">
                    <span id="check_art" style="font-size: 8px;color: red;display: none;padding-left: 40%;"></span>
                    <label>标题:</label><input type="text" name="title" value="{{isset($detail->art_id)?$detail->title:''}}" class="form-control">

                    <label>栏目:</label>
                    <select name="cat_id" class="form-control">
                        @foreach($cats as $item)
                            <option value="{{$item['cat_id']}}" {{isset($detail->art_id)&&$item->cat_id == $detail->cat_id?"selected":''}}>{{$item['catname']}}</option>
                        @endforeach
                    </select>

                    <label >内容:</label>
                    <div id="div-demo">{!! isset($detail->art_id)?$detail->content:'' !!}</div>
                    <textarea name="content" id="text1" style="display: none">{{ isset($detail->art_id)?$detail->content:'' }}</textarea>

                    <label>标签:   ( 用英文逗号分隔 比如： 标签a , 标签b )</label>
                    <input type="text" name="tags" value="{{isset($detail->art_id)?$detail->tags:''}}" class="form-control">
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
        </p>
        <div class="h-clear"></div>
    </div>

    <div class="col-md-4 column">
        @include('layouts.homeinfosubscribe')
        <div class="h-clear"></div>
    </div>
</div>

@endsection
@section('js')
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

<script type="text/javascript">
    $(document).ready(function() {
        // bind form using ajaxForm
        $('#myForm').ajaxForm({
            dataType:  'json',
            // success:   processJson
            success: function(data){
                if (data.error == 1) {
                    alert(data.info);
                    location.href = data.url;
                }else{
                    $("#check_art").html(data.info);
                    $("#check_art").css("display","block");
                };
            }
        });
    });
</script>
@parent
@endsection
