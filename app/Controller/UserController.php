<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\View\RenderInterface;
use Hyperf\DbConnection\Db;
//use App\Request\FooRequest;

use App\Model\User;
use App\Mail\subscribe;
use HyperfExt\Mail\Mail;

use Hyperf\Amqp\Producer;
use App\Amqp\Producer\DemoProducer;
use Hyperf\Utils\ApplicationContext;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

use Hyperf\Di\Annotation\Inject;  //引入

class UserController extends BaseController
{
    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    //个人信息 无需登录
    public function userinfo(RenderInterface $render,ResponseInterface $response,int $user_id)
    {
        $userinfo = Db::table('user')->where('user_id', $user_id)->first();
        //return $response->json($userinfo);
        if(!$userinfo) {
            return $response->redirect('/user/login');
        }

        $tdk = [];
        $tdk['title'] = $userinfo->username.' 个人信息-技术博客集';
        $tdk['keywords'] = $userinfo->username.' 个人信息';
        $tdk['description'] = $userinfo->username.' 个人信息，技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        $art = DB::table('art')->select('art_id','title','content','pubtime','view','cat_id')
            ->where('user_id',$user_id)->where('is_state',0)->where('is_del',1)
            ->orderBy('art_id','desc')->paginate(10);

        return $render->render('home/user/userinfo',
            [
                'tdk' => $tdk,
                'cats'=> $this->cats,
                'userinfo'=> $userinfo,
                'art' => $art,
            ]
        );
    }

    //个人中心
    public function center(RenderInterface $render,ResponseInterface $response)
    {
        $tdk = [];
        $tdk['title'] = '个人中心-技术博客集';
        $tdk['keywords'] = '个人中心';
        $tdk['description'] = '个人中心，技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        //$redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
        //$redis->hMSet('wssl',['htz'=>18]);
        //$redis->hMSet('wssl',['test'=>16]);
        //$redis->hMSet('wssl',['test1'=>16]);

        //$redis->hDel('wssl', 'test1');
        //$redis->del('wssl');

        //$aa = $redis->hGetAll('wssl');
        //$aa = $redis->hGet('wssl', 'htz');

        //$aa = User::query()->where('user_id', 1)->first();
        //$aa->aaa = 12345678;
        //var_dump($aa);

        if (!$this->session->has('user')) {
            return $response->redirect('/user/login');
        }

        $art = DB::table('art')->select('art_id','title','content','pubtime','view','cat_id')
            ->where('user_id',$this->session->get('user')->user_id)->where('is_state',0)->where('is_del',1)
            ->orderBy('art_id','desc')->paginate(10);

        //$user = Db::table('user')->where('user_id',$this->session->get('user_id'))->first();
        //return $response->json($user);

        return $render->render('home/user/center',
            [
                'tdk' => $tdk,
                'cats'=> $this->cats,
                'art' => $art,
                'session' => $this->session->get('user')
            ]
        );

    }
    //编辑用户信息
    public function edituser(RenderInterface $render,RequestInterface $request,\League\Flysystem\Filesystem $filesystem)
    {
        $tdk = [];
        $tdk['title'] = '编辑用户信息-技术博客集';
        $tdk['keywords'] = '编辑用户信息';
        $tdk['description'] = '编辑用户信息，技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        if ($this->request->isMethod('post')) {
            //获取上传的文件
            $file = $this->request->file('face');
            if(isset($file)){
                //资源
                $stream = fopen($file->getRealPath(), 'r+');
                //重命名 拼接上传路径
                $rename = date('Y-m-d').uniqid() .'.'.explode('.',$file->getClientFilename())[1];
                $filesystem->writeStream('face/'.$rename, $stream);
                // Check if a file exists
                if(!$filesystem->has('face/'.$rename)){
                    return array('error' => 0, 'info' => '头像上传失败，请重新上传');
                }
                //把不是默认头像的旧头像删了
                if($this->session->get('user')->face != '/upload/face/mrface.png'){
                    // Delete Files
                    $filesystem->delete(strtr($this->session->get('user')->face, array("/upload/" => '')));
                }
                fclose($stream);

                $data['face'] = '/upload/face/'.$rename;
            }

            if( $request->has('password') && $request->input('password') != $this->session->get('user')->password) {
                $validator = $this->validationFactory->make(
                    $request->all(), [
                        'password' => 'required|min:6|max:12',
                    ]
                );
                if ($validator->fails()){ // Handle exception
                    return array('error' => 0, 'info' => $validator->errors()->first());
                }
                $data['password'] = md5($this->request->input('password'));
            }

            $res = Db::table('user')->where('user_id', $this->session->get('user')->user_id)->update($data);

            if($res){
                //写session
                $this->session->set('user', Db::table('user')->where('user_id', $this->session->get('user')->user_id)->first());

                return array('error' => 1, 'info' => '编辑成功');
            }else{
                return array('error' => 0, 'info' => '编辑失败或没有变动');
            }
        }

