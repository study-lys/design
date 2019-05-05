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

//class User extends Controller
//{
//    protected $request;
//    public function __construct(App $app = null)
//    {
//        parent::__construct($app);
//        $this->request=new Request();
//    }
//
//    public function login(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $u_account = $this->request->post("u_account");
//        $u_password = $this->request->post("u_password");
//        if ($u_account === '' || $u_password === ''){
//            $response['success'] = false;
//            $response['message'] = '账号、密码不能为空';
//            return json($response);
//        }
//        $result1=Db::query("select * from user where u_account= '$u_account'");
//        if ($result1 == []){
//            $response['success'] = false;
//            $response['message'] = '账号不存在';
//        }else{
//            if ($u_password == ($result1[0])['u_password']){
//                $response['success'] = true;
//                $response['message'] = '登录成功';
//                $response['data'] = $result1;
//            }else{
//                $response['success'] = false;
//                $response['message'] = '账号或密码错误';
//            }
//        }
//        return json($response);
//
//    }
//
//    public function getUserDetails(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $u_id = $this->request->get("u_id");
//        $result1=Db::query("select * from user where u_id= '$u_id'");
//        if ($result1){
//            $response['success'] = true;
//            $response['message'] = '获取用户详情成功';
//            $response['data'] = $result1;
//        }else{
//            $response['success'] = false;
//            $response['message'] = '获取用户失败';
//        }
//        return json($response);
//    }
//
//    public function getUserList(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $u_type = $this->request->get("u_type");
//        $u_account = $this->request->get("u_account");
//        $u_name = $this->request->get("u_name");
//        $pageSise = $this->request->get("pageSise"); // 每页总量
//        $currentPage = $this->request->get("currentPage"); //当前页
//        $startSize = ($currentPage - 1) * $pageSise; //起始数据下标
//
//        if ($u_type !== ''){
//            $sql1 = "select * from user
//                where u_type = '$u_type'
//                and u_name like '%$u_name%'
//                and u_account like '%$u_account%'
//                ORDER BY u_id ASC
//                limit $startSize,$pageSise
//                ";
//            $sql2 = "select * from user
//                where u_type = '$u_type'
//                and u_name like '%$u_name%'
//                and u_account like '%$u_account%'";
//        }else{
//            $sql1 = "select * from user
//                where u_name like '%$u_name%'
//                and u_account like '%$u_account%'
//                ORDER BY u_id ASC
//                limit $startSize,$pageSise";
//            $sql2 = "select * from user
//                where u_name like '%$u_name%'
//                and u_account like '%$u_account%'";
//        }
//        $result1=Db::query($sql1);
//        $result2=Db::query($sql2);
//        $response['success'] = true;
//        $response['message'] = '获取用户列表成功';
//        $response['data'] = $result1;
//        $response['total'] = count($result2);
//        return json($response);
//    }
//
//    public function edit(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $u_id = $this->request->post("u_id");
//        $u_name = $this->request->post("u_name");
//        $u_oldPWD = $this->request->post("u_oldPWD");
//        $u_newPWD = $this->request->post("u_newPWD");
//        $u_type = $this->request->post("u_type");
//        $u_sex = $this->request->post("u_sex");
//        $u_phone = $this->request->post("u_phone");
//        $u_email = $this->request->post("u_email");
//        if ($u_oldPWD === '' || $u_oldPWD === null){
//            $data = ['u_name' => $u_name, 'u_type' => $u_type, 'u_sex' => $u_sex,'u_phone' => $u_phone,'u_email' => $u_email];
//        }else{
//            $result1=Db::query("select * from user where u_id= '$u_id'");
//            if (($result1[0])['u_password'] === $u_oldPWD){
//                $data = ['u_name' => $u_name, 'u_password' => $u_newPWD, 'u_type' => $u_type, 'u_sex' => $u_sex,'u_phone' => $u_phone,'u_email' => $u_email];
//            }else{
//                $response['success'] = false;
//                $response['message'] = '密码错误';
//                return json($response);
//            }
//        }
//        $result = Db::table('user')->where('u_id', $u_id)->update($data);;
//        if ($result!==false){
//            $response['success'] = true;
//            $response['message'] = '用户修改成功';
//        }else{
//            $response['success'] = false;
//            $response['message'] = '用户修改失败';
//        }
//        return json($response);
//    }
//
//    public function add(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $u_name = $this->request->post("u_name");
//        $u_account = $this->request->post("u_account");
//        $u_password = $this->request->post("u_password");
//        $u_type = $this->request->post("u_type");
//        $u_sex = $this->request->post("u_sex");
//        $u_phone = $this->request->post("u_phone");
//        $u_email = $this->request->post("u_email");
//        $result1=Db::query("select * from user where u_account= '$u_account'");
////        return json($result1);
//        if ($result1 !== []){
//            $response['success'] = false;
//            $response['message'] = '该账号已被占用';
//        }else{
//            $data = ['u_name' => $u_name,'u_account' => $u_account, 'u_password' => $u_password, 'u_type' => $u_type, 'u_sex' => $u_sex,'u_phone' => $u_phone,'u_email' => $u_email];
//            $result2 = Db::table('user')->insert($data);
//            if ($result2){
//                $response['success'] = true;
//                $response['message'] = '用户添加成功';
//            }else{
//                $response['success'] = false;
//                $response['message'] = '用户添加失败';
//            }
//        }
//        return json($response);
//    }
//
//    public function delete(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $u_id = $this->request->get("u_id");
//        $result=Db::table('user')->where('u_id',$u_id)->delete();
//        if ($result){
//            $response['success'] = true;
//            $response['message'] = '用户删除成功';
//        }else{
//            $response['success'] = false;
//            $response['message'] = '用户删除失败';
//        };
//        return json($response);
//    }
//
//    public function uploadHeader(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        //拿到修改头像的用户ID
//        $u_id = $this->request->get("u_id");
//        $file = request()->file('file');
//        if($file){
//            $info = $file->move('upload/');
//            if($info){
//                $img = $info->getSaveName();
//                $result = Db::table('user')->where('u_id',$u_id)->setField('u_img', 'upload/'.$img);
//                if ($result!==false){
//                    $response['success'] = true;
//                    $response['message'] = '头像修改成功';
//                    $response['data'] = [
//                        "headerUrl" => 'upload/'.$img
//                    ];
//                }else{
//                    $response['success'] = false;
//                    $response['message'] = '头像修改失败';
//                }
//                return json($response);
//            }else{
//                // 上传失败获取错误信息
//                $response['success'] = false;
//                $response['message'] = $file->getError();
//                return json($response);
//            }
//        }
//    }
//}
class User extends Controller
{
    protected $request;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->request=new Request();
    }

    public function login(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $u_account = $this->request->post("u_account");
        $u_password = $this->request->post("u_password");
        if ($u_account === '' || $u_password === ''){
            $response['success'] = false;
            $response['message'] = '账号、密码不能为空';
            return json($response);
        }
        $result1=Db::query("select * from user where u_account= '$u_account'");
        if ($result1 == []){
            $response['success'] = false;
            $response['message'] = '账号不存在';
        }else{
            if ($u_password == ($result1[0])['u_password']){
                $response['success'] = true;
                $response['message'] = '登录成功';
                $response['data'] = $result1;
            }else{
                $response['success'] = false;
                $response['message'] = '账号或密码错误';
            }
        }
        return json($response);

    }

    public function getUserDetails(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $u_id = $this->request->get("u_id");
        $result1=Db::query("select * from user where u_id= '$u_id'");
        if ($result1){
            $response['success'] = true;
            $response['message'] = '获取用户详情成功';
            $response['data'] = $result1;
        }else{
            $response['success'] = false;
            $response['message'] = '获取用户失败';
        }
        return json($response);
    }

    public function getUserList(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $u_type = $this->request->get("u_type");
        $u_account = $this->request->get("u_account");
        $u_name = $this->request->get("u_name");
        $pageSise = $this->request->get("pageSise"); // 每页总量
        $currentPage = $this->request->get("currentPage"); //当前页
        $startSize = ($currentPage - 1) * $pageSise; //起始数据下标

        if ($u_type !== ''){
            $sql1 = "select * from user
                where u_type = '$u_type'
                and u_name like '%$u_name%'
                and u_account like '%$u_account%'
                ORDER BY u_id ASC
                limit $startSize,$pageSise
                ";
            $sql2 = "select * from user
                where u_type = '$u_type'
                and u_name like '%$u_name%'
                and u_account like '%$u_account%'";
        }else{
            $sql1 = "select * from user
                where u_name like '%$u_name%'
                and u_account like '%$u_account%'
                ORDER BY u_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from user
                where u_name like '%$u_name%'
                and u_account like '%$u_account%'";
        }
        $result1=Db::query($sql1);
        $result2=Db::query($sql2);
        $response['success'] = true;
        $response['message'] = '获取用户列表成功';
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
        $u_id = $this->request->post("u_id");
        $u_name = $this->request->post("u_name");
        $u_oldPWD = $this->request->post("u_oldPWD");
        $u_newPWD = $this->request->post("u_newPWD");
        $u_type = $this->request->post("u_type");
        $u_sex = $this->request->post("u_sex");
        $u_phone = $this->request->post("u_phone");
        $u_email = $this->request->post("u_email");
        if ($u_oldPWD === '' || $u_oldPWD === null){
            $data = ['u_name' => $u_name, 'u_type' => $u_type, 'u_sex' => $u_sex,'u_phone' => $u_phone,'u_email' => $u_email];
        }else{
            $result1=Db::query("select * from user where u_id= '$u_id'");
            if (($result1[0])['u_password'] === $u_oldPWD){
                $data = ['u_name' => $u_name, 'u_password' => $u_newPWD, 'u_type' => $u_type, 'u_sex' => $u_sex,'u_phone' => $u_phone,'u_email' => $u_email];
            }else{
                $response['success'] = false;
                $response['message'] = '密码错误';
                return json($response);
            }
        }
        $result = Db::table('user')->where('u_id', $u_id)->update($data);;
        if ($result!==false){
            $response['success'] = true;
            $response['message'] = '用户修改成功';
        }else{
            $response['success'] = false;
            $response['message'] = '用户修改失败';
        }
        return json($response);
    }

    public function add(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $u_name = $this->request->post("u_name");
        $u_account = $this->request->post("u_account");
        $u_password = $this->request->post("u_password");
        $u_type = $this->request->post("u_type");
        $u_sex = $this->request->post("u_sex");
        $u_phone = $this->request->post("u_phone");
        $u_email = $this->request->post("u_email");
        $result1=Db::query("select * from user where u_account= '$u_account'");
//        return json($result1);
        if ($result1 !== []){
            $response['success'] = false;
            $response['message'] = '该账号已被占用';
        }else{
            $data = ['u_name' => $u_name,'u_account' => $u_account, 'u_password' => $u_password, 'u_type' => $u_type, 'u_sex' => $u_sex,'u_phone' => $u_phone,'u_email' => $u_email];
            $result2 = Db::table('user')->insert($data);
            if ($result2){
                $response['success'] = true;
                $response['message'] = '用户添加成功';
            }else{
                $response['success'] = false;
                $response['message'] = '用户添加失败';
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
        $u_id = $this->request->get("u_id");
        $result=Db::table('user')->where('u_id',$u_id)->delete();
        if ($result){
            $response['success'] = true;
            $response['message'] = '用户删除成功';
        }else{
            $response['success'] = false;
            $response['message'] = '用户删除失败';
        };
        return json($response);
    }

    public function uploadHeader(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        //拿到修改头像的用户ID
        $u_id = $this->request->get("u_id");
        $file = request()->file('file');
        if($file){
            $info = $file->move('upload/');
            if($info){
                $img = $info->getSaveName();
                $result = Db::table('user')->where('u_id',$u_id)->setField('u_img', 'upload/'.$img);
                if ($result!==false){
                    $response['success'] = true;
                    $response['message'] = '头像修改成功';
                    $response['data'] = [
                        "headerUrl" => 'upload/'.$img
                    ];
                }else{
                    $response['success'] = false;
                    $response['message'] = '头像修改失败';
                }
                return json($response);
            }else{
                // 上传失败获取错误信息
                $response['success'] = false;
                $response['message'] = $file->getError();
                return json($response);
            }
        }
    }
}