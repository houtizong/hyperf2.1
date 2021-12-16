<?php
/**
 * Created by PhpStorm.
 * User: houtizong
 * Date: 2021\4\23 0023
 * Time: 17:43
 */

use Hyperf\Crontab\Crontab;

return [
    // 是否开启定时任务
    'enable' => false, //true

    //通过配置文件定义定时任务
    'crontab' => [
        //Callback类型定时任务(默认)
        (new Crontab())->setName('Foo')->setRule('* * * × ×')->setCallback([App\Task\FooTask::class,'execute'])->setMemo('这是一个示例的定时任务'),

    ],

];