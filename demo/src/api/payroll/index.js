/**
 * 薪资管理api
 * Author: liyinsheng
 * Date: 2019-02-21
 * Time: 00:38
 * Email:cq_liyinsheng@163.com
 */
import request from 'axios'

/*——————————————————薪资管理 - 职务——————————————————————*/
/**
 * 获取职务名称列表
 */
function getPostName () {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/post/getPostName`,
        params: {
        }
    })
}

/**
 * 获取部门列表
 */
function getDepartment () {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/post/getDepartment`,
        params: {
        }
    })
}

/**
 * 获取职务列表
 */
function getPostList ({currentPage,pageSise,posts,d_ids}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/post/getPostList`,
        params: {
            currentPage,pageSise,posts,d_ids
        }
    })
}

/**
 * 根据部门id获取职务列表 - 员工职务选择
 */
function getList ({d_id}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/post/getList`,
        params: {
            d_id
        }
    })
}

/**
 * 删除职务
 */
function deletePost ({p_id}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/post/delete`,
        params: {
            p_id
        }
    })
}


/**
 * 修改职务
 */
function editPost ({p_id,d_id,p_wage,p_name}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/post/editPost`,
        params: {
            p_id,d_id,p_wage,p_name
        }
    })
}

/**
 * 添加职务
 */
function addPost ({d_id,p_wage,p_name}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/post/addPost`,
        params: {
            d_id,p_wage,p_name
        }
    })
}

/*——————————————————薪资管理 - 薪资——————————————————————*/

/**
 * 获取考勤列表
 */
function getAttendanceList ({currentPage,pageSise,posts,d_ids,s_name}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/attendance/getAttendanceList`,
        params: {
            currentPage,pageSise,posts,d_ids,s_name
        }
    })
}


export {
    getPostName,getDepartment,getPostList,deletePost,editPost,addPost,getAttendanceList,getList
}
