<?php
namespace app\login\controller;
use think\Controller;
class IndexController extends Controller
{
    public function index()
    {
        return view('');
    }
    public function login()
    {
        //表单数据
        $data = input();
        $username = $data['username'];
        $password = $data['password'];
        //读取redis的数据
        $config_redis=config('redis');
        //dump($config_redis['host']);
        //查询数据库
        $loginkey = 'user:'.$username;
        $redis = new \Redis();
        $redis -> connect($config_redis['host'],$config_redis['port'],$config_redis['timeout']);
        $redis -> auth($config_redis['auth']);
        if(!$redis->exists($loginkey)){
            return $this->error('登录失败');
        }
        $pwd = $redis->get($loginkey);
        if($pwd==$password){
            session('admin.user',$username);
            return $this->success('登录成功',url('news/list'));
        }else{
            return $this->error('登录失败');
        }
    }
}
