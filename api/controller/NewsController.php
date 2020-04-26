<?php

namespace app\login\controller;

use think\Controller;

class NewsController extends loginController
{
    public function index(){

        //dump($config_redis['host']);
        return view('');
    }
    public function store(){
        $data = input('');
        //登录数据库
        $rules = [
            "title|新闻标题" => "require",
            "script|新闻描述" => "require",
            "author|新闻作者" => "require",
            "body|新闻内容" => "require"
        ];
        $judge = $this->validate($data,$rules);
        if($judge===true){
        $redis = new \Redis();
        $config_redis=config('redis');
        $redis -> connect($config_redis['host'],$config_redis['port'],$config_redis['timeout']);
        $redis -> auth($config_redis['auth']);
        //id自增
        $newsid ='new:id';
        $id = $redis->incr($newsid);
        //hash添加数据
        $newskey = 'new:id:'.$id;
        $data['id'] = $id;
        $redis ->hMSet($newskey,$data);
        //有序排列
        $zkey = 'news:zset:id';
        $redis ->zAdd($zkey,$id,$id);
            return $this->success('新闻添加成功',url("news/list"));
        }else{
            return $this->error('添加失败');
        }
    }
    public function list(){
        $data = [];
        //登录数据库
        $redis = new \Redis();
        $config_redis=config('redis');
        $redis -> connect($config_redis['host'],$config_redis['port'],$config_redis['timeout']);
        $redis -> auth($config_redis['auth']);
        //取出顺序
        $ids=$redis -> zRange('news:zset:id',0,-1);
        //dump($ids);
        //循环输出所有的新闻
        foreach ($ids as $id){
            $newskey = 'new:id:'.$id;
            $item=$redis->hGetAll($newskey);
            $data[] = $item;
        }
        //dump($data);
        return view('',compact('data'));
    }
    public function del($id){
        $id = input('id');
        $redis = redis_connect();
        //删除hash对应的key
        $hkey = 'new:id'.$id;
        $redis ->del($hkey);
        //删除zset对应的元素
        $zkey = 'news:zset:id';
        $redis ->zRem($zkey,$id);

        return ['status' => 200,'msg' => '删除成功'];
    }
    public function update(){
        $id = input('id');
        //dump(input('id'));
        $redis = redis_connect();
        $newskey = 'new:id:'.$id;
        $data=$redis->hGetAll($newskey);
//        dump($data);
        return view('',compact('data'));
    }
    public function edit($id){
        $data =input();
        $rules = [
            "title|新闻标题" => "require",
            "script|新闻描述" => "require",
            "author|新闻作者" => "require",
            "body|新闻内容" => "require"
        ];
        $judge = $this->validate($data,$rules);
        if($judge===true){
            $redis = redis_connect();
            $newskey = 'new:id:'.$id;
            $redis ->hMSet($newskey,$data);
            return $this->success('修改成功',url('news/list'));
        }else{
            return $this->error('修改失败');
        }
    }
    public function deltotal(){
        $redis = redis_connect();
        $id=$redis -> zRange('news:zset:id',0,-1);
        //dump($id);
        foreach ($id as $id){
            $hkey = 'new:id'.$id;
            $redis ->del($hkey);
            //删除zset对应的元素
            $zkey = 'news:zset:id';
            $redis ->zRem($zkey,$id);
        }
        return $this->success('删除成功',url('news/list'));
    }
}
