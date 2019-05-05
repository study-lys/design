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

//class Post extends Controller
//{
//    protected $request;
//    public function __construct(App $app = null)
//    {
//        parent::__construct($app);
//        $this->request=new Request();
//    }
//
//    public function getPostList(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $d_ids = $this->request->get("d_ids");
//        $posts = $this->request->get("posts");
//        $pageSise = $this->request->get("pageSise"); // 每页总量
//        $currentPage = $this->request->get("currentPage"); //当前页
//        $startSize = ($currentPage - 1) * $pageSise; //起始数据下标
//        if (($posts === '' || $posts === null) && ($d_ids === '' || $d_ids === null)){
//            $sql1 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
//                ORDER BY p_id ASC
//                limit $startSize,$pageSise";
//            $sql2 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
//                ORDER BY p_id ASC";
//        }else if (($posts === ''||$posts === null) && ($d_ids !== ''&& $d_ids !== null)){
//            $sql1 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
//                where post.d_id in ($d_ids)
//                ORDER BY p_id ASC
//                limit $startSize,$pageSise";
//            $sql2 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
//                where post.d_id in ($d_ids)
//                ORDER BY p_id ASC";
//        }else if (($posts !== '' && $posts !== null) && ($d_ids === '' || $d_ids === null)){
//            $sql1 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
//                where p_name  in ($posts)
//                ORDER BY p_id ASC
//                limit $startSize,$pageSise";
//            $sql2 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
//                where p_name  in ($posts)
//                ORDER BY p_id ASC";
//        }else if (($posts !== '' && $posts !== null) && ($d_ids !== ''&& $d_ids !== null)){
//            $sql1 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
//                where post.d_id in ($d_ids)
//                and p_name  in ($posts)
//                ORDER BY p_id ASC
//                limit $startSize,$pageSise";
//            $sql2 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
//                where post.d_id in ($d_ids)
//                and p_name  in ($posts)
//                ORDER BY p_id ASC";
//        }
//        $result1=Db::query($sql1);
//        $result2=Db::query($sql2);
//        $response['success'] = true;
//        $response['message'] = '获取职务列表成功';
//        $response['data'] = $result1;
//        $response['total'] = count($result2);
//        return json($response);
//    }
//
//    //根据部门ID查询职务  无分页
//    public function getList(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $d_id = $this->request->get("d_id");
//        $sql1 = "select * from post where d_id = $d_id  ORDER BY p_id ASC";
//        $result1=Db::query($sql1);
//        $response['success'] = true;
//        $response['message'] = '获取职务成功';
//        $response['data'] = $result1;
//        return json($response);
//    }
//
//    public function getPostName(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $sql = 'select p_name from post';
//        $result1=Db::query($sql);
//        //去重
//        foreach ($result1 as $key => $value) {
//            foreach ($value as $k => $v) {
//                if ($k == 'p_name') {
//                    $new_arr[] = $v;
//                }
//            }
//        }
//        $arr = array_unique($new_arr);
//        $response['success'] = true;
//        $response['message'] = '获取职务名成功';
//        $response['data'] = $arr;
//        return json($response);
//    }
//
//    public function getDepartment(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $sql = 'select d_id,d_name from department';
//        $result1=Db::query($sql);
//        $response['success'] = true;
//        $response['message'] = '获取部门列表成功';
//        $response['data'] = $result1;
//        return json($response);
//    }
//
//    public function delete(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $p_id = $this->request->get("p_id");
//        $sql = "SELECT * FROM staff where p_id=$p_id";
//        $result1=Db::query($sql);
//        if (count($result1)>0){
//            $response['success'] = false;
//            $response['message'] = '该职务正在被使用,请进行处理';
//        }else{
//            $result=Db::table('post')->where('p_id',$p_id)->delete();
//            if ($result){
//                $response['success'] = true;
//                $response['message'] = '职务删除成功';
//            }else{
//                $response['success'] = false;
//                $response['message'] = '职务删除失败';
//            };
//        }
//        return json($response);
//    }
//
//    public function editPost(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $p_id = $this->request->get("p_id");
//        $d_id = $this->request->get("d_id");
//        $p_wage = $this->request->get("p_wage");
//        $p_name = $this->request->get("p_name");
//        $sql = "SELECT * FROM post where d_id=$d_id and p_name='$p_name'";
//        $result1=Db::query($sql);
//        if (count($result1)>0 && (int)($result1[0])['p_id']!==(int)$p_id){
//            $response['success'] = false;
//            $response['message'] = '该部门下已存在此职务';
//        }else{
//            $data = ['d_id' => $d_id, 'p_wage' => $p_wage, 'p_name' => $p_name];
//            $result = Db::table('post')-> where('p_id', $p_id) ->update($data);
//            if ($result!==false){
//                $response['success'] = true;
//                $response['message'] = '职务修改成功';
//            }else{
//                $response['success'] = false;
//                $response['message'] = '职务修改失败';
//            };
//        }
//        return json($response);
//    }
//
//    public function addPost(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $d_id = $this->request->get("d_id");
//        $p_wage = $this->request->get("p_wage");
//        $p_name = $this->request->get("p_name");
//        $sql = "SELECT * FROM post where d_id=$d_id and p_name='$p_name'";
//        $result1=Db::query($sql);
////        return json($result1);
//        if (count($result1)>0){
//            $response['success'] = false;
//            $response['message'] = '该部门下已存在此职务';
//        }else{
//            $data = ['d_id' => $d_id, 'p_wage' => $p_wage, 'p_name' => $p_name];
//            $result = Db::table('post')->insert($data);
//            if ($result){
//                $response['success'] = true;
//                $response['message'] = '职务添加成功';
//            }else{
//                $response['success'] = false;
//                $response['message'] = '职务添加失败';
//            };
//        }
//        return json($response);
//    }
//}
class Post extends Controller
{
    protected $request;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->request=new Request();
    }

    public function getPostList(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_ids = $this->request->get("d_ids");
        $posts = $this->request->get("posts");
        $pageSise = $this->request->get("pageSise"); // 每页总量
        $currentPage = $this->request->get("currentPage"); //当前页
        $startSize = ($currentPage - 1) * $pageSise; //起始数据下标
        if (($posts === '' || $posts === null) && ($d_ids === '' || $d_ids === null)){
            $sql1 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
                ORDER BY p_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
                ORDER BY p_id ASC";
        }else if (($posts === ''||$posts === null) && ($d_ids !== ''&& $d_ids !== null)){
            $sql1 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
                where post.d_id in ($d_ids)
                ORDER BY p_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
                where post.d_id in ($d_ids)
                ORDER BY p_id ASC";
        }else if (($posts !== '' && $posts !== null) && ($d_ids === '' || $d_ids === null)){
            $sql1 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
                where p_name  in ($posts)
                ORDER BY p_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
                where p_name  in ($posts)
                ORDER BY p_id ASC";
        }else if (($posts !== '' && $posts !== null) && ($d_ids !== ''&& $d_ids !== null)){
            $sql1 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
                where post.d_id in ($d_ids)
                and p_name  in ($posts)
                ORDER BY p_id ASC
                limit $startSize,$pageSise";
            $sql2 = "select * from post LEFT JOIN department ON department.d_id = post.d_id
                where post.d_id in ($d_ids)
                and p_name  in ($posts)
                ORDER BY p_id ASC";
        }
        $result1=Db::query($sql1);
        $result2=Db::query($sql2);
        $response['success'] = true;
        $response['message'] = '获取职务列表成功';
        $response['data'] = $result1;
        $response['total'] = count($result2);
        return json($response);
    }

    //根据部门ID查询职务  无分页
    public function getList(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_id = $this->request->get("d_id");
        $sql1 = "select * from post where d_id = $d_id  ORDER BY p_id ASC";
        $result1=Db::query($sql1);
        $response['success'] = true;
        $response['message'] = '获取职务成功';
        $response['data'] = $result1;
        return json($response);
    }

    public function getPostName(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $sql = 'select p_name from post';
        $result1=Db::query($sql);
        //去重
        foreach ($result1 as $key => $value) {
            foreach ($value as $k => $v) {
                if ($k == 'p_name') {
                    $new_arr[] = $v;
                }
            }
        }
        $arr = array_unique($new_arr);
        $response['success'] = true;
        $response['message'] = '获取职务名成功';
        $response['data'] = $arr;
        return json($response);
    }

    public function getDepartment(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $sql = 'select d_id,d_name from department';
        $result1=Db::query($sql);
        $response['success'] = true;
        $response['message'] = '获取部门列表成功';
        $response['data'] = $result1;
        return json($response);
    }

    public function delete(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $p_id = $this->request->get("p_id");
        $sql = "SELECT * FROM staff where p_id=$p_id";
        $result1=Db::query($sql);
        if (count($result1)>0){
            $response['success'] = false;
            $response['message'] = '该职务正在被使用,请进行处理';
        }else{
            $result=Db::table('post')->where('p_id',$p_id)->delete();
            if ($result){
                $response['success'] = true;
                $response['message'] = '职务删除成功';
            }else{
                $response['success'] = false;
                $response['message'] = '职务删除失败';
            };
        }
        return json($response);
    }

    public function editPost(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $p_id = $this->request->get("p_id");
        $d_id = $this->request->get("d_id");
        $p_wage = $this->request->get("p_wage");
        $p_name = $this->request->get("p_name");
        $sql = "SELECT * FROM post where d_id=$d_id and p_name='$p_name'";
        $result1=Db::query($sql);
        if (count($result1)>0 && (int)($result1[0])['p_id']!==(int)$p_id){
            $response['success'] = false;
            $response['message'] = '该部门下已存在此职务';
        }else{
            $data = ['d_id' => $d_id, 'p_wage' => $p_wage, 'p_name' => $p_name];
            $result = Db::table('post')-> where('p_id', $p_id) ->update($data);
            if ($result!==false){
                $response['success'] = true;
                $response['message'] = '职务修改成功';
            }else{
                $response['success'] = false;
                $response['message'] = '职务修改失败';
            };
        }
        return json($response);
    }

    public function addPost(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $d_id = $this->request->get("d_id");
        $p_wage = $this->request->get("p_wage");
        $p_name = $this->request->get("p_name");
        $sql = "SELECT * FROM post where d_id=$d_id and p_name='$p_name'";
        $result1=Db::query($sql);
//        return json($result1);
        if (count($result1)>0){
            $response['success'] = false;
            $response['message'] = '该部门下已存在此职务';
        }else{
            $data = ['d_id' => $d_id, 'p_wage' => $p_wage, 'p_name' => $p_name];
            $result = Db::table('post')->insert($data);
            if ($result){
                $response['success'] = true;
                $response['message'] = '职务添加成功';
            }else{
                $response['success'] = false;
                $response['message'] = '职务添加失败';
            };
        }
        return json($response);
    }
}