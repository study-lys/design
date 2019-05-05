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

class Department extends Controller
{
    protected $request;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->request=new Request();
    }

    public function add(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_name = $this->request->post("d_name");
        $d_details = $this->request->post("d_details");
        $result1=Db::query("select * from department where d_name= '$d_name'");
        if ($result1 !== []){
            $response['success'] = false;
            $response['message'] = '部门已存在';
        }else{
            $data = ['d_name' => $d_name, 'd_details' => $d_details];
            $result2 = Db::table('department')->insert($data);
            if ($result2){
                $response['success'] = true;
                $response['message'] = '部门添加成功';
            }else{
                $response['success'] = false;
                $response['message'] = '部门添加失败';
            }
        }
        return json($response);
    }

    public function getList(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_name = $this->request->get("d_name");
        $pageSise = $this->request->get("pageSise"); // 每页总量
        $currentPage = $this->request->get("currentPage"); //当前页
        $startSize = ($currentPage - 1) * $pageSise; //起始数据下标
        $sql = "SELECT department.d_id as id,d_name,s_name,s_email,d_details,staff.s_id FROM department LEFT JOIN staff ON department.s_id = staff.s_id
                where d_name like '%$d_name%'
                ORDER BY department.d_id ASC
                limit $startSize,$pageSise";
        $sql1 = "SELECT * FROM department LEFT JOIN staff ON department.s_id = staff.s_id
                where d_name like '%$d_name%'
                ORDER BY department.d_id ASC";

        $result1=Db::query($sql);
        $result2=Db::query($sql1);
        $response['success'] = true;
        $response['message'] = '获取部门列表成功';
        $response['data'] = $result1;
        $response['total'] = count($result2);
        return json($response);
    }

    public function edit(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $get=true;
        $d_id = $this->request->get("d_id");
        if ($d_id === ''){
            $response['message'] = '部门ID必须';
            $get = false;
        }
        $d_name = $this->request->get("d_name");
        if ($d_name === ''){
            $response['message'] = '部门名必须';
            $get = false;
        }
        if ($get === false){
            $response['success'] = false;
            return json($response);
        }
        $s_id = $this->request->get("s_id");
        $d_details = $this->request->get("d_details");
        $result1=Db::query("select * from department where d_name= '$d_name'");
        if (count($result1)>2){
            $response['success'] = false;
            $response['message'] = '部门已存在';
        }else{
            $data = ['d_name' => $d_name, 'd_details' => $d_details, 's_id' => $s_id];
            $result2 = Db::table('department')-> where('d_id', $d_id) ->update($data);
            if ($result2!==false){
                $response['success'] = true;
                $response['message'] = '部门修改成功';
            }else{
                $response['success'] = false;
                $response['message'] = '部门修改失败';
            }
        }
        return json($response);
    }

    public function delete(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_id = $this->request->get("d_id");
        $sql = "SELECT * FROM staff where d_id=$d_id";
        $result1=Db::query($sql);
        if (count($result1)>0){
            $response['success'] = false;
            $response['message'] = '该部门拥有员工,请进行处理';
        }else{
            $result=Db::table('department')->where('d_id',$d_id)->delete();
            if ($result){
                $response['success'] = true;
                $response['message'] = '部门删除成功';
            }else{
                $response['success'] = false;
                $response['message'] = '部门删除失败';
            };
        }

        return json($response);
    }

    public function batchDelete(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_id = $this->request->get("selection");
        $sql = "select * from staff where d_id in ($d_id)";
        $result1=Db::query($sql);
        if (count($result1)>0){
            $response['success'] = false;
            $response['message'] = '部门内存在员工,请进行处理';
        }else{
            $result=Db::table('department')->delete(($d_id));
            if ($result){
                $response['success'] = true;
                $response['message'] = '批量删除部门成功';
            }else{
                $response['success'] = false;
                $response['message'] = '批量删除部门失败';
            };
        }
        return json($response);
    }

    public function getStaff(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_id = $this->request->get("id");
        $sql = "select * from staff where d_id = $d_id";
        $result=Db::query($sql);
        $response['success'] = true;
        $response['message'] = '获取员工列表成功';
        $response['data'] = $result;
        return json($response);
    }
}