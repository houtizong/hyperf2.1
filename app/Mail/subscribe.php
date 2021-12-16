<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/mail.
 *
 * @link     https://github.com/hyperf-ext/mail
 * @contact  eric@zhu.email
 * @license  https://github.com/hyperf-ext/mail/blob/master/LICENSE
 */
namespace App\Mail;

use HyperfExt\Contract\ShouldQueue;
use HyperfExt\Mail\Mailable;

use App\Model\User;

class subscribe extends Mailable implements ShouldQueue
{
    /**
     * 用户实例。
     *
     * @var User
     */
    public $user;

    //验证码
    public $emailcode;

    /**
     * 创建一个消息实例。
     *
     * @param  \App\Model\User  $user
     * @return void
     */
    public function __construct($emailcode)
    {
        //
        //$this->user = $user;
        $this->emailcode = $emailcode;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        //邮箱激活模板
//        $html1 = <<<ht
//    <p>Hi，<em style="font-weight: 700;">你好 {$this->user->username}</em>，请点击下面的链接激活你的账号</p>
//    <a href="https://blog.zongscan.com?activate={$this->user->user_id}">立即激活</a>
//ht;
        //邮箱激活模板1
        $html1 = <<<ht
    <p>Hi，<em style="font-weight: 700;">你好 站长提醒你</em>，该验证码有效期为10分钟</p>
    <p>验证码：{$this->emailcode}</p>
ht;

        return $this
            ->subject('ZONGSCAN-账号注册激活链接')
            ->htmlBody($html1);
    }
}
