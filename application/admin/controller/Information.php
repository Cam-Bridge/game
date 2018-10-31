<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Information extends Controller
{
	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index ()
	{
		//显示赛事信息页面
		//查询数据
		//$res = Db::table ('message')->select ();
		//var_dump ($res);die();
		$data = Db::table ('message')->alias ('m')
			->field ('m.*,a.user_name as user_A,b.user_name as user_B')
			->join ('user a', 'm.user_a = a.id')
			->join ('user b', 'm.user_b = b.id')
			->select ();
		//模板赋值
		//$this->assign ('data', $data);
		//模板渲染
		//return $this->fetch ();
		//使用DB类查询数据
		//$res = Db::name ('message')->select ();
		//数据返回视图
		return view ('informationList', ['res' => $data]);
	}

	/**
	 * 显示创建资源表单页.
	 *
	 * @return \think\Response
	 */
	public function create ()
	{
		//显示添加赛事信息页面

		return view ('informationCreate');//=>是给数组赋值，把$res的查询到的值赋值给了数组，然后数组通过name的res来查询到$res
	}

	/**
	 * 保存新建的资源
	 *
	 * @param  \think\Request $request
	 *
	 * @return \think\Response
	 */
	public function save (Request $request)
	{
		//获取提交的添加赛事信息的数据
		$res = $request->post ();
		$user_a = Db::table ('user')->field ('id')->where ('user_name',$res['user_a'])->select ();
		$user_b = Db::table ('user')->field ('id')->where ('user_name',$res['user_b'])->select ();
		//var_dump($user_a);
		$a = $user_a[0];
		$b = $user_b[0];
		$new_a= implode('',$a);
		$new_b= implode('',$b);
		$res['user_a'] = $new_a;
		$res['user_b'] = $new_b;
		//var_dump ($res);die();
		$game = Db::table ('message')->insert ($res);
		$data = Db::table ('message')->alias ('m')
			->field ('m.*,a.user_name as user_A,b.user_name as user_B')
			->join ('user a', 'm.user_a = a.id')
			->join ('user b', 'm.user_b = b.id')
			->select ();
		//var_dump($game);die();
		if ($game) {
			echo "<script>alert('信息提交成功！')</script>";
			//var_dump ($data);die();
			return view ('informationList', ['res' => $data]);
		} else {
			//echo "<script>alert('信息提交失败！')</script>";
			return view ('informationList', ['res' => $data]);
		}
	}

	/**
	 * 显示指定的资源
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function read ($id)
	{
		//
	}

	/**
	 * 显示编辑资源表单页.
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function edit ($id)
	{
		//获取提交的id，根据id查询数据
		$game = Db::table ('message')->where ('id', $id)->find ();
		return view ('informationUpdate', ['res' => $game]);
	}

	/**
	 * 保存更新的资源
	 *
	 * @param  \think\Request $request
	 * @param  int            $id
	 *
	 * @return \think\Response
	 */
	public function update (Request $request, $id)
	{
		//检查传递过来的ID
		// print $id;die();
		//保存更新的数据
		$game = $request->post ();
		//插入数据
		$data = Db::table ('message')->where ('id', $id)->update ($game);
		if ($data) {
			echo "<script>alert('信息修改成功!')</script>";
			$data = Db::table ('message')->alias ('m')
				->field ('m.*,a.user_name as user_A,b.user_name as user_B')
				->join ('user a', 'm.user_a = a.id')
				->join ('user b', 'm.user_b = b.id')
				->select ();
			//$res = Db::table ('message')->select ();
			return view ('informationList', ['res' => $data]);
		} else {
			echo "<script>alert('信息修改失败!')</script>";
			$data = Db::table ('message')->alias ('m')
				->field ('m.*,a.user_name as user_A,b.user_name as user_B')
				->join ('user a', 'm.user_a = a.id')
				->join ('user b', 'm.user_b = b.id')
				->select ();
			//$res = Db::table ('message')->select ();
			return view ('informationList', ['res' => $data]);
		}
	}

	/**
	 * 删除指定资源
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function delete ($id)
	{
		//删除赛事信息
		//先获取$id,看看id传过来了吗
		//print $id;
		$create = Db::table ('message')->where ('id', $id)->delete ();
		if ($create) {
			//重新查询数据
			return $this->success ('删除成功');
		} else {
			return $this->error ('删除失败');
		}
	}
}