        return $render->render('home/user/edituser',
            [
                'tdk' => $tdk,
                'cats'=> $this->cats,
                'session' => $this->session->get('user')
            ]
        );
    }
    //发布文章
    public function addart(RenderInterface $render,ResponseInterface $response,RequestInterface $request)
    {
        $tdk = [];
        $tdk['title'] = '发布文章-技术博客集';
        $tdk['keywords'] = '发布文章';
        $tdk['description'] = '发布文章，技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        if (!$this->session->has('user')) {
            return $response->redirect('/user/login');
        }
        //账号被冻结 清除session
        $userinfo = Db::table('user')->where('user_id', $this->session->get('user')->user_id)->first();
        if($userinfo->status != 1){
            $this->session->clear();
        }

        //title: 313 cat_id: 1 content: <p>6666</p>  tags: 88
        $data = $request->all();
        if ($this->request->isMethod('post')) {
            $validator = $this->validationFactory->make(
                $data,
                [
                    'title' => 'required|max:80',
                    'cat_id' => 'required|numeric',
                    'content' => 'required',
                    'tags' => 'required|max:50',
                ]
            );
            if ($validator->fails()){ // Handle exception
                $data = array('error' => 0, 'info' => $validator->errors()->first());
                return $data;
            }

            $data['user_id'] = $this->session->get('user')->user_id;
            $data['author'] = $this->session->get('user')->username;
            $data['pubtime'] = time();
            $data['is_state'] = 0;
            $id = Db::table('art')->insertGetId($data);
            if($id){
                $tags = array_chunk(explode(',', $data['tags']), 1);
                foreach ($tags as &$v) {
                    $v['tagname'] = $v[0];unset($v[0]);
                    $v['art_id'] = $id;
                    $v['addtime'] = time();
                }
                //添加标签
                Db::table('tag')->insert($tags);

                return array('error' => 1, 'info' => '发布成功', 'url' => '/art/'.$id);
            }else{
                return array('error' => 0, 'info' => '发布失败');
            }
        }

        return $render->render('home/user/addart',
            [
                'tdk' => $tdk,
                'cats' => $this->cats,
                'session' => $this->session->get('user')
            ]
        );
    }
    //编辑文章
    public function editart(RenderInterface $render,ResponseInterface $response,RequestInterface $request,int $aid)
    {
        $tdk = [];
        $tdk['title'] = '编辑文章-技术博客集';
        $tdk['keywords'] = '编辑文章';
        $tdk['description'] = '编辑文章，技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        if (!$this->session->has('user')) {
            return $response->redirect('/user/login');
        }
        //账号被冻结 清除session
        $userinfo = Db::table('user')->where('user_id', $this->session->get('user')->user_id)->first();
        if($userinfo->status != 1){
            $this->session->clear();
        }

        //文章
        $detail = DB::table('art')->select('art_id','title','content','pubtime','view','cat_id','author','user_id','tags')->where('art_id',$aid)->first();

        //title: 313 cat_id: 1 content: <p>6666</p>  tags: 88
        $data = $request->all();
        if ($this->request->isMethod('post')) {
            $validator = $this->validationFactory->make(
                $data,
                [
                    'title' => 'required|max:80',
                    'cat_id' => 'required|numeric',
                    'content' => 'required',
                    'tags' => 'required|max:50',
                ]
            );
            if ($validator->fails()){ // Handle exception
                $data = array('error' => 0, 'info' => $validator->errors()->first());
                return $data;
            }

            $data['lastup'] = time();

            $res = Db::table('art')->where('art_id', $aid)->update($data);
            if($res){
                $tags = array_chunk(explode(',', $data['tags']), 1);
                foreach ($tags as &$v) {
                    $v['tagname'] = $v[0];unset($v[0]);
                    $v['art_id'] = $aid;
                    $v['addtime'] = time();
                }
                //删除旧标签
                Db::table('tag')->where('art_id',$aid)->delete();
                //添加新标签
                Db::table('tag')->insert($tags);

                return array('error' => 1, 'info' => '编辑成功', 'url' => '/art/'.$aid);
            }else{
                return array('error' => 0, 'info' => '编辑失败');
            }
        }

        return $render->render('home/user/addart',
            [
                'tdk' => $tdk,
                'cats' => $this->cats,
                'detail' => $detail,
                'session' => $this->session->get('user')
            ]
        );
    }

    public function login(RenderInterface $render,ResponseInterface $response,RequestInterface $request)
    {
        $tdk = [];
        $tdk['title'] = '登录-技术博客集';
        $tdk['keywords'] = '登录';
        $tdk['description'] = '登录，技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        //已登录
        if ($this->session->has('user')) {
            return $response->redirect('/user/center');
        }

        if ($this->request->isMethod('post')) {
            // 获取通过验证的数据...
            //$validated = $request->validated();
            $validator = $this->validationFactory->make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required|min:6|max:12',
                ]
            );
            if ($validator->fails()){ // Handle exception
                $data = array('error' => 0, 'info' => $validator->errors()->first());
                return $data;
            }

            $email = $this->request->input('email');
            $password = md5($this->request->input('password'));
            $res = Db::table('user')->where('email',$email)->where('password',$password)->first();
            //return $res;
            //状态
            if($res->status != 1){
                return array('error' => 0, 'info' => '账号异常或冻结,如误操作请联系站长说明');
            }

            if($res){
                $data = array('error' => 1, 'info' => '登陆成功');
                //写session
                $this->session->set('user', $res);
                //更新登录时间
                Db::table('user')->where('user_id', $res->user_id)->update(['lastlogin' => time()]);
            }else{
                $data = array('error' => 0, 'info' => 'Email密码错误');
            }
            return $data;
        }

        return $render->render('home/user/login',
            [
                'tdk' => $tdk,
                'cats'=> $this->cats,
                'url' => '/'.$request->path(),
                'session' => $this->session->get('user')
            ]
        );
    }

    public function register(RenderInterface $render,ResponseInterface $response,RequestInterface $request)
    {
        $tdk = [];
        $tdk['title'] = '注册-技术博客集';
        $tdk['keywords'] = '注册';
        $tdk['description'] = '注册，技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        //已登录
        if ($this->session->has('user')) {
            return $response->redirect('/user/center');
        }

        if ($this->request->isMethod('post')) {
            $validator = $this->validationFactory->make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'username' => 'required|min:3|max:12',
                    'password' => 'required|min:6|max:12',
                ]
            );
            if ($validator->fails()){ // Handle exception
                return array('error' => 0, 'info' => $validator->errors()->first());
            }

            $email = $this->request->input('email');
            $username = $this->request->input('username');
            $password = md5($this->request->input('password'));

            //邮箱验证码
            $emailcode = $this->request->input('code');
            $redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
            if (!$redis->exists($email) || $emailcode != $redis->get($email)) {
                return array('error' => 0, 'info' => '验证码错误');
            }


            //验邮箱 不能重复
            $isemail = Db::table('user')->where('email',$email)->exists();
            if($isemail){
                return array('error' => 0, 'info' => '该邮箱已存在');
            }

            $id = Db::table('user')->insertGetId(
                [
                    'group_id' => 1,
                    'username' => $username,
                    'face'     => '/upload/face/mrface.png',
                    'email'    => $email,
                    'password' => $password,
                    'regtime'  => time(),
                    'status'   => 0
                ]
            );
            if($id){
                $data = array('error' => 1, 'info' => '注册成功');

                //写session
                $res = Db::table('user')->where('user_id',$id)->first();
                $this->session->set('user', $res);
            }else{
                $data = array('error' => 0, 'info' => '注册失败');
            }
            return $data;
        }

        return $render->render('home/user/login',
            [
                'tdk' => $tdk,
                'cats'=> $this->cats,
                'url' => '/'.$request->path(),
                'session' => $this->session->get('user')
            ]
        );
    }

    public function logout(ResponseInterface $response)
    {
        $this->session->clear();
        return $response->redirect('/user/login');
    }

    //发邮箱验证
    public function sendemail(RequestInterface $request)
    {
        if ($this->request->isMethod('post')) {
            $validator = $this->validationFactory->make($request->all(), ['email' => 'required|email',]);
            if ($validator->fails()){ // Handle exception
                return array('error' => 0, 'info' => $validator->errors()->first());
            }
            $email = $this->request->input('email');
            //验证码存redis  10分钟
            $redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
            $redis->set($email,random_code() , 600);

            //发邮件
            Mail::to($email)->send(new subscribe($redis->get($email)));
        }else{
            return array('error' => 0, 'info' => '别瞎搞');
        }
    }
    //发邮箱验证
