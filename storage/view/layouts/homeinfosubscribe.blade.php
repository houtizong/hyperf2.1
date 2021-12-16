<!-- 正方ad -->
<ins class="adsbygoogle" style="display:block;" data-ad-client="ca-pub-4802265324400044" data-ad-slot="1693614294" data-ad-format="auto" data-full-width-responsive="true"></ins>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
<p class="h-block">
    <strong>技术博客集 - 网站简介：</strong><br>
    <small>前后端技术：<br>后端基于Hyperf2.1框架开发,前端使用Bootstrap可视化布局系统生成</small><br>
    <small>网站主要作用：<br>1.编程技术分享及讨论交流，内置聊天系统; <br>2.测试交流框架问题，比如：Hyperf、Laravel、TP、beego; <br>3.本站数据是基于大数据采集等爬虫技术为基础助力分享知识，如有侵权请发邮件到站长邮箱，站长会尽快处理;<br>4.站长邮箱：514224527@qq.com;</small><br>
</p>
<div class="h-clear"></div>
<ul class="h-block">
    <a id="modal-599821" href="#modal-container-599821" role="button" class="btn" data-toggle="modal"><i class="icon ion-email" style="font-size: 1.8rem;"></i>&nbsp 订阅博客周刊
        <small style="color: red">{{isset($session) && $session->subscribe== 1?'已订阅':'去订阅'}}</small>
    </a>
    <div class="modal fade" id="modal-container-599821" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title" id="myModalLabel">订阅博客周刊规则</h4></div>
                <div class="modal-body">只针对用有效邮箱注册的同学有意义;<br>订阅后网站每周会发送上一周最新博客1-2篇到你的邮箱...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    @if (isset($session))
                        <button type="button" class="btn btn-primary" onclick="subscribe({{$session->subscribe==0?1:0}},{{$session->user_id}},'1')">{{$session->subscribe==0?'立即订阅':'取消订阅'}}</button>
                    @else
                        <button type="button" class="btn btn-primary" onclick="location.href='/user/login'">立即订阅</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</ul>
<div class="h-clear"></div>
