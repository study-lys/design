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

//class Staff extends Controller
//{
//    protected $request;
//    public function __construct(App $app = null)
//    {
//        parent::__construct($app);
//        $this->request=new Request();
//    }
//
//    public function add(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $s_name = $this->request->get("s_name");
//        $s_sex = $this->request->get("s_sex");
//        $s_birthday = $this->request->get("s_birthday");
//        $s_phone = $this->request->get("s_phone");
//        $s_education = $this->request->get("s_education");
//        $s_email = $this->request->get("s_email");
//        $d_id = $this->request->get("d_id");
//        $p_id  = $this->request->get("p_id");
//        $s_startTime = $this->request->get("s_startTime");
//        $s_maritalStatus = $this->request->get("s_maritalStatus");
//        $s_nation = $this->request->get("s_nation");
//        $s_nativePlace = $this->request->get("s_nativePlace");
//        $s_location = $this->request->get("s_location");
//        $s_stature = $this->request->get("s_stature");
//        $s_weight = $this->request->get("s_weight");
//        $s_idNumber = $this->request->get("s_idNumber");
//        $s_skill = $this->request->get("s_skill");
//        $s_politicsStatus = $this->request->get("s_politicsStatus");
//        $result1=Db::query("select * from staff where s_idNumber= '$s_idNumber'");
//        if ($result1 !== []){
//            $response['success'] = false;
//            $response['message'] = '该身份证已被注册';
//        }else{
//            $data = [
//                's_name' => $s_name,
//                's_sex' => $s_sex,
//                's_birthday' => $s_birthday,
//                's_phone' => $s_phone,
//                's_education' => $s_education,
//                's_email' => $s_email,
//                'd_id' => $d_id,
//                'p_id' => $p_id,
//                's_startTime' => $s_startTime,
//                's_maritalStatus' => $s_maritalStatus,
//                's_nation' => $s_nation,
//                's_nativePlace' => $s_nativePlace,
//                's_location' => $s_location,
//                's_stature' => $s_stature,
//                's_weight' => $s_weight,
//                's_idNumber' => $s_idNumber,
//                's_skill' => $s_skill,
//                's_politicsStatus' => $s_politicsStatus
//            ];
//           $result2 = Db::table('staff')->insert($data);
//            if ($result2){
//                $response['success'] = true;
//                $response['message'] = '员工添加成功';
//            }else{
//                $response['success'] = false;
//                $response['message'] = '员工添加失败';
//            }
//        }
//        return json($response);
//    }
//
//    public function getList(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $d_ids = $this->request->get("d_ids");
//        $s_name = $this->request->get("s_name");
//        $pageSise = $this->request->get("pageSise"); // 每页总量
//        $currentPage = $this->request->get("currentPage"); //当前页
//        $startSize = ($currentPage - 1) * $pageSise; //起始数据下标
//        if ($d_ids === ''){
//            $sql = "select staff.s_id,staff.s_name,staff.s_sex,staff.s_phone,staff.s_email,department.d_name,post.p_name
//                from staff LEFT JOIN department ON department.d_id = staff.d_id
//                LEFT JOIN post ON post.p_id = staff.p_id
//                where s_name like '%$s_name%'
//                ORDER BY staff.s_id ASC
//                limit $startSize,$pageSise";
//            $sq2 = "select staff.s_id,staff.s_name,staff.s_sex,staff.s_phone,staff.s_email,department.d_name,post.p_name
//                from staff LEFT JOIN department ON department.d_id = staff.d_id
//                LEFT JOIN post ON post.p_id = staff.p_id
//                where s_name like '%$s_name%'
//                ORDER BY staff.s_id ASC";
//        }else{
//           $sql = "select staff.s_id,staff.s_name,staff.s_sex,staff.s_phone,staff.s_email,department.d_name,post.p_name
//                from staff LEFT JOIN department ON department.d_id = staff.d_id
//               LEFT JOIN post ON post.p_id = staff.p_id
//               where staff.d_id in ($d_ids)
//               and s_name like '%$s_name%'
//               ORDER BY staff.s_id ASC
//               limit $startSize,$pageSise";
//            $sq2 = "select staff.s_id,staff.s_name,staff.s_sex,staff.s_phone,staff.s_email,department.d_name,post.p_name
//                from staff LEFT JOIN department ON department.d_id = staff.d_id
//               LEFT JOIN post ON post.p_id = staff.p_id
//               where staff.d_id in ($d_ids)
//               and s_name like '%$s_name%'
//               ORDER BY staff.s_id ASC";
//        }
//        $result=Db::query($sql);
//        $result2=Db::query($sq2);
//        $response['success'] = true;
//        $response['message'] = '获取部门列表成功';
//        $response['data'] = $result;
//        $response['total'] = count($result2);
//        return json($response);
//    }
//
//    public function getDetail(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $s_id = $this->request->get("s_id");
//        $result1=Db::query("select * from staff where s_id= '$s_id'");
//        $response['success'] = true;
//        $response['message'] = '获取员工详情成功';
//        $response['data'] = $result1;
//        return json($response);
//    }
//
//    public function edit(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $s_id = $this->request->get("s_id");
//        $s_name = $this->request->get("s_name");
//        $s_sex = $this->request->get("s_sex");
//        $s_birthday = $this->request->get("s_birthday");
//        $s_phone = $this->request->get("s_phone");
//        $s_education = $this->request->get("s_education");
//        $s_email = $this->request->get("s_email");
//        $d_id = $this->request->get("d_id");
//        $p_id  = $this->request->get("p_id");
//        $s_startTime = $this->request->get("s_startTime");
//        $s_maritalStatus = $this->request->get("s_maritalStatus");
//        $s_nation = $this->request->get("s_nation");
//        $s_nativePlace = $this->request->get("s_nativePlace");
//        $s_location = $this->request->get("s_location");
//        $s_stature = $this->request->get("s_stature");
//        $s_weight = $this->request->get("s_weight");
//        $s_idNumber = $this->request->get("s_idNumber");
//        $s_skill = $this->request->get("s_skill");
//        $s_politicsStatus = $this->request->get("s_politicsStatus");
//
//        $result1=Db::query("select * from staff where s_idNumber= '$s_idNumber'");
//        if ($result1 !== [] && (int)($result1[0])['s_id']!==(int)$s_id){
//            $response['success'] = false;
//            $response['message'] = '该身份证已被注册';
//        }else{
//            $data = [
//                's_name' => $s_name,
//                's_sex' => $s_sex,
//                's_birthday' => $s_birthday,
//                's_phone' => $s_phone,
//                's_education' => $s_education,
//                's_email' => $s_email,
//                'd_id' => $d_id,
//                'p_id' => $p_id,
//                's_startTime' => $s_startTime,
//                's_maritalStatus' => $s_maritalStatus,
//                's_nation' => $s_nation,
//                's_nativePlace' => $s_nativePlace,
//                's_location' => $s_location,
//                's_stature' => $s_stature,
//                's_weight' => $s_weight,
//                's_idNumber' => $s_idNumber,
//                's_skill' => $s_skill,
//                's_politicsStatus' => $s_politicsStatus
//            ];
//            $result2 = Db::table('staff')-> where('s_id', $s_id) ->update($data);
//            if ($result2 !== false){
//                $response['success'] = true;
//                $response['message'] = '员工修改成功';
//            }else{
//                $response['success'] = false;
//                $response['message'] = '员工修改失败';
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
//        $s_id = $this->request->get("s_id");
//        $result=Db::table('staff')->where('s_id',$s_id)->delete();
//        if ($result){
//            $response['success'] = true;
//            $response['message'] = '员工删除成功';
//        }else{
//            $response['success'] = false;
//            $response['message'] = '员工删除失败';
//        };
//        return json($response);
//    }
//
//    public function batchDelete(){
//        $response = [
//            "success" => false,
//            "message" => "",
//            "data" => []
//        ];
//        $s_id = $this->request->get("selection");
//        $result=Db::table('staff')->delete(($s_id));
//        if ($result){
//            $response['success'] = true;
//            $response['message'] = '批量删除员工成功';
//        }else{
//            $response['success'] = false;
//            $response['message'] = '批量删除员工失败';
//        };
//        return json($response);
//    }
//}
class Staff extends Controller
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
        $s_name = $this->request->get("s_name");
        $s_sex = $this->request->get("s_sex");
        $s_birthday = $this->request->get("s_birthday");
        $s_phone = $this->request->get("s_phone");
        $s_education = $this->request->get("s_education");
        $s_email = $this->request->get("s_email");
        $d_id = $this->request->get("d_id");
        $p_id  = $this->request->get("p_id");
        $s_startTime = $this->request->get("s_startTime");
        $s_maritalStatus = $this->request->get("s_maritalStatus");
        $s_nation = $this->request->get("s_nation");
        $s_nativePlace = $this->request->get("s_nativePlace");
        $s_location = $this->request->get("s_location");
        $s_stature = $this->request->get("s_stature");
        $s_weight = $this->request->get("s_weight");
        $s_idNumber = $this->request->get("s_idNumber");
        $s_skill = $this->request->get("s_skill");
        $s_politicsStatus = $this->request->get("s_politicsStatus");
        $result1=Db::query("select * from staff where s_idNumber= '$s_idNumber'");
        if ($result1 !== []){
            $response['success'] = false;
            $response['message'] = '该身份证已被注册';
        }else{
            $data = [
                's_name' => $s_name,
                's_sex' => $s_sex,
                's_birthday' => $s_birthday,
                's_phone' => $s_phone,
                's_education' => $s_education,
                's_email' => $s_email,
                'd_id' => $d_id,
                'p_id' => $p_id,
                's_startTime' => $s_startTime,
                's_maritalStatus' => $s_maritalStatus,
                's_nation' => $s_nation,
                's_nativePlace' => $s_nativePlace,
                's_location' => $s_location,
                's_stature' => $s_stature,
                's_weight' => $s_weight,
                's_idNumber' => $s_idNumber,
                's_skill' => $s_skill,
                's_politicsStatus' => $s_politicsStatus
            ];
            $result2 = Db::table('staff')->insert($data);
            if ($result2){
                $result3=Db::query("select s_id from staff where s_idNumber= '$s_idNumber'");
                $s_id = (int)($result3[0])['s_id'];
                $data1 = ['s_id' => $s_id,'a_attendance' => 0, 'a_vacate' => 0, 'a_overtime' => 0, 'a_specialOvertime' => 0];
                $result4 = Db::table('attendance')->insert($data1);
                $response['success'] = true;
                $response['message'] = '员工添加成功';
            }else{
                $response['success'] = false;
                $response['message'] = '员工添加失败';
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
        $d_ids = $this->request->get("d_ids");
        $s_name = $this->request->get("s_name");
        $pageSise = $this->request->get("pageSise"); // 每页总量
        $currentPage = $this->request->get("currentPage"); //当前页
        $startSize = ($currentPage - 1) * $pageSise; //起始数据下标
        if ($d_ids === ''){
            $sql = "select staff.s_id,staff.s_name,staff.s_sex,staff.s_phone,staff.s_email,department.d_name,post.p_name
                from staff LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where s_name like '%$s_name%'
                ORDER BY staff.s_id ASC
                limit $startSize,$pageSise";
            $sq2 = "select staff.s_id,staff.s_name,staff.s_sex,staff.s_phone,staff.s_email,department.d_name,post.p_name
                from staff LEFT JOIN department ON department.d_id = staff.d_id
                LEFT JOIN post ON post.p_id = staff.p_id
                where s_name like '%$s_name%'
                ORDER BY staff.s_id ASC";
        }else{
            $sql = "select staff.s_id,staff.s_name,staff.s_sex,staff.s_phone,staff.s_email,department.d_name,post.p_name
                from staff LEFT JOIN department ON department.d_id = staff.d_id
               LEFT JOIN post ON post.p_id = staff.p_id
               where staff.d_id in ($d_ids)
               and s_name like '%$s_name%'
               ORDER BY staff.s_id ASC
               limit $startSize,$pageSise";
            $sq2 = "select staff.s_id,staff.s_name,staff.s_sex,staff.s_phone,staff.s_email,department.d_name,post.p_name
                from staff LEFT JOIN department ON department.d_id = staff.d_id
               LEFT JOIN post ON post.p_id = staff.p_id
               where staff.d_id in ($d_ids)
               and s_name like '%$s_name%'
               ORDER BY staff.s_id ASC";
        }
        $result=Db::query($sql);
        $result2=Db::query($sq2);
        $response['success'] = true;
        $response['message'] = '获取部门列表成功';
        $response['data'] = $result;
        $response['total'] = count($result2);
        return json($response);
    }

    public function getDetail(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $s_id = $this->request->get("s_id");
        $result1=Db::query("select * from staff where s_id= '$s_id'");
        $response['success'] = true;
        $response['message'] = '获取员工详情成功';
        $response['data'] = $result1;
        return json($response);
    }

    public function edit(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $s_id = $this->request->get("s_id");
        $s_name = $this->request->get("s_name");
        $s_sex = $this->request->get("s_sex");
        $s_birthday = $this->request->get("s_birthday");
        $s_phone = $this->request->get("s_phone");
        $s_education = $this->request->get("s_education");
        $s_email = $this->request->get("s_email");
        $d_id = $this->request->get("d_id");
        $p_id  = $this->request->get("p_id");
        $s_startTime = $this->request->get("s_startTime");
        $s_maritalStatus = $this->request->get("s_maritalStatus");
        $s_nation = $this->request->get("s_nation");
        $s_nativePlace = $this->request->get("s_nativePlace");
        $s_location = $this->request->get("s_location");
        $s_stature = $this->request->get("s_stature");
        $s_weight = $this->request->get("s_weight");
        $s_idNumber = $this->request->get("s_idNumber");
        $s_skill = $this->request->get("s_skill");
        $s_politicsStatus = $this->request->get("s_politicsStatus");

        $result1=Db::query("select * from staff where s_idNumber= '$s_idNumber'");
        if ($result1 !== [] && (int)($result1[0])['s_id']!==(int)$s_id){
            $response['success'] = false;
            $response['message'] = '该身份证已被注册';
        }else{
            $data = [
                's_name' => $s_name,
                's_sex' => $s_sex,
                's_birthday' => $s_birthday,
                's_phone' => $s_phone,
                's_education' => $s_education,
                's_email' => $s_email,
                'd_id' => $d_id,
                'p_id' => $p_id,
                's_startTime' => $s_startTime,
                's_maritalStatus' => $s_maritalStatus,
                's_nation' => $s_nation,
                's_nativePlace' => $s_nativePlace,
                's_location' => $s_location,
                's_stature' => $s_stature,
                's_weight' => $s_weight,
                's_idNumber' => $s_idNumber,
                's_skill' => $s_skill,
                's_politicsStatus' => $s_politicsStatus
            ];
            $result2 = Db::table('staff')-> where('s_id', $s_id) ->update($data);
            if ($result2 !== false){
                $response['success'] = true;
                $response['message'] = '员工修改成功';
            }else{
                $response['success'] = false;
                $response['message'] = '员工修改失败';
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
        $s_id = $this->request->get("s_id");
        $result=Db::table('staff')->where('s_id',$s_id)->delete();
        if ($result){
            $result1=Db::table('attendance')->where('s_id',$s_id)->delete();
            $response['success'] = true;
            $response['message'] = '员工删除成功';
        }else{
            $response['success'] = false;
            $response['message'] = '员工删除失败';
        };
        return json($response);
    }

    public function batchDelete(){
        $response = [
            "success" => false,
            "message" => "",
            "data" => []
        ];
        $s_id = $this->request->get("selection");
        $result=Db::table('staff')->delete(($s_id));
        if ($result){
            $response['success'] = true;
            $response['message'] = '批量删除员工成功';
        }else{
            $response['success'] = false;
            $response['message'] = '批量删除员工失败';
        };
        return json($response);
    }
}