//    public function sendemail(RequestInterface $request,ResponseInterface $response, int $user_id)
//    {
//        $user = User::findOrFail($user_id);
//        //发邮件 houtizong@dingtalk.com
//        Mail::to('514224527@qq.com')->send(new subscribe($user));
//    }

    //订阅
    public function subscribe(RequestInterface $request)
    {
        if ($this->request->isMethod('post')) {
            $data = $request->all();
            if ($data) {
                $res = DB::table('user')->where('user_id', $data['id'])->update(['subscribe' => $data['issub']]);
                if ($res) {
                    //写session
                    $this->session->set('user', Db::table('user')->where('user_id',$data['id'])->first());
                    return array('error' => 1, 'info' => '订阅成功');
                }else {
                    return array('error' => 0, 'info' => '订阅失败');
                }
            }
        }else{
            return array('error' => 0, 'info' => '别瞎搞');
        }
    }

    //推送rabbit
    public function torabbitmsg()
    {
        return '333';
        $user = Db::table('user')->select('user_id','username','email','subscribe')->where('subscribe',1)->get();
        $msg = array('type' => 1, 'rabbit_msg' =>  'rabbit订阅邮件推送', 'rabbit_time' => date("Y-m-d H:i:s", time()));

        foreach($user as $v){
            $msg['data']['user_id'] = $v->user_id;
            $msg['data']['username'] = $v->username;
            $msg['data']['email'] = $v->email;

            //将消息推送给生产者
            $message = new DemoProducer(\GuzzleHttp\json_encode($msg));
            //获取生产者的一个实例
            $producer = ApplicationContext::getContainer()->get(Producer::class);

            //传递消息
            try {
                $producer->produce($message);
            } catch (\Exception $exception) {
                throw new \Swoole\Exception($exception->getMessage());
            }
        }

        return ['msg' => 'rabbit订阅邮件推送', 'time' => date('Y-m-d H:i:s', time()),];
    }

}
