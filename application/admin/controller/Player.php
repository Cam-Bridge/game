<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;


use think\Model;
use app\admin\model\User;
use think\Db;


class Player extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */

    public function index()
    {
        //使用DB类查询数据
        $res = Db::name('user')->select();
        //数据返回视图
        return view('playerList', ['res' => $res]);

    }


    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //添加运动员
        return view('playerAdd');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        /**
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        var_dump($file);die();
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move('../uploads');
        if ($info) {
        // 成功上传后 获取上传信息
        // 输出 jpg
            echo $info->getExtension();
        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
        // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename();
        } else {
        // 上传失败获取错误信息
            echo $file->getError();
        }

        die();
         */
        //获取数据
        $ath = $request->post();
        $player = User::create($ath);
        if ($player->id) {
            $res = Db::table('user')->select();
            return view('player/playerList', ['res' => $res]);
        } else {
            echo "<script>alert('信息提交失败！')</script>";
        }
        /**
         * //后台获取上传的图片
         * $file = request()->file('image');//获取上传图片
         * // 移动到框架应用根目录/public/uploads/ 目录下
         * if ($file) {
         * $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
         * if ($info) {
         * $img = $info->getSaveName();//获取名称
         * $imgpath = DS.'uploads'.DS.$img;
         * $path = str_replace(DS,"/",$imgpath);//数据库存储路径
         * } else {
         * $status = 0;
         * $message = '图片上传失败';
         * }
         * }else{
         * $status = 0;
         * $message = '图片上传失败';
         * return ['status' => $status, 'message' => $message];
         * }
         */

    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //print $id;
        //die();
        //查询一条数据
        $ath = Db::table('user')->where('id', $id)->find();
        // var_dump($ath);die();
        return view('player/playerUpdate', ['res' => $ath]);


    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        // print $id;die();
        //保存更新的数据
        $ath = $request->post();
        //var_dump($ath);die();
        $player = Db::table('user')->where('id', $id)->update($ath);
        //var_dump($player);die();
        if ($player) {
            echo "<script>alert('信息修改成功！')</script>";
            $res = Db::table('user')->select();
            return view('playerList', ['res' => $res]);

        } else {
            echo "<script>alert('信息修改失败!')</script>";
            $res = Db::table('user')->select();
            return view('playerList', ['res' => $res]);
        }

    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete(Request $request, $id)
    {
        //删除数据
        //print $id;
        //die();
        $res = Db::table('user')->where('id', $id)->delete();
        if ($res) {
            return $this->success('删除成功');
            //return view('playerList');
        } else {
            return $this->error('删除失败');
        }
    }
}
