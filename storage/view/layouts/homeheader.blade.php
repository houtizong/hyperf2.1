<div class="row clearfix">
    <div class="col-md-12 column">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">技术博客集</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a  class="navbar-brand" href="https://blog.zongscan.com/"><img src="/images/home/logo1.png" alt="技术博客集" width="110" height="31"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                    <li><a href="/cat/42">贴吧</a></li>
                    <li><a href="/cat/1">互联网</a></li>
                    <li><a href="/tools">在线工具</a></li>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">更多分类<strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            @foreach($cats as $item)
                                <li><a href="/cat/{{$item['cat_id']}}">{{$item['catname']}}</a></li><li class="divider"></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <form action="/" class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="请输入...">
                            <div class="input-group-btn">
                                <button class="btn btn-block" id="btnSearch"  style="background:#ccc;"><span class="glyphicon glyphicon-search"></span></button>
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    @if (isset($session))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img alt="140x140" src="{{ $session->face }}" class="h-headimg">{{ $session->username }}<strong class="caret"></strong>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/user/center">个人中心</a></li>
                            <li><a href="/user/edituser">密码头像修改</a></li>
                            <li><a href="#" onclick="alert('加入收藏失败，\n请使用Ctrl+D进行添加！')">我的收藏</a></li>
                            <li><a href="/user/addart">发布文章</a></li>
                            <li class="divider"></li>
                            <li>
                                <form method="get" action="/user/logout">
                                    <a href="/user/logout" onclick="event.preventDefault();this.closest('form').submit();" style="display: block;padding: 3px 20px;"><i class="icon ion-android-exit"></i> &nbsp 退出</a>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li><a href="/user/center">消息通知</a></li>
                    <li><a href="/user/register">注册</a></li>
                    <li><a href="/user/login">登录</a></li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>
