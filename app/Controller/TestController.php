<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;

use Hyperf\Utils\ApplicationContext;
use Hyperf\DbConnection\Db;

use Hyperf\Guzzle\ClientFactory;

use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 */
class TestController
{
    /**
     * @var \Hyperf\Guzzle\ClientFactory
     */
    private $clientFactory;
    public function __construct(ClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function index(RenderInterface $render,ResponseInterface $response,RequestInterface $request)
    {
        //return $response->json('测试专用控制器');
        return $response->json([
            "errno"=>0,
            "uid" => 'xxxx' .substr(microtime(),-4).random_int(100000, 999999),
            "data"  => '/upload/image/'
        ]);
    }

    public function test(RenderInterface $render,ResponseInterface $response)
    {
        //计算器测试
//        for ($i=0; $i<10; $i++){
//            //执行可以发现只有前5次是通过的
//            var_dump($this->Calculator("1", "reply", 60, 5));
//            sleep (1);
//        }
        return $response->json('333');

        //采集器测试   end 413869
        for ($i=413880; $i<435436; $i++){
            //3.采集源
            $arr = $this->Crawler('https://www.aidi.net.cn/detail/'.$i.'.html');


            if($arr == 404) {
                continue;
            }

            $data['title'] = $arr['title'];
            $data['content'] = $arr['content'];

            $data['thumb_img'] = $arr['tags'];

            $data['cat_id'] = 2;
            $data['author'] = 'htz';
            $data['user_id'] = 15;
            $data['pubtime'] = time();
            $data['is_state'] = 1;
            //$id = Db::table('art')->insertGetId($data);
            $id = Db::table('acaiji')->insertGetId($data);
            if($id){
                sleep (1);
                echo $response->json('采集成功 ==>'.$arr['title']);
            }
        }

    }

    public function test1(RequestInterface $request,ResponseInterface $response)
    {
        $url = 'https://detail.m.tmall.com/item.htm?id=606067717783&tbpm=1631787515';
        //原生写法
        $client = new \GuzzleHttp\Client();
        //$resp = $client->request('GET', 'https://www.zongscan.com/demo333/178.html',[]);
        $resp = $client->request('GET', $url,[]);
        //获取页面数据
        $content = $resp->getBody()->getContents();
        //通过 preg_replace 函数使页面源码由多行变单行
        $htmlOneLine = preg_replace("/\r|\n|\t/","",$content);

        return $htmlOneLine;

        preg_match("/<div class=\"detail\">(.*)<\/div>/iU",$htmlOneLine,$titleArr);
        $string = $titleArr[0];
        //去掉html标签
        $string = strip_tags($string);
        $string = strtr($string, array("&nbsp" => ''));
        return $string;

        //获取这个标签及里面的内容
//        preg_match("/<div class=\"jumbotron\" style=\"background: #f5f5f5;border: 1px solid #ddd;border-radius: 4px;\">(.*)<\/div>/iU",$htmlOneLine,$titleArr);
//        $string = $titleArr[0];
//        //去掉html标签
//        $string = strip_tags($string);
//        $string = strtr($string, array("&nbsp" => ''));
//
//        return $response->json($string);
        //return 'test-Hyperf';
    }

    public function meilisearch(RequestInterface $request,ResponseInterface $response)
    {
        $client = new \GuzzleHttp\Client();
        //查询
        // curl -X GET 'http://localhost:7700/indexes'
        //$resp = $client->request('GET', 'http://127.0.0.1:7700/indexes');

        $resp = $client->request('GET', 'http://127.0.0.1:7700/indexes/movies/documents/113965');
        $a = $resp->getBody();
        return json_decode((string) $a,true);

        //添加
        //curl -X POST 'http://localhost:7700/indexes' --data '{"uid": "movies1","primaryKey": "movie_id1"}'
//        $body = [
//            "uid" => "movies6",
//            "primaryKey" => "movie_id6"
//        ];
//        $resp = $client->request('POST', 'http://127.0.0.1:7700/indexes',
//            [
//                'headers' => [
//                    'content-type' => 'application/json',
//                    'accept' => 'application/ld+json'
//                ],
//                'body' => json_encode($body),
//            ]
//        );
//        return json_decode((string) $resp->getBody(),true);

        //修改
        //curl -X PUT 'http://127.0.0.1:7700/indexes/movies2' --data '{"name" : "666"}'
        /*$body = [
            "name" => "666"
        ];
        $resp = $client->request('PUT', 'http://127.0.0.1:7700/indexes/movies2',
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'accept' => 'application/ld+json'
                ],
                'body' => json_encode($body),
            ]
        );
        return json_decode((string) $resp->getBody(),true);
        */

        //删除
        //curl -X DELETE 'http://127.0.0.1:7700/indexes/movies1'
        //$resp = $client->delete('http://127.0.0.1:7700/indexes/movies1');

        //return 'test-Hyperf-meilisearch ';
    }
    /**
     * meilisearch搜索引擎  实现文件增删改查
     */
    public function mlsearch()
    {
        $client = new \GuzzleHttp\Client();

        //单查
        //curl -X GET 'http://localhost:7700/indexes/movies/documents/113965'
        //$resp = $client->request('GET', 'http://127.0.0.1:7700/indexes/movies/documents/113965');

        //批查  后面可带limit参数
        //curl -X GET 'http://localhost:7700/indexes/movies/documents?limit=2'
        $resp = $client->request('GET', 'http://127.0.0.1:7700/indexes/movies/documents');
        return json_decode((string) $resp->getBody(),true);

        //单删
        //curl -X DELETE 'http://localhost:7700/indexes/movies/documents/287947'
        //$resp = $client->delete('http://127.0.0.1:7700/indexes/movies/documents/287947');

        //批删
        //curl -X POST 'http://localhost:7700/indexes/movies/documents/delete-batch' --data '[113965,113729,113727,112134,113728]'
        /*$body = [113965,113729,113727,112134,113728];
        $resp = $client->request('POST', 'http://127.0.0.1:7700/indexes/movies/documents/delete-batch',
            [
                'headers' => ['content-type' => 'application/json;charset=UTF-8','accept' => 'application/ld+json'],
                'body' => json_encode($body),
            ]
        );
        */


        //增
        //curl -X POST 'http://localhost:7700/indexes/movies/documents' --data '[{"id":"3","title":"中国"},{"id":"4","title":"ddd"}]'
        /*$a = '[{"id":"3","title":"中国"},{"id":"4","title":"ddd"}]';
        $resp = $client->request('POST', 'http://127.0.0.1:7700/indexes/movies/documents',
            [
                'headers' => ['content-type' => 'application/json;charset=UTF-8','accept' => 'application/ld+json'],
                'body' => $a,
            ]
        );
        */

        //改
        //curl -X PUT 'http://localhost:7700/indexes/movies/documents' --data '[{"id": 3,"title": "中国广州"}]'
        /*$body = '[{"id": 3,"title": "中国广州"}]';
        $resp = $client->request('PUT', 'http://127.0.0.1:7700/indexes/movies/documents',
            [
                'headers' => ['content-type' => 'application/json', 'accept' => 'application/ld+json'],
                'body' => $body,
            ]
        );
        */


        //从数据库数取出据库               content
        $art = DB::table('art')->select(DB::raw('art_id as id'), 'title', 'pubtime', 'view', 'cat_id')
            ->where('is_state', 0)->where('is_del', 1)
            ->orderBy('art_id', 'desc')->limit(5)->get()->toJson();
        //把数据插入
        $resp = $client->request('POST', 'http://127.0.0.1:7700/indexes/movies/documents',
            [
                'headers' => ['content-type' => 'application/json;charset=UTF-8','accept' => 'application/ld+json'],
                'body' => $art,
            ]
        );

        return json_decode((string) $resp->getBody(),true);

        //return $art;
    }
    /**
    * 模拟并发
    */
    public function imitateconcurrency()
    {
        // 模拟并发请求代码
        // $options 等同于 GuzzleHttp\Client 构造函数的 $config 参数
        $options = ['base_uri' => 'https://www.zongscan.com/indextest'];
        // $client 为协程化的 GuzzleHttp\Client 对象
        $client = $this->clientFactory->create($options);

        //$resp = $client->request('GET', $url,[]);
        $promises = [
            'a' => $client->getAsync('?v=1'),
            'b' => $client->getAsync('?v=2'),
            'c' => $client->getAsync('?v=3'),
            'd' => $client->getAsync('?v=4')
        ];
        //异步运行
        $results = \GuzzleHttp\Promise\unwrap($promises);

        echo $results['a']->getBody()->getContents();
        echo "\n";
        echo $results['b']->getBody()->getContents();
        echo "\n";
        echo $results['c']->getBody()->getContents();
        echo "\n";
        echo $results['d']->getBody()->getContents();
        echo "\n";

        var_dump($results);

        return 123;
    }
    /**
     * redis watch实现秒杀抢购效果
     */
    public function rushtobuy()
    {
        return 123;
        $redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);

        $wkeys = $redis->get("wkeys");
        //抢购数量
        $total = 10;

        if($wkeys < $total) {
            $redis->watch("wkeys");
            //设置延迟，方便测试效果。
            $redis->multi();
            //插入抢购数据
            sleep(2);

            $redis->hSet("wlist","user_id_".mt_rand(1, 9999),time());
            $redis->set("wkeys",$wkeys + 1);

            $res = $redis->exec();

            if($res){
                $wlist = $redis->hGetAll("wlist");
                echo "抢购成功！<br/>剩余数量：".($total - $wkeys - 1)."<br/>";
                echo "用户列表：<pre>";
                var_dump($wlist);
            }else{
                echo "手气不好，再抢购！";
                exit;
            }
        }

    }

