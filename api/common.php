<?php
function redis_connect(){
    //登录数据库
    $redis = new \Redis();
    $config_redis=config('redis');
    $redis -> connect($config_redis['host'],$config_redis['port'],$config_redis['timeout']);
    $redis -> auth($config_redis['auth']);
    return $redis;
}