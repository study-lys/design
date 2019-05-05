<?php
/**
 * Created by PhpStorm.
 * User: 13324
 * Date: 2018/11/1
 * Time: 10:33
 */

namespace app\index\controller;


use think\App;
use think\Controller;
use think\db;
use think\Request;

class Attendance extends Controller
{
    protected $request;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->request=new Request();
    }

    public function getAttendanceList(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_ids = $this->request->get("d_ids");
        $posts = $this->request->get("posts");
        $s_name = $this->request->get("s_name");
        $pageSise = $this->request->get("pageSise"); // 每页总量
        $currentPage = $this->request->get("currentPage"); //当前页
        $startSize = ($currentPage - 1) * $pageSise; //起始数据下标
        if (($posts === '' || $posts === null) && ($d_ids === '' || $d_ids === null)){
            $sql1 = "select * from attendance LEFT JOIN staff ON attendance.s_id = staff.s_id
                LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where s_name like '%$s_name%'
                ORDER BY a_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from attendance LEFT JOIN staff ON attendance.s_id = staff.s_id
                LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where s_name like '%$s_name%'
                ORDER BY a_id ASC";
        }else if (($posts === ''||$posts === null) && ($d_ids !== ''&& $d_ids !== null)){
            $sql1 = "select * from attendance LEFT JOIN staff ON attendance.s_id = staff.s_id
                LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where staff.d_id in ($d_ids)
                and s_name like '%$s_name%'
                ORDER BY a_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from attendance LEFT JOIN staff ON attendance.s_id = staff.s_id
                LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where staff.d_id in ($d_ids)
                and s_name like '%$s_name%'
                ORDER BY a_id ASC";
        }else if (($posts !== '' && $posts !== null) && ($d_ids === '' || $d_ids === null)){
            $sql1 = "select * from attendance LEFT JOIN staff ON attendance.s_id = staff.s_id
                LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where p_name  in ($posts)
                and s_name like '%$s_name%'
                ORDER BY a_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from attendance LEFT JOIN staff ON attendance.s_id = staff.s_id
                LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where p_name  in ($posts)
                and s_name like '%$s_name%'
                ORDER BY a_id ASC";
        }else if (($posts !== '' && $posts !== null) && ($d_ids !== ''&& $d_ids !== null)){
            $sql1 = "select * from attendance LEFT JOIN staff ON attendance.s_id = staff.s_id
                LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where staff.d_id in ($d_ids)
                and p_name  in ($posts)
                and s_name like '%$s_name%'
                ORDER BY a_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from attendance LEFT JOIN staff ON attendance.s_id = staff.s_id
                LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where staff.d_id in ($d_ids)
                and p_name  in ($posts)
                and s_name like '%$s_name%'
                ORDER BY a_id ASC";
        }
        $result1=Db::query($sql1);
        $result2=Db::query($sql2);
        $response['success'] = true;
        $response['message'] = '获取考勤列表成功';
        $response['data'] = $result1;
        $response['total'] = count($result2);
        return json($response);
    }

}