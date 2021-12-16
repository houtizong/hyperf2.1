<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use Hyperf\View\RenderInterface;
use Hyperf\DbConnection\Db;

class IndexController extends BaseController
{
    public function index(RenderInterface $render)
    {
        $tdk = [];
        $tdk['title'] = '自学编程_框架_前端_后端_教程分享交流-技术博客集';
        $tdk['keywords'] = '自学编程,建站seo,框架,前端,后端,教程分享,技术博客,PHP编程,GO编程,系统,数据库';
        $tdk['description'] = '技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        //$user = $this->request->input('user', 'Hyperf');
        //$method = $this->request->getMethod();

        $q = $this->request->input('q');

        //首页显示区分
        if (isset($q)) {
            if ($q == 'hot') {
                $art = DB::table('art')->select('art_id', 'title', 'content', 'pubtime', 'view', 'cat_id')->where('is_state', 0)->where('is_del', 1)->orderBy('view', 'desc')->paginate(65);
            }else {
                $art = DB::table('art')->select('art_id', 'title', 'content', 'pubtime', 'view', 'cat_id')->where('is_state', 0)->where('is_del', 1)->where('title','like',"%{$q}%")->paginate(65);
            }
        }else{
            $art = DB::table('art')->select('art_id', 'title', 'content', 'pubtime', 'view', 'cat_id')->where('is_state', 0)->where('is_del', 1)->orderBy('pubtime','desc')->paginate(65);

            //首页数据显示需求
            //调整优化后
            //1.根据栏目分组 分组查找数据
            //2.分组内部文章排序 内取5条数据根据时间排序
            //3.分组排序 根据内部文章更新时间先后排序
            /*SELECT
            cat_id , SUBSTRING_INDEX( GROUP_CONCAT( art_id ORDER BY pubtime DESC ), ',', 5 ) AS newids
            FROM ( SELECT * FROM art ORDER BY pubtime DESC LIMIT 10000 ) t
            GROUP BY cat_id  ORDER BY  pubtime DESC*/

            // 启用 SQL 数据记录功能
            //Db::enableQueryLog();
            // 打印最后一条 SQL 相关数据
            //var_dump(Arr::last(Db::getQueryLog()));

            /*$a = Db::table('art')->select('*')->where('is_state',0)->where('is_del',1)->orderBy('pubtime','desc');
            $b = Db::table('art')->select('cat_id',Db::raw('SUBSTRING_INDEX( GROUP_CONCAT( art_id ORDER BY pubtime DESC ), \',\', 5 ) AS newids'))
                ->fromSub($a, 'a')
                ->groupBy('cat_id')->orderBy('pubtime','desc')
                ->get();*/
            //print_r($b);
            /*$c = Db::table('art')->select('cat_id',Db::raw('SUBSTRING_INDEX( GROUP_CONCAT( art_id ORDER BY pubtime DESC ), \',\', 5 ) AS newids'))
                ->fromRaw('( SELECT * FROM art ORDER BY pubtime DESC LIMIT 10000 ) t')
                ->groupBy('cat_id')->orderBy('pubtime','desc')
                ->get();*/

            /*$list = [];
            foreach ($b as $v){
                $art = Db::table('art')->select('art_id', 'title', 'pubtime', 'view', 'cat_id')->whereIn('art_id', explode(',',$v->newids))->orderBy('pubtime','desc')->get();
                $list[$v->cat_id] = $art;
            }*/

//            $list = [];
//            foreach ($this->cats as $k=>$v) {
//                $art = Db::table('art')->select('art_id', 'title', 'pubtime', 'view', 'cat_id')->where('cat_id',$k)->where('is_state',0)->where('is_del',1)->orderBy('pubtime','desc')->take(1)->get();
//                $list[$k] = $art;
//            }
        }

        //最新文章
        $new_art = Db::table('art')->where('is_state',0)->where('is_del',1)->orderBy('pubtime','desc')->take(10)->get();
        //最热文章
        $hot_art = Db::table('art')->where('is_state',0)->where('is_del',1)->orderBy('view','desc')->take(10)->get();


        //近期评论 取出10条
        // $sql = 'select t1.nick,t1.comment,t1.art_id,t2.title from comment as t1 inner join art as t2 on t1.art_id=t2.art_id order by t1.pubtime desc limit 5';
        $new_comm = DB::table('comment')->join('art', 'art.art_id', '=', 'comment.art_id')
            ->select('comment.user_id','comment.username','comment.comment',DB::raw('(select `face` from `user` as a where a.`user_id`=`comment`.`user_id`) as face'),'art.art_id','art.title')
            ->orderBy('comment.pubtime','desc')
            ->take(5)
            ->get();

        //文章归档 格式：2017年01月
        //$sql = "select pubtime,FROM_UNIXTIME( `pubtime`,'%Y-%m') as time ,count(*) as num FROM art where  is_state=0 and is_del=1 group by time" ;
        $file = DB::table('art')->select('pubtime',DB::raw('FROM_UNIXTIME(pubtime,\'%Y-%m\') as time'))->where('is_state',0)->where('is_del',1)->groupBy('time')->get();

        //标签
        $tags = DB::table('tag')->select('*')->groupBy('tagname')->orderBy('tag_id','desc')->take(50)->pluck('tagname','tag_id');

        return $render->render('home/index/index',
            [
                'tdk' => $tdk,
                'tags' => $tags,
                'file' => $file,
                'art' => isset($art)?$art:[],
                'new_art' => $new_art,
                'hot_art'=> $hot_art,
                'new_comm'=> $new_comm,
                'cats' => $this->cats,
                'session' => $this->session->get('user')
            ]
        );
    }

    //关于我们
    public function about(RenderInterface $render)
    {
        $tdk = [];
        $tdk['title'] = '关于我们-技术博客集';
        $tdk['keywords'] = '关于我们';
        $tdk['description'] = '技术博客集是2021年4月份上线的，本站是个人站，本站数据是基于大数据采集等爬虫技术为基础助力分享知识，网站定位是一个技术发烧友分享站，技术分享，互联网分享等。';

        return $render->render('home/index/about',
            [
                'tdk'  => $tdk,
                'cats' => $this->cats,
                'session' => $this->session->get('user')
            ]
        );

    }


}
