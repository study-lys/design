<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

//系统用户模块
Route::post('/user/login', 'index/user/login')->allowCrossDomain();//登录
Route::post('/user/uploadHeader', 'index/user/uploadHeader')->allowCrossDomain();//文件上传
Route::get('/user/getUserDetails', 'index/user/getUserDetails')->allowCrossDomain();//获取用户详情
Route::get('/user/getUserList', 'index/user/getUserList')->allowCrossDomain();//获取用户列表
Route::post('/user/edit', 'index/user/edit')->allowCrossDomain();//修改用户信息
Route::post('/user/add', 'index/user/add')->allowCrossDomain();//添加用户
Route::get('/user/delete', 'index/user/delete')->allowCrossDomain();//删除用户


//部门模块
Route::get('/department/getList', 'index/department/getList')->allowCrossDomain(); //列表
Route::post('/department/add', 'index/department/add')->allowCrossDomain();//添加
Route::get('/department/edit', 'index/department/edit')->allowCrossDomain();//修改
Route::get('/department/delete', 'index/department/delete')->allowCrossDomain();//删除
Route::get('/department/batchDelete', 'index/department/batchDelete')->allowCrossDomain();//批量删除
Route::get('/department/getStaff', 'index/department/getStaff')->allowCrossDomain();//根据部门ID获取员工列表

//员工模块
Route::get('/staff/getList', 'index/staff/getList')->allowCrossDomain();//列表
Route::get('/staff/add', 'index/staff/add')->allowCrossDomain();//添加
Route::get('/staff/edit', 'index/staff/edit')->allowCrossDomain();//修改
Route::get('/staff/getDetail', 'index/staff/getDetail')->allowCrossDomain();//获取详情
Route::get('/staff/delete', 'index/staff/delete')->allowCrossDomain();//删除
Route::get('/staff/batchDelete', 'index/staff/batchDelete')->allowCrossDomain();//批量删除

//薪资 - 职务
Route::get('/post/getPostName', 'index/post/getPostName')->allowCrossDomain();//获取职务名
Route::get('/post/getDepartment', 'index/post/getDepartment')->allowCrossDomain();//获取部门名
Route::get('/post/getPostList', 'index/post/getPostList')->allowCrossDomain();//获取职务列表 根据部门ID、职务ID查询  有分页
Route::get('/post/getList', 'index/post/getList')->allowCrossDomain();//获取职务列表 根据部门ID  无分页
Route::get('/post/delete', 'index/post/delete')->allowCrossDomain();//删除职务
Route::get('/post/editPost', 'index/post/editPost')->allowCrossDomain();//修改职务
Route::get('/post/addPost', 'index/post/addPost')->allowCrossDomain();//添加职务
//薪资 - 考勤
Route::get('/attendance/getAttendanceList', 'index/attendance/getAttendanceList')->allowCrossDomain();//获取考勤列表

return [

];
