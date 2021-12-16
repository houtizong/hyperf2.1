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
        <ul class="nav nav-tabs">
            <li class="{{isset($_GET['q'])?'':'active'}}"><a href="/">最新</a></li>
            <li class="{{isset($_GET['q'])?'active':''}}"><a href="?q=hot">最热</a></li>
            <li class="disabled"><a href="#">问答</a></li>
            <li class="dropdown pull-right">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">下拉<strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                    <li><a href="#">操作</a></li>
                    <li><a href="#">设置栏目</a></li>
                    <li><a href="#">更多设置</a></li>
                    <li class="divider"></li>
                    <li><a href="#">分割线</a></li>
                </ul>
            </li>
        </ul>
        <div class="list-group">
            @foreach($art as $item)
                <a href="/art/{{$item->art_id}}" class="list-group-item">
                    <object style="float:left;color:#999;background-color:#e8e8e8;padding:0.1rem 0.2rem;margin-right: 5px;"><a href="/cat/{{$item->cat_id}}">{{$cats[$item->cat_id]['catname']}}</a> </object>
                    <span style="float:right;color:#999;"><i class="icon ion-eye"></i> {{$item->view}} | <small>{{format_date($item->pubtime)}}</small></span>{{$item->title}}
                </a>
            @endforeach
        </div>
        @if($art->hasPages())
            <ul class="pagination">
                <li><a href="{{$art->previousPageUrl()}}" class="{{$art->currentPage()==1?'btn btn-large disabled':''}}"> < </a></li>
                <li><a href="#">{{$art->currentPage()}}</a></li>
                <li><a href="{{$art->nextPageUrl()}}"> > </a></li>
                <li><a href="?page={{$art->lastPage()}}"> 最后一条 </a></li>
            </ul>
        @endif
    </div>
    <li class="col-md-4 column" style="list-style: none">
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
        <p class="h-block">
            <!-- 横向ad -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-4802265324400044" data-ad-slot="1118187462" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </p>
        <div class="h-clear"></div>
        <p class="h-block"><strong>最新评论</strong>
            <ul class="h-block">
                @foreach($new_comm as $item)
                    <li class="list-group-item">在 &nbsp;<a href="/art/{{$item->art_id}}" class="list-group-item-heading">{{$item->title}}</a>&nbsp;中评论
                        <a href="/user/{{$item->user_id}}" class="pull-left"><img src="{{$item->face}}" alt="{{$item->username}}" width="20" style="border-radius: 2rem;"/></a>
                        <div class="list-group-item-text" style="height:auto;max-height: 7rem;overflow: hidden;">{!! $item->comment !!}</div>
                    </li>
                @endforeach
            </ul>
        </p>
        <p class="h-block"><strong>文章归档</strong>
        <ul class="h-block">
            @foreach($file as $item)
                <li>{{$item->time}}</li>
            @endforeach
        </ul>
        </p>
        {{--<p class="h-block">--}}
            {{--文章内嵌广告--}}
            {{--<ins class="adsbygoogle" style="display:block; text-align:center;" data-ad-layout="in-article" data-ad-format="fluid" data-ad-client="ca-pub-4802265324400044" data-ad-slot="2102120160"></ins>--}}
            {{--<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>--}}
        {{--</p>--}}
        <div class="h-clear"></div>
        <p class="h-block"><strong>文章标签</strong>
        <ul class="h-block">
            <li>@foreach($tags as $k=>$v) <button type="button" class="btn btn-default"><a href="">{{$v}}</a></button>  @endforeach </li>
        </ul>
        </p>
        <div class="h-clear"></div>
        @include('layouts.homelinks')
    </div>
</div>

@endsection
@section('js')
@parent
@endsection







