@extends('layouts.homebase')
@section('tdk')
<title>{{$tdk['title']}}</title>
<meta name="keywords" content="{{$tdk['keywords']}}" />
<meta name="description" content="{{$tdk['description']}}" />
@endsection
@section('css')
<style>
        .talk-window {
            height:500px;
            border: 1px solid #d2d6dc;
        }
        .tw-title {
            text-align:center;
            line-height:40px;
            font-size:14px;
            font-weight:bold;
            color:#666;
            position:relative;
        }
        .close-tw-window {
            display:inline-block;
            width:20px;
            height:20px;
            position:absolute;
            right:10px;
            top:10px;
            line-height:20px;
            font-size:24px;
            cursor:pointer;
            color:#666;
        }
        .close-tw-window:hover {
            color:#333;
        }
        .tw-content {
            padding:0 10px 150px;
            width:100%;
            height:calc(100% - 40px);
        }
        .talk-list-div {
            width:100%;
            height:100%;
            border:5px double #ccc;
            padding:5px 10px;
            overflow:auto;
        }
        .msg-div {
            overflow:hidden;
            margin:20px 0;
        }
        .other-msg-div {
            float:left;
            max-width:260px;
            position:relative;
            padding-left:35px;
        }
        .header-img-div {
            width:30px;
            height:30px;
            overflow:hidden;
            border-radius:30px;
        }
        .other-msg-div .header-img-div {
            position:absolute;
            left:0;
            top:5px;
        }
        .my-msg-div {
            float:right;
            max-width:260px;
            position:relative;
            padding-right:35px;
        }
        .my-msg-div .header-img-div {
            position:absolute;
            right:0;
            top:5px;
        }
        .header-img-div img {
            width:100%;
            height:100%;
        }
        .msg-content {
            padding:10px;
            border-radius:5px;
        }
        .other-msg-div .msg-content {
            background-color:#f4ecdd;
            color:#333;
        }
        .my-msg-div .msg-content {
            background-color:#403dff;
            color:white;
        }
        .talk-operate-div {
            width:100%;
        }
        .talk-operate-btn-list {
            font-size:12px;
        }
        .talk-operate-textarea {
            height:75px;
        }
        .talk-operate-textarea textarea {
            width:100%;
            min-height:55px;
            padding:5px 10px;
            background-color:#eee;
            resize:none;
        }
        .send-btn {
            text-align:right;
        }
        .send-btn span {
            display:inline-block;
            padding:0 20px;
            background-color:#403dff;
            color:white;
            font-size:14px;
            line-height:30px;
            cursor:pointer;
            border-radius:5px;
        }
        /*123    */
        .red{ border:1px solid #d00; background:#ffe9e8; color:#d00;}

    </style>
@parent
@endsection
@section('content')

    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="row clearfix">
                <div class="col-md-2 column">
                    <img alt="140x140" src="{{$userinfo->face}}" />
                    <div class="list-group">
                        <a href="#" class="list-group-item active">{{$userinfo->username}}</a>
                        <div class="list-group-item">?????????</div>
                        <div class="list-group-item">????????????{{format_date($userinfo->regtime)}}</div>
                        <div class="list-group-item">??????????????????{{format_date($userinfo->lastlogin)}}</div>
                        <div class="list-group-item"><span class="badge">14</span> Help</div>
                    </div>
                </div>
                <div class="col-md-6 column">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">??</button>
                        <strong> ????????? </strong> ???????????????????????????????????????????????????????????? <img src="/images/home/doge.png" alt="???????????????" style="width:20px;float:left;border-radius:10px;">
                    </div>
                    <blockquote><p>????????????</p><small>{{$userinfo->signature}}</small></blockquote>
                    <div class="h-clear"></div>
                    <p class="h-block"><strong>{{$userinfo->username}}??????????????????</strong></p><div class="h-clear"></div>
                    <div class="list-group">
                        @foreach($art as $item)
                            <a href="/art/{{$item->art_id}}" class="list-group-item"><span style="float:right;color:#999;"><i class="icon ion-eye"></i> {{$item->view}} | <small>{{format_date($item->pubtime)}}</small></span>{{$item->title}}</a>
                        @endforeach
                    </div>
                    @if($art->hasPages())
                        <ul class="pagination">
                            <li><a href="{{$art->previousPageUrl()}}" class="{{$art->currentPage()==1?'btn btn-large disabled':''}}"> < </a></li>
                            <li><a href="#">{{$art->currentPage()}}</a></li>
                            <li><a href="{{$art->nextPageUrl()}}"> > </a></li>
                            <li><a href="{{$art->lastItem()}}"> ???????????? </a></li>
                        </ul>
                    @endif
                </div>
                <div class="col-md-4 column">
                    <div id="talk-window" class="talk-window">
                        <div class="tw-title">{{$userinfo->username}} - ???????????? <a id="msgss"></a> <span class="close-tw-window">??</span></div>
                        <div class="tw-content">
                            <div class="talk-list-div"><a href="javascript:;" id="bottom-link"></a></div>
                            <div class="talk-operate-div">
                                <div class="talk-operate-btn-list">?????????emoji???????????????????????????</div>
                                <div class="talk-operate-textarea"><textarea id="msg-text" placeholder="??????,?????????..."></textarea></div>
                                <div class="send-btn">
                                    <button id="sendBtn" class="btn btn-primary button" style="margin-right: 10px;">??????</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-clear"></div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        function getCurrentDate(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            var h = date.getHours();
            var min = date.getMinutes();
            var s = date.getSeconds();
            var str=y+'???'+(m<10?('0'+m):m)+'???'+(d<10?('0'+d):d)+'???  '+(h<10?('0'+h):h)+':'+(min<10?('0'+min):min)+':'+(s<10?('0'+s):s);
            return str;
        }
        function shake(ele,cls,times){
            var i = 0,t= false ,o =ele.attr("class")+" ",c ="",times=times||2;
            if(t) return;
            t= setInterval(function(){
                i++;
                c = i%2 ? o+cls : o;
                ele.attr("class",c);
                if(i==2*times){
                    clearInterval(t);
                    ele.removeClass(cls);
                }
            },200);
        };
        /*###################*/
        $(function() {
            //=========================?????????====================================
            var $window = $(window);
            var $messageArea = $('#bottom-link');        // ?????????????????????
            var $inputArea = $('#msg-text');             // ?????????????????????
            $inputArea.focus();                          // ????????????????????????
            var connected = false;                      // ?????????????????????????????????

            //====================webSocket??????======================
            // ????????????webSocket??????
            var socket = new WebSocket('wss://'+window.location.host+'/ws');
            // ???webSocket???????????????????????????
            socket.onopen = function () {
                console.log("webSocket open");
                connected = true;
            };
            // ??????webSocket?????????????????????
            socket.onclose = function () {
                console.log("webSocket close");
                connected = false;
            };

            window.setInterval(function () {            //??????5?????????????????????????????????websocket??????????????????????????????
                socket.send('{"type":"ping"}');
            }, 5000);

            //=======================?????????????????????===========================
            // ??????webSocket????????????????????????????????????
            socket.onmessage = function(event) {

                if (event.data == 'Ping'){
                    console.log("ping");
                } else if(event.data.indexOf('wssl') != '-1') {
                    if (event.data == 'Opened') {
                        console.log("revice:", event.data);
                        var type = 1;
                        var msg = '?????????';
                    } else {
                        // ????????????????????????????????????json??????
                        var data = JSON.parse(event.data);
                        console.log("revice:" , data);

                        var name = data.username;
                        var uid = data.uid;
                        var face = data.face;
                        var type = 0;
                        var msg = data.message;

                        //??????????????????
                        if (name != '{{$userinfo->username}}') {
                            $('#msgss').text('????????????');
                            shake($("#msgss"),"red",30);
                        }
                    }

                    // type???0?????????????????????
                    var $messageDiv;
                    if (type == 0) {
                        var str = '<div class="msg-div">';
                        if (uid != '{{$userinfo->user_id}}') {
                            str += '<div class="other-msg-div">';
                        }else{
                            str += '<div class="my-msg-div">';
                        }
                        str += '<div class="header-img-div">';
                        //str += '<img src="' + face + '" />';
                        str += '</div>';
                        str += '<div class="msg-content">';
                        str += msg;
                        str += '</div>';
                        str += '</div>';
                        str += '</div>';
                        var $messageDiv = $("#bottom-link").data('username', name).append(str);
                        scrollHeight = $('.talk-list-div').prop("scrollHeight");
                        $('.talk-list-div').scrollTop(scrollHeight, 200);
                    } else {// type???1???2???????????????????????????
                        var $messageBodyDiv = $('<span style="color:#999999;">').text(msg);
                        $messageDiv = $('<ol>').append($messageBodyDiv);
                    }
                    $messageArea.append($messageDiv);
                }
            }
            //========================????????????==========================
            // ??????????????????
            $window.keydown(function (event) {
                // 13??????????????????
                if (event.which === 13) {
                    sendMessage();
                    typing = false;
                }
            });
            // ????????????????????????
            $("#sendBtn").click(function () {
                sendMessage();
            });
            // ??????webSocket????????????????????????
            function sendMessage () {
                var inputMessage = $inputArea.val();  // ?????????????????????
                if (inputMessage && connected) {
                    $inputArea.val('');               // ?????????????????????
                    var messages = '{"type":"wssl","uid":"{{$userinfo->user_id}}","message":"'+ inputMessage + '"}';
                    socket.send(messages);            // ??????WebSocket??????????????????
                    console.log("send message:" + messages);
                }
            }
        });
    </script>
@parent
@endsection











