<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Financial extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
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
    public function delete($id)
    {
        //
    }
    public function upload()
    {
        $info = $_POST["myContent"];
        print_r($info);
        $callback = $this->G('callback');
        $info = $this->getLib('QiNiu')->upImage('upfile', 'umeditor');
        $r = array(
             "originalName" => $info['file_name'],
             "name" => $info['qiniu_name'],
             "url" => $info['qiniu_url'],//不能少
             "size" => $info['size'],
             "type" => $info['extension'],
             "state" => 'SUCCESS' //不能少
         );
        if($callback) {
            echo '<script>'.$callback.'('.json_encode($r).')</script>';
           } else {
            echo json_encode($r);
        }
    }
}
