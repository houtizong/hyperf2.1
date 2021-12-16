<!DOCTYPE html>
<html>
<head>
@section('meta')
<meta charset="utf-8">
@yield('tdk')
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="baidu-site-verification" content="code-qtmqw4nTHM" />
<meta name="360-site-verification" content="53f25c95d9ecc45ca680e9b4b9b9ee60" />
@show
@section('css')
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">
<script data-ad-client="ca-pub-4802265324400044" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
@include('layouts.homeheader')
@yield('content')
@include('layouts.homefooter')
</div>
</div>
</div>
@section('js')
<script type="text/javascript" src="/js/jquery.form.min.js"></script>
<script src="/js/home.js"></script>
<script>
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https'){
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        } else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?d71759aec820d158572d01aa41ec941a";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
@show
</body>
</html>