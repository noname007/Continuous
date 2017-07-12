<?php
/**
 * Created by PhpStorm.
 * User: soul11201 <soul11201@gmail.com>
 * Date: 2017/7/12
 * Time: 16:25
 */



class Continuous
{
    // [$start,$end), 且一定是0点
    public $start = '2017-07-12 00:00:00';
    public $end   = '2017-08-13 00:00:00';

    public $range = 24*3600; // 每天

    //[next_start,next_end) ，当前时间落入本区间方累加
    public $count = 0;
    public $next_start = 0;
    public $next_end = 0;

    public function __construct()
    {
        $this->start = strtotime($this->start);
        $this->end = strtotime($this->end);
        $this->count = 0;
    }

    public function calc_count()
    {
        $time = time();
        // 未开始/已结束
        if($time < $this->start || $this->end < $time)
        {
            return -1;
        }

        if($this->next_start > $time && $time < $this->end)
        {
            return $this->count;
        }

        // 连续登陆中间断开重新计数
        if($this->next_end < $time)
        {
            $this->count = 0;
        }


        //重新计数初始化
        if($this->count == 0)
        {
            $this->next_start    = strtotime(date('Y-m-d')." 00:00:00"); //今日凌晨
            $this->next_end  =  $this->next_start + $this->range;
        }

        $this->next_start += $this->range;
        $this->next_end  += $this->range;
        ++ $this->count;

        return $this->count;
    }

}

$obj = new Continuous;
echo $obj->calc_count(),PHP_EOL;
echo $obj->calc_count(),PHP_EOL;
echo $obj->calc_count(),PHP_EOL;
echo $obj->calc_count(),PHP_EOL;
var_dump($obj);