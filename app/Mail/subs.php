<?php
declare(strict_types=1);
namespace App\Mail;

use HyperfExt\Contract\ShouldQueue;
use HyperfExt\Mail\Mailable;

use Hyperf\DbConnection\Db;

class subs extends Mailable implements ShouldQueue
{
    /**
     * 创建一个消息实例。
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $str = '';
        $newart = Db::table('art')->where('is_state',0)->where('is_del',1)->orderBy('pubtime','desc')->take(2)->pluck('title','art_id');
        foreach($newart as $k=>$n) {
            $str .= '<p><a href="https://blog.zongscan.com/art/'.$k.'">'.$n.'</a></p>';
        }

        //邮箱推送文章模板
        $html1 = <<<ht
    <p>Hi，<em style="font-weight: 700;">你好 </em>，本周推送最新两篇文章</p>
    {$str}
ht;

        return $this
            ->subject('ZONGSCAN-本周推送文章')
            ->htmlBody($html1);
    }
}
