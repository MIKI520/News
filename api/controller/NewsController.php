<?php

namespace app\api\controller;

use think\Controller;

class NewsController extends Controller
{
    public function index(){
        $data = [];
        $redis = redis_connect();
        $ids=$redis -> zRange('news:zset:id',0,-1);
        //dump($ids);
        //循环输出所有的新闻
        foreach ($ids as $id){
            $newskey = 'new:id:'.$id;
            $item=$redis->hGetAll($newskey);
            $data[] = $item;
        }
        return api($data);
    }
    public  function detail($id)
    {
        //dump($id);
        $redis = redis_connect();
        $data = $redis->hGetAll('new:id:' . $id);
        return api($data);
    }
}
