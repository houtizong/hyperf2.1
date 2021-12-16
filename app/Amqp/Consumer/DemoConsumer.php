<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use PhpAmqpLib\Message\AMQPMessage;

use App\Mail\subs;
use HyperfExt\Mail\Mail;

/**
 * @Consumer(exchange="hyperf", routingKey="hyperf", queue="hyperf", name ="DemoConsumer", nums=1)
 */
class DemoConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): string
    {
        var_dump('消费者正在消费数据:' . $data);

        $msg = \GuzzleHttp\json_decode($data,true);
        switch ($msg['type']) {
            case 1 :
                //echo $msg['type'];
                //发邮件
                Mail::to($msg['data']['email'])->send(new subs());
                break;
            case 2 :
                break;
            default:
                echo 666;
        }

        return Result::ACK;
    }
}
