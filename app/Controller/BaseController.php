<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class BaseController extends AbstractController
{

    /**
     * @Inject()
     * @var \Hyperf\Contract\SessionInterface
     */
    protected $session;

    //分类
    public $cats;

    public function __construct()
    {
        $cats = DB::table('cat')->join('art', 'art.cat_id', '=', 'cat.cat_id')
            ->select('cat.cat_id','cat.catname')
            ->groupBy('art.cat_id')->orderBy('cat.num')->get();
        $this->cats = array_column(\GuzzleHttp\json_decode(\GuzzleHttp\json_encode($cats),true),null,'cat_id');
    }

    /**
     * 获取客户端ip地址
     * @return ip
     */
    public function ip(){
        $res = $this->request->getServerParams();
        if(isset($res['http_client_ip'])){
            return $res['http_client_ip'];
        }elseif(isset($res['http_x_real_ip'])){
            return $res['http_x_real_ip'];
        }elseif(isset($res['http_x_forwarded_for'])){
            //部分CDN会获取多层代理IP，所以转成数组取第一个值
            $arr = explode(',',$res['http_x_forwarded_for']);
            return $arr[0];
        }else{
            return $res['remote_addr'];
        }
    }

    /**
     * 无极限分类 ：一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     * @return Collection
     */
    public function arrtree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) {
            $map[$item[$id]] = $item;
        }

        foreach ($list as $item) {
            if (isset($item[$pid]) && isset($map[$item[$pid]])) {
                $map[$item[$pid]][$son][] = &$map[$item[$id]];
            } else {
                $tree[] = &$map[$item[$id]];
            }
        }
        unset($map);
        return $tree;
    }


}
