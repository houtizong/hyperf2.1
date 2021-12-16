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
                    <form class="form-horizontal" id="myForm" action="/user/edituser" method="post" role="form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">账号</label>
                            <div class="col-sm-10"><input disabled="disabled" value="{{$session->email}}" class="form-control" id="inputEmail3" /></div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">用户</label>
                            <div class="col-sm-10"><input disabled="disabled" value="{{$session->username}}" class="form-control" /><span id="check_user" style="font-size: 8px;color: red;display: none;"></span></div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10"><input type="password" name="password" value="{{$session->password}}" class="form-control" id="inputPassword3" placeholder="请输入密码" /></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile" class="col-sm-2 control-label">头像</label>
                            <div class="col-sm-10"><input type="file" name="face" id="exampleInputFile" placeholder="请输入密码"></div>
                            <p class="help-block">&nbsp;&nbsp;&nbsp; 请上传你喜欢的头像，不传则系统默认生成</p>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-default">提交</button></div>
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
</script>
@endsection











