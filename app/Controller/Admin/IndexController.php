<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;


/**
 * @Controller()
 */
class IndexController extends AbstractController
{
    // Hyperf 会自动为此方法生成一个 /user/index 的路由，允许通过 GET 或 POST 方式请求
    /**
     * @RequestMapping(path="/admin/index", methods="get,post")
     */
    public function index(RenderInterface $render,ResponseInterface $response,RequestInterface $request)
    {
        return $render->render('admin/index/index', [123]);
    }


}