    /**
    * 我的爬虫
    */
    protected function Crawler($url)
    {
        // $options 等同于 GuzzleHttp\Client 构造函数的 $config 参数
        $options = [];
        // $client 为协程化的 GuzzleHttp\Client 对象
        $client = $this->clientFactory->create($options);
        $resp = $client->request('GET', $url,[]);
        //响应状态码
        //$http_status = $resp->getStatusCode();
        //获取页面数据
        $content = $resp->getBody()->getContents();

        //通过 preg_replace 函数使页面源码由多行变单行
        $htmlOneLine = preg_replace("/\r|\n|\t/","",$content);

        //404 www.aidi.net.cn
        preg_match("/<title>(.*)<\/title>/iU",$htmlOneLine,$title);
        if($title[1] == '404 Not Found'){
            return '404';
        }

        preg_match("/<h1 class=\"title\">(.*)<\/h1>/iU",$htmlOneLine,$titleArr);
        preg_match("/<div class=\"article_content\">(.*)<\/div>/iU",$htmlOneLine,$contentArr);

        preg_match("/<p class=\"info\">(.*)<\/p>/iU",$htmlOneLine,$tagArr);
        $arr['tags'] = trim(strip_tags($tagArr[0]));;

        $arr['title'] = trim(strip_tags($titleArr[0]));
        $arr['content'] = $contentArr[0];


        /*solidot
        preg_match("/<div class=\"bg_htit\">(.*)<\/div>/iU",$htmlOneLine,$titleArr);
        preg_match("/<div class=\"p_mainnew\">(.*)<\/div>/iU",$htmlOneLine,$contentArr);
        //处理成数组
        $arr['title'] = trim(strip_tags($titleArr[0]));
        $arr['content'] = $contentArr[0];
        */

        //it610采集源
        /*
        if($content == "404 找不到页面"){
            return '404';
        }
        //通过 preg_replace 函数使页面源码由多行变单行
        $htmlOneLine = preg_replace("/\r|\n|\t/","",$content);

        //获取这个标签及里面的标题/标签/内容
        preg_match("/<h1 id=\"articleTitle\">(.*)<\/h1>/iU",$htmlOneLine,$titleArr);
        preg_match("/<ul class=\"taglist--inline inline-block article__title--tag\">(.*)<\/ul>/iU",$htmlOneLine,$tagsArr);
        preg_match("/<div id=\"article_content\" class=\"article_content\">(.*)<\/div>/iU",$htmlOneLine,$contentArr);

        //处理成数组
        $arr['title'] = strip_tags($titleArr[0]);
        //去除空白
        $arr['tags'] = preg_replace('/\s/', '', strip_tags($tagsArr[0]));
        $arr['content'] = $contentArr[0];
        //去掉最外围这个多余的标签
        $arr['content'] = strtr($arr['content'],array('<div id="article_content" class="article_content">' => ''));
        */

        return $arr;
    }

    /**计数器限流算法
     * @param $uid
     * @param $action
     * @param $second
     * @param $num
     */
    public function Calculator($uid,$action,$second,$num)
    {
        $redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
        $key = sprintf('hist:%s:%s', $uid, $action);

        //当前的毫秒时间戳
        list($msec, $sec) = explode(' ', microtime());
        $now = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);

        //使用管道提升性能
        $pipe = $redis->multi(\Redis::PIPELINE);
        //value 和 score 都使用毫秒时间戳
        $pipe->zAdd($key, $now, $now);
        //移除时间窗口之前的行为记录，剩下的都是时间窗口内的
        $pipe->zRemRangeByScore($key, '0',(string)($now - $second * 1000));
        //获取窗口内的行为数量
        $pipe->zCard($key);
        //多加一秒过期时间
        $pipe->expire($key, $second  + 1);

        $replies = $pipe->exec();

        return $replies[2] <= $num;
    }

}
