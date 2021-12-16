<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\View\RenderInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\DbConnection\Db;


class ArtController extends BaseController
{
    public function index(RenderInterface $render,ResponseInterface $response,int $aid)
    {
        //$catskey = array_column(\GuzzleHttp\json_decode(\GuzzleHttp\json_encode($this->cats),true),null,'cat_id');
        //to www
        if($aid < 427) {
            return $response->redirect('https://www.zongscan.com/demo333/'.$aid.'.html',301);
        }

        //文章
        $detail = DB::table('art')->select('art_id','title','content','pubtime','view','cat_id','author','user_id')->where('art_id',$aid)->where('is_state',0)->first();
        if(!$detail) {
            return $response->redirect('https://blog.zongscan.com/');
        }
        $detail->catname = $this->cats[$detail->cat_id]['catname'];

        $tdk = [];
        $tdk['title'] = $detail->title.'-技术博客集';
        $tdk['keywords'] = $detail->title.'_技术博客集';
        $tdk['description'] = mb_substr(strip_tags($detail->content),0,190);

        //进来浏览量加一
        DB::table('art')->where('art_id',$aid)->increment('view');

        //上一条下一下
        $updown['up'] = Db::table('art')->select('art_id','title')->where('art_id', '<', $aid)->orderBy('art_id', 'desc')->take(1)->first();
        $updown['down'] = Db::table('art')->select('art_id','title')->where('art_id', '>', $aid)->orderBy('art_id','asc')->take(1)->first();

        //根据id 取评论
        $comments = DB::table('comment')->select('*',DB::raw('(select `face` from `user` as a where a.`user_id`=`comment`.`user_id`) as face'))->where('art_id',$aid)->get()->toJson();
        $comments = $this->arrtree(\GuzzleHttp\json_decode($comments,true),'comment_id','fcomment_id');

        //文章归档 格式：2017年01月
        //$sql = "select pubtime,FROM_UNIXTIME( `pubtime`,'%Y-%m') as time ,count(*) as num FROM art where  is_state=0 and is_del=1 group by time" ;
        $file = DB::table('art')->select('pubtime',DB::raw('FROM_UNIXTIME(pubtime,\'%Y-%m\') as time'))->where('cat_id',$detail->cat_id)->where('is_state',0)->where('is_del',1)->groupBy('time')->get();

        //标签
        //$tags = Db::name('tag')->group('tagname')->order('tag_id desc')->limit(50)->column('tagname','tag_id');
        $tags = DB::table('tag')->select('*')->groupBy('tagname')->orderBy('tag_id','desc')->take(50)->pluck('tagname','tag_id');

        return $render->render('home/art/detail',
            [
                'tdk' => $tdk,
                'comments' => $comments,
                'tags' => $tags,
                'file' => $file,
                'detail' => $detail,
                'updown' => $updown,
                'cats' => $this->cats,
                'session' => $this->session->get('user')
            ]
        );
    }

    //对文章写评论
    public function comment(RenderInterface $render,ResponseInterface $response,RequestInterface $request)
    {
        $comment = $request->all();
        $data['art_id'] = $comment['art_id'];
        $data['comment'] = $comment['comment'];
        $data['fcomment_id'] = isset($comment['fcomment_id'])?$comment['fcomment_id']:0;

        //已登录
        if (!$this->session->has('user')) {
            return $response->redirect('/user/login');
        }

        $res = Db::table('user')->where('user_id',$this->session->get('user')->user_id)->first();
        $data['user_id'] = $res->user_id;
        $data['username'] = $res->username;
        $data['email'] = $res->email;

        $data['pubtime'] = time();
        $data['ip'] = $this->ip();

        DB::table('comment')->insert($data);
        return $response->redirect('/art/'.$data['art_id']);
    }

    //对评论点赞
    public function dianzan(RequestInterface $request)
    {
        $data = $request->all();
        if ($data) {
            $id = $data['id'];
            $res = DB::table('comment')->where('comment_id',$id)->increment('zan');
            if ($res) {
                $zan = Db::table('comment')->where('comment_id',$id)->value('zan');//获取最新点赞数
               return array('error' => 1, 'info' => '点赞成功', 'zan' => $zan);
            }else {
                return array('error' => 0, 'info' => '点赞失败');
            }
        }
    }

}
