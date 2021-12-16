<?php

declare(strict_types=1);

//自定义函数
if(! function_exists("zdy_test") ){
    /**
     *test
     */
    function zdy_test(){
        return 'test';
    }
}

if(! function_exists("random_code") ){
    /**
     *生成随机字符串
     */
    function random_code(int $num = 5){
        $str="qwertyuiopasdfghjklzxcvbnmQWERTYUOPASDFGHJKZXCVBNM123456789";
        $string = substr(str_shuffle($str), 0,$num) ;
        return $string;
    }
}

if(! function_exists("format_date") ){
    /**
     *根据时间戳计算与当前时间的间距及格式化单位
     */
    function format_date($time){
        $t = time() - $time;
        $f = array('31536000'=>'年', '2592000'=>'个月', '604800'=>'星期', '86400'=>'天', '3600'=>'小时', '60'=>'分钟', '1'=>'秒');
        foreach ($f as $k=>$v)    {
            if (0 !=$c=floor($t/(int)$k)) {
                return $c.$v.'前';
            }
        }
    }
}
