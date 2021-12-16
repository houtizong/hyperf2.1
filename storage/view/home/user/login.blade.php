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
                    <h3 style="padding: 5rem;">hyperf {{$tdk['keywords']}}</h3>
                    <form class="form-horizontal" id="myForm" action="{{$url}}" method="post" role="form">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">账号</label>
                            <div class="col-sm-10"><input type="email" name="email" class="form-control" id="inputEmail3" placeholder="请输入邮箱" /><span id="check_user" style="font-size: 8px;color: red;display: none;"></span></div>
                        </div>
                        @if($tdk['keywords'] == '注册')
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">用户</label>
                            <div class="col-sm-10"><input type="username" name="username" class="form-control" id="name" placeholder="请输入用户名称" /></div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">验证码</label>
                            <div class="col-sm-10"><input type="code" name="code" class="form-control" id="code" placeholder="请输入邮箱获取的验证码" />
                                <a href="javascript:;" title="点击获取验证码" onclick="emailcode(this,$('#inputEmail3').val())"><span class="code" style="float:right;">点击获取验证码</span></a>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10"><input type="password" name="password" class="form-control" id="inputPassword3" placeholder="请输入密码" /></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox"><label><input type="checkbox" />Remember me</label>@if($tdk['keywords'] != '注册')<a style="margin-left: 30px;" href="/user/register">去注册</a>@endif</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-default">Sign in</button></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 column"></div>
            </div>
        </div>
    </div>

@endsection
@section('js')
@parent
<script type="text/javascript">
    $(document).ready(function() {
        // bind form using ajaxForm
        $('#myForm').ajaxForm({
            dataType:  'json',
            // success:   processJson
            success: function(data){ console.log(data);
                if (data.error == 1) {
                    alert(data.info);
                    //location.reload();
                    location.href = "/user/center";
                }else{
                    $("#check_user").html(data.info);
                    $("#check_user").css("display","block");
                };
            }
        });
    });

    //注册发邮箱验证码
    function emailcode(obj,email) {
        //alert(email);
        $.ajax({
            url: "/user/sendemail",//请求地址
            type: "post",//请求方式
            dataType: "json",//返回数据类型
            data: {email:email},//发送的参数
            success: function (d) {
                console.log(d);
                if(d.error==0){
                    alert(d.info);
                }else{
                    $(obj).children('.code').html('已发送，注意查收');
                    $(obj).removeAttr("onclick");//防重复点击
                }
            },
            error:function(d){
                $(obj).children('.code').html('已发送，注意查收');
                $(obj).removeAttr("onclick");//防重复点击
            }
        })
    }
</script>
@endsection











