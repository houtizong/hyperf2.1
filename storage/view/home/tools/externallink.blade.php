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
                <div class="col-md-12 column ui-sortable">
                    <div class="row clearfix">
                        <div class="col-md-12 column">
                            <div class="view">
                                <h3 style="padding: 5px;font-weight: bold;">自动发布外链(暂未开放) <?php  print_r($a); ?></h3>
                                <nav class="navbar navbar-default" role="navigation">
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <form class="navbar-form navbar-left" role="search">
                                            <div class="form-group"><input type="text" class="form-control" placeholder="自动发布外链，输入域名如：www.zongscan.com"></div>
                                            <button type="submit" class="btn btn-default">立即发外链</button>
                                        </form>
                                    </div>
                                </nav>
                            </div>
                            <div class="row clearfix" style="padding: 15px;">
                                自动发布外链发布工具原理：<br>
                                    自动发布外链发布工具收集了数千个网站网址，其中包括IP查询、SEO综合信息查询、SEO外链数量查询、Alexa排名查询以及PR值查询等等网站。
                                由于这些网址大多有查询记录，而且百度、谷歌等搜索引擎会抓取其中的网址，SEO外链工具会自动查询这几千个网址以达到留下无数记录供搜索引擎抓取，
                                当搜索引擎抓取之后就会增加一条外链，一般连续刷几天就能看到明显的提升效果。<br>
                                <br>
                                （1）大家都知道站长工具、爱站等查询域名的网站吧，当你查询过他就会留下你的网站链接，这样的链接就形成了外链。<br>
                                （2）自动发布外链由本站精心收集了数个ip、Alexa、pr查询等站长常用查询网站，由于这些网站大多有查询记录显示功能。<br>
                                （3）自动发布外链利用各种查询网站留下你的链接，达到自动发布外链的效果，可以被百度、谷歌、搜狗等搜索引擎快速收录。<br>
                                （4）使用自动发布外链会被认为作弊么？本工具是利用各种查询工具，模拟正常手工查询，不是作弊。<br>
                                （5）推荐使用方法：新站每天两次，老站每天一次。<br>
                                <br>
                                什么是外链：<br>
                                （1）外链就是别人的网站链接到自己的网站的一个链接，例如友情链接、软文外链、论坛外链、博客外链、贴吧外链等。<br>
                                （2）一些外链是通过我们自己在一些网站查询，而留下的一些痕迹被百度抓取收录，我们就会得到一个外链。<br>
                                （3）针对这种情况，我们开发了一个外链自动化工具去提交这些查询类工具，便于搜索引擎的抓取，也节省了大量的人工时间。<br>
                                （4）外链建设是一个稳定持久的工作，自动发布外链工具仅作为吸引蜘蛛之用，仅能做为网站的辅助作用。<br>
                                <br>
                                特别提示：<br>
                                （1）网址不要加http:// 后面不要加/ ，这样会更精准。<br>
                                （2）本工具是增加外链途径之一，外链来源多样化才是网站发展之道。<br>
                                自动发布外链发布工具仅作为吸引搜索引擎蜘蛛爬虫之用，并非属于SEO高质量外链范围，仅能作为辅助工具！
                                <p></p>
                            </div>
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
    @parent
@endsection







