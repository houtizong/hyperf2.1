<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

use Hyperf\DbConnection\Db;
use Hyperf\Utils\ApplicationContext;

class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{

    public function onMessage($server, Frame $frame): void
    {
        $data = json_decode($frame->data,true);

        if(isset($data['type']) && $data['type'] == 'ping') {
            $server->push($frame->fd, 'Ping');//心跳
        }elseif (isset($data['type']) && $data['type'] == 'wssl') {

            $redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
            //测试 用哈希存储  打字激活添加在线用户
            $redis->hMSet('wssl',[$frame->fd => $data['uid']]);

            $wssl = $redis->hGetAll('wssl');
            var_dump($wssl);

            foreach ($wssl as $fd => $u) {
                $server->push(intval($fd),json_encode($data));
                echo "线程：$frame->fd 向线程 $fd 发送信息\\n";
            }


        }else{
            //群聊
            $redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
            //获取所有的客户端id
            $fdList = $redis->sMembers('websocket_zongscan');
            //如果当前客户端在客户端集合中,就刷新
            if (in_array($frame->fd, $fdList)) {
                $redis->sAdd('websocket_zongscan', $frame->fd);
                $redis->expire('websocket_zongscan', 3600);
            }
            
            //绑定用户信息
            $user = Db::table('user')->where('user_id',$data['uid'])->first();
            $data['username'] = $user->username;
            $data['face'] = $user->face;

            if(count($fdList)) {
                foreach ($fdList as $k => $v) {
                    $server->push(intval($v),json_encode($data));
                    echo "线程：$frame->fd 向线程 $v 发送信息\\n";
                }
            }
        }
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        //删掉客户端id
        $redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
        //移除集合中指定的value
        $redis->sRem('websocket_zongscan', $fd);

        //测试用哈希存储 退出删除 私聊用户
        $redis->hDel('wssl', $fd);

        var_dump('closed');
    }

    public function onOpen($server, Request $request): void
    {
        //保存客户端id
        $redis = ApplicationContext::getContainer()->get(\Hyperf\Redis\Redis::class);
        $redis->sAdd('websocket_zongscan', $request->fd);
        $redis->expire('websocket_zongscan', 3600);
        $server->push($request->fd, 'Opened');
    }
}