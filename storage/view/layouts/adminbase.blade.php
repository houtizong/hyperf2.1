<!DOCTYPE html>
<html>
<head>
@section('meta')
<meta charset="utf-8">
@yield('tdk')
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="baidu-site-verification" content="code-qtmqw4nTHM" />
@show
@section('css')
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">
<!-- Fonts -->
{{--<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">--}}
<!-- Styles -->
<link rel="stylesheet" href="/css/home/public.css">
<link rel="stylesheet" type="text/css" href="/css/app.css">
@show
@yield('headext')
</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            @include('layouts.adminheader')
            @yield('content')
            @include('layouts.adminfooter')
        </div>
    </div>
</div>
@section('js')
<script>
</script>
@show
</body>
</html>