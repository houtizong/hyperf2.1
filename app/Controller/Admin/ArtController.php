<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Qbhy\HyperfAuth\Annotation\Auth;
use Qbhy\HyperfAuth\AuthManager;

use App\Model\Art;
use Hyperf\DbConnection\Db;


/**
 * @Controller()
 */
class ArtController extends AbstractController
{
    /**
     * @Inject
     * @var AuthManager
     */
    protected $auth;

    /**
     * @Auth("jwt")
     * @RequestMapping(path="/admin/arts", methods="get,post")
     * @return array
     */
    public function arts()
    {
        $art = Art::select('art_id','title','pubtime', 'view', 'cat_id','is_state')
            ->where('is_del', 1)->orderBy('art_id', 'desc')
            ->take(100)->get()->toArray();
        return ['total' => 100 ,'data' => $art];
    }

    /**
     * @Auth("jwt")
     * @RequestMapping(path="/admin/artedit", methods="get,post")
     * @return array
     */
    public function artedit()
    {
        $data = $this->request->all();
        $res = Db::table('art')->where('art_id', $data['art_id'])->update(['is_state' => $data['is_state']]);
        return ['data' => $res];
    }

}
