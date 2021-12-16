<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;

//use Hyperf\HttpServer\Contract\RequestInterface;
//use Hyperf\HttpServer\Contract\ResponseInterface;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Qbhy\HyperfAuth\Annotation\Auth;
use Qbhy\HyperfAuth\AuthManager;

use App\Model\Admin;

/**
 * @Controller()
 */
class AdminController extends AbstractController
{

    /**
     * @Inject
     * @var AuthManager
     */
    protected $auth;

    /**
     * 用户编辑
     * @Auth("jwt")
     * @GetMapping(path="/admin/useredit")
     */
    public function useredit()
    {
        $data = $this->request->all();
        $user['name'] = $data['name'];
        $user['password'] = $data['password'];
        $user['created_at'] = $data['created_at'];
        $user['updated_at'] = $data['updated_at'];
        $user['status'] = $data['status'];
        $res = Admin::query()->where('id', $data['id'])->update($user);
        return ['data' => $res];
    }

    /**
     * 用户列表
     * @Auth("jwt")
     * @GetMapping(path="/admin/users")
     */
    public function users()
    {
        return Admin::query()->get()->toArray();
    }

    /**
     * @GetMapping(path="/admin/login")
     * @return array
     */
    public function login()
    {
        $data = $this->request->all();
        if(!isset($data) || empty($data['name']) || empty($data['password'])) { return array('code' => 0, 'info' => '错了'); }

        $user = Admin::query()->where('name',$data['name'])->where('password',$data['password'])->first();
        // auth('guard') || auth()->guard('session'); 不设置guard，则使用默认的配置jwt
        $token = auth()->login($user);

        $res = [
            'code'  => 1,
            'token' => $token,
            'date'  => date('Y-m-d H:i:s')
        ];
        return $res;
    }
    /**
     * 使用 Auth 注解可以保证该方法必须通过某个 guard 的授权，支持同时传多个 guard，不传参数使用默认 guard
     * @Auth("jwt")
     * @GetMapping(path="/admin/user")
     * @return string
     */
    public function user()
    {
        $user = auth()->user();
        return $user;
    }

    /**
     * 退出登录，token失效
     * @Auth("jwt")
     * @GetMapping(path="/admin/logout")
     */
    public function logout()
    {
        auth()->logout();
        return 'logout ok';
    }

    /**
     * 刷新token，旧token就会失效
     * @Auth("jwt")
     * @GetMapping(path="/admin/retrieve")
     */
    public function retrieve()
    {
        $token = auth()->refresh();
        return [
            'token' => $token,
            'date' => date('Y-m-d H:i:s')
        ];
    }


}
