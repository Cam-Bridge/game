<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Banner extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return view('index');
    }

	public function banner()
	{
		//
		return view('banner');
	}

	public function bannerAdd()
	{
		return view('banner-add');
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
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        //需要判断banner要放到哪里去，写入相应的文件夹下。
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            //成功上传后 获取上传信息
            //输出 jpg
            //echo $info->getExtension();
            //输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getSaveName();
            //输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename();
            //echo $info->pathName;
            //获取图片的存放相对路径
            $filePath = 'public' . DS . 'uploads'.$info->getSaveName();
            $getInfo = $info->getInfo();
            //获取图片的原名称
            $name = $getInfo['name'];
            //整理数据,写入数据库
            $data = [
                'ban_name' => $name,
                'ban_path' => $filePath
            ];
            $affected = Db::name('banner')->insert($data);
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }


}
