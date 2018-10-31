<?php

namespace app\admin\controller;

use function PHPSTORM_META\elementType;
use think\Controller;
use think\Db;
use think\Request;

use PHPExcel_IOFactory;
use PHPExcel;

class Game extends Controller
{
	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index ()
	{
		//$id_data = Db::table('game_data')->select();
		//select里要遍历数组，获取遍历的mess_id 和user_id
		//先要从前台获取mess_id、user_id然后跟根据这两个条件来进行查询，并且把赋值到$res中
		//思考前台获取user_id、mess_id的方式,然后连表查询
		//显示比赛数据(局)显示页面
		//先获取需要遍历的数据
		//$mess_id = Db::table('message')->field ('id')->select();
		//在进行连表查询
		$data = Db::table ('message')->alias ('m')
			->field ('m.id,m.game_name,m.game_stage,m.game_project,a.user_name as user_A,b.user_name as user_B')
			->join ('user a', 'm.user_a = a.id')
			->join ('user b', 'm.user_b = b.id')
			->select ();
		$player = Db::table ('user')->select ();
		return view ('gameList', ['mess_id' => $data, 'player' => $player]);
	}

	/**
	 * 显示创建资源表单页.
	 *
	 * @return \think\Response
	 */
	public function create ()
	{
		//显示比赛数据(局)添加页面
		$data = Db::table ('message')->alias ('m')
			->field ('m.id,m.game_name,m.game_stage,m.game_project,a.user_name as user_A,b.user_name as user_B')
			->join ('user a', 'm.user_a = a.id')
			->join ('user b', 'm.user_b = b.id')
			->select ();
		$player = Db::table ('user')->select ();
		//var_dump($data);die();
		return view ('gameCreate', ['mess' => $data, 'player' => $player]);
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
		//先获取提交的表单数据
		$res = $request->post ();
		//var_dump ($res);die();
		$da = Db::table ('game_data')->insert ($res);
		$data = Db::table ('message')->alias ('m')
			->field ('m.id,m.game_name,m.game_stage,m.game_project,a.user_name as user_A,b.user_name as user_B')
			->join ('user a', 'm.user_a = a.id')
			->join ('user b', 'm.user_b = b.id')
			->select ();
		$player = Db::table ('user')->select ();
		//return view ('gameList', ['mess_id' => $data, 'player' => $player]);
		if ($da) {
			echo "<script>alert('添加成功!');</script>";
			return view ('gameList', ['mess_id' => $data, 'player' => $player]);
		} else {
			echo "<script>alert('添加失败!');</script>";
			return view ('gameList', ['mess_id' => $data, 'player' => $player]);
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
		//
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
		//
	}

	/**
	 * 删除指定资源
	 *
	 * @param  int $id
	 *
	 * @return \think\Response
	 */
	public function delete (Request $request, $id)
	{
		//
		$i = $request->get ();
		var_dump ($i);
		die();
		$del = Db::table ('game_data')->where ('id', $id)->delete ();
		if ($del) {
			return $this->success ('删除成功');
		} else {
			return $this->error ('删除失败');
		}
	}

	public function data ()
	{
		$id = $_POST['id'];
		$ret = Db::table ('message')->alias ('m')
			->field ('u_a.id as id1')
			->field ('u_a.user_name as user_a')
			->field ('u_b.id as id2')
			->field ('u_b.user_name as user_b')
			->where ('m.id', $id)
			->leftJoin ('user u_a', 'u_a.id = m.user_a')
			->leftJoin ('user u_b', 'u_b.id = m.user_b')
			->order ('m.' . 'id', 'desc')
			->limit (0, 35)
			->select ();
		//var_dump ($ret);die();
		//return json ($ret);
		return json ($ret[0]);
	}

	public function find (Request $request)
	{

		//var_dump ($request->post ());
		$post = $request->post ();
		$mess = $post['mess_id'];//字符串
		//var_dump ($mess);
		$user = $post['user_id'];//字符串
		//var_dump ($user);
		$res = Db::table ('game_data')->where ([['mess_id', '=', $mess], ['user_id', '=', $user]])
			->select ();
		//var_dump ($res);
		echo json_encode ($res);
	}


	public function adds ()
	{
		$data = Db::table ('message')->alias ('m')
			->field ('m.id,m.game_name,m.game_stage,m.game_project,a.user_name as user_A,b.user_name as user_B')
			->join ('user a', 'm.user_a = a.id')
			->join ('user b', 'm.user_b = b.id')
			->select ();
		$player = Db::table ('user')->select ();
		return view ('gameAdds', ['mess_id' => $data, 'player' => $player]);

	}

	public function download ()
	{

	}

	public function importExcel (Request $request)
	{
		$match = $request->post ('mess_id');
		$player = $request->post ('user_id');
//		var_dump($match);var_dump($player);die();
		if (request ()->isPost ()) {
			$obj_PHPExcel = new \PHPExcel();
			//获取表单上传文件
			$file = request ()->file ('file');
			$info = $file->validate (['ext' => 'xlsx'])->move ('./upload/excel'); //上传验证后缀名,以及上传之后移动的地址  E:\wamp\www\bick\public
			//var_dump ($info);die();
			if ($info) {
				$excelPath = $info->getSaveName ();//获取文件名

				$file_name = './upload/excel/' . $excelPath;//上传文件地址
//				var_dump ($file_name);die();
				$objReader = \PHPExcel_IOFactory::createReader ("Excel2007");
				//var_dump ($objReader);die();
				$obj_PHPExcel = $objReader->load (str_replace ('||', '/', $file_name), $encode = 'utf-8');  //加载文件内容，编码utf-8
				//var_dump ($obj_PHPExcel);die();
				//转换为数组格式
				$excel_array = $obj_PHPExcel->getSheet (0)->toArray ();
				//var_dump ($excel_array);die();
				array_shift ($excel_array);//删除第一个数组（标题）;
				$city = [];
				foreach ($excel_array as $k => $v) {
					$city['class'] = $v[0];
					$city['mess_id'] = $match;
					$city['user_id'] = $player;
					$city['score_first'] = $v[1];
					$city['score_last'] = $v[2];
					$city['send'] = $v[3];
					$city['bat_number'] = $v[4];
					$city['tool'] = $v[5];
					$city['get_lose'] = $v[6];
				}
				$D = Db::table ('game_data')->insert ($city);
				if ($D) {

					return '成功';

				} else {
					return '失败';
				}

			} else {
				echo $file->getError ();
			}
		}
		/**
		 * $data = Db::table ('message')->alias ('m')
		 * ->field ('m.*')
		 * ->field ('a.user_name as user_A')
		 * ->field ('b.user_name as user_B')
		 * ->where ('m.id', $id)
		 * ->join ('user a', 'm.user_a = a.id')
		 * ->join ('user b', 'm.user_b = b.id')
		 * ->select ();
		 * return  $this->fetch ('game/gameAdds',['data' => $data]);
		 */
	}

	public function cha ()
	{
		$data = Db::table ('message')->alias ('m')
			->field ('m.id,m.game_name,m.game_stage,m.game_project,a.user_name as user_A,b.user_name as user_B')
			->join ('user a', 'm.user_a = a.id')
			->join ('user b', 'm.user_b = b.id')
			->select ();
		//var_dump ($data);die();
		return view ('gameScore', ['mess' => $data]);
	}

	public function score ($mess_id)
	{
		$da = Db::table ('count_score')->where ('mess_id', $mess_id)->select ();
		$mess_da = Db::table ('message')
			->alias ('m')
			->field ('m.id,game_date,game_name,game_project,game_stage,a.user_name as user_A ,b.user_name as user_B,show')
			->join ('user a','m.user_a = a.id')
			->join ('user b','m.user_b = b.id')
			->where ('m.id', $mess_id)
			->select ();

		if ($da) {
			//var_dump ($mess_da);die();
			$data = [];
			foreach ($mess_da as $v) {
				$data['id'] = $v['id'];
				$data['game_date'] = $v['game_date'];
				$data['game_name'] = $v['game_name'];
				$data['game_project'] = $v['game_project'];
				$data['game_stage'] = $v['game_stage'];
				$data['user_a'] = $v['user_A'];
				$data['user_b'] = $v['user_B'];
				$data['show'] = $v['show'];
			}
//			foreach ($re as $v){
//				$data['user_a'] = $v['user_A'];
//				$data['user_b'] = $v['user_B'];
//			}
			foreach ($da as $v) {
				$data['big'] = $v['big'];
				$data['small'] = $v['small'];
			}
			echo json_encode ($data);
		} else {
			$ret = Db::table ('game_data')
				->field ('get_lose,class,max(score_first) as a,max(score_last) as b')
				->where ('mess_id', $mess_id)
				->group ('class,get_lose')
				->select ();
			$cla = 0;
			$score_left = 0;
			$score_right = 0;
			$big_left = 0;
			$big_right = 0;
			foreach ($ret as $k => $v) {
				if ($v['a'] > $v['b'] && $v['get_lose'] === '得') {
					$score_left = $v['a'] + 1;
					$score_right = $v['b'];
					$cla = $v['class'];
					//var_dump ($cla);
					$big_left = 1;
				} else {
					$score_left = $v['a'];
					$score_right = $v['b'] + 1;
					//var_dump ($score_right);
					$cla = $v['class'];
					//var_dump ($cla);
					$big_right = 0;
				}

			}
			$d= [];
			$d['class'] = $cla;
			$d['score_right'] = $score_right;
			$d['score_left'] = $score_left;
			$d['big_left'] = $big_left;
			$d['big_right'] = $big_right;
			$d['mess_id'] = $mess_id;
			//var_dump ($d);die();
			Db::table ('score')->insert ($d);

			$res = Db::table ('score')->where ('mess_id', $mess_id)->select ();
			$count = [];
			$small = '';
			$big ='';
			foreach ($res as $k => $v) {
				$small_l = $v['score_left'] ;
				$small_r = $v['score_right'] ;
				$small = $small_l . '-' . $small_r . "&nbsp&nbsp&nbsp";
				$big_l = $v['big_left'];
				$big_r = $v['big_right'];
				$big = $big_l . '-' . $big_r;
			}


			$count['mess_id'] = $mess_id;
			$count['big'] = $big;
			$count['small'] = $small;
			Db::table ('count_score')->insert ($count);
			$da = Db::table ('count_score')->where ('mess_id', $mess_id)->select ();
			$mess_da = Db::table ('message')
				->alias ('m')
				->field ('m.id,game_date,game_name,game_project,game_stage,a.user_name as user_A ,b.user_name as user_B,show')
				->join ('user a','m.user_a = a.id')
				->join ('user b','m.user_b = b.id')
				->where ('m.id', $mess_id)
				->select ();
			$data = [];
			foreach ($mess_da as $v) {
				$data['id'] = $v['id'];
				$data['game_date'] = $v['game_date'];
				$data['game_name'] = $v['game_name'];
				$data['game_project'] = $v['game_project'];
				$data['game_stage'] = $v['game_stage'];
				$data['user_a'] = $v['user_A'];
				$data['user_b'] = $v['user_B'];
				$data['show'] = $v['show'];
			}
			foreach ($da as $v) {
				$data['big'] = $v['big'];
				$data['small'] = $v['small'];
			}
			echo json_encode ($data);
		}
	}


}
