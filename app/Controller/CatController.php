<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\View\RenderInterface;
use Hyperf\DbConnection\Db;


class CatController extends BaseController
{
    public function index(RenderInterface $render,int $cid)
    {
        $q = $this->request->input('q');
        //$cid = $this->request->input('cid');

        $cat = array_column(\GuzzleHttp\json_decode(\GuzzleHttp\json_encode($this->cats),true),null,'cat_id');

        $tdk = [];
        $tdk['title'] = $cat[$cid]['catname'].'_自学编程_框架_前端_后端_教程分享交流-技术博客集';
        $tdk['keywords'] = $cat[$cid]['catname'].'栏目,技术博客集';
        $tdk['description'] = $cat[$cid]['catname'].'栏目,技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        //文章
        if (isset($q)) {
            if ($q == 'hot') {
                $art = DB::table('art')->select('art_id', 'title', 'content', 'pubtime', 'view', 'cat_id')->where('cat_id',$cid)->where('is_state', 0)->where('is_del', 1)->orderBy('view', 'desc')->paginate(65);
            }else {
                $art = DB::table('art')->select('art_id', 'title', 'content', 'pubtime', 'view', 'cat_id')->where('cat_id',$cid)->where('is_state', 0)->where('is_del', 1)->where('title','like',"%{$q}%")->paginate(65);
            }
        }else{
            $art = DB::table('art')->select('art_id','title','content','pubtime','view','cat_id')->where('cat_id',$cid)->where('is_state',0)->where('is_del',1)->orderBy('art_id','desc')->paginate(65);
        }

        //近期评论 取出10条
        // $sql = 'select t1.nick,t1.comment,t1.art_id,t2.title from comment as t1 inner join art as t2 on t1.art_id=t2.art_id order by t1.pubtime desc limit 5';
        $new_comm = DB::table('comment')->join('art', 'art.art_id', '=', 'comment.art_id')
            ->select('comment.user_id','comment.username','comment.comment',DB::raw('(select `face` from `user` as a where a.`user_id`=`comment`.`user_id`) as face'),'art.art_id','art.title')
            ->orderBy('comment.pubtime','desc')
            ->take(5)
            ->get();


        //文章归档 格式：2017年01月
        //$sql = "select pubtime,FROM_UNIXTIME( `pubtime`,'%Y-%m') as time ,count(*) as num FROM art where  is_state=0 and is_del=1 group by time" ;
        $file = DB::table('art')->select('pubtime',DB::raw('FROM_UNIXTIME(pubtime,\'%Y-%m\') as time'))->where('cat_id',$cid)->where('is_state',0)->where('is_del',1)->groupBy('time')->get();

        //标签
        $tags = DB::table('tag')->select('*')->groupBy('tagname')->orderBy('tag_id','desc')->take(50)->pluck('tagname','tag_id');


        return $render->render('home/index/index',
            [
                'tdk' => $tdk,
                'tags' => $tags,
                'file' => $file,
                'art' => $art,
                'new_comm'=> $new_comm,
                'cats' => $this->cats,
                'session' => $this->session->get('user')
            ]
        );
    }
}
