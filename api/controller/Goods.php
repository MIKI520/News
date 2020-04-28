<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Goods as good;

class Goods extends Controller
{
    public function __construct()
    {
        parent::__construct();         
        header('Access-Control-Allow-Origin:*'); 
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $keyname = input('get.keyname');
        $where = [];
        if($keyname){
            $where['goods_name'] = ["like","%$keyname%"];
        }
        $data = good::where($where) -> select();
        $respanse = [
            'code' => 200,
            'msg' => 'success',
            'body' => $data
        ];
        return json($respanse);//会以application/json
    }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id = 0)
    {
        // 判断参数
        if(!preg_match('/^\d+$/',$id) || $id == 0){
            $response = ['code' => 100,'msg' => '参数错误！','data' => ''];
        }else{
            // 删除操作
            $result = good::destroy($id);
            if($result){
                $response = ['code' => 200,'msg' => '删除成功！','data' => ''];
            }else{
                $response = ['code' => 000,'msg' => '删除失败！','data' => ''];
            }
        }
        // 输出数据
        return json($response);
    }
    public function ipv4(){
        $param = [
            'query' => '39.97.162.104',
            'format' => 'json',
        ];
        $api = 'https://api.i-lynn.cn/ip';
        $data = curl_request($api,'post',$param);
        if(is_array($data)&&$data['code'] == 1000){
            echo "错误";
        }else{
            dump($data);
        }
    }
    public function plane(){
        $param = [
            'keyword' => '上海',
            'format' => 'json',
        ];
        $api = 'https://api.i-lynn.cn/iata';
        $data = curl_request($api,'post',$param);
        if(is_array($data)&&$data['code'] == 1000){
            echo "错误";
        }else{
            // dump($data);
            header('Content-type:application/json');
            return json(json_decode($data));
        }
    }
}
