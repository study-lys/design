/**
 * 用户管理模块api
 * Author: liyinsheng
 * Date: 2019-02-21
 * Time: 00:38
 * Email:cq_liyinsheng@163.com
 */
import request from 'axios'

/**
 * 获取用户详情
 */
function getUserDetails ({u_id}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/user/getUserDetails`,
        params: {
            u_id
        }
    })
}

/**
 * 获取用户列表
 */
function getUserList ({u_type,u_name,u_account,pageSise,currentPage}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/user/getUserList`,
        params: {
            u_type,u_name,u_account,pageSise,currentPage
        }
    })
}

/**
 * 删除用户
 */
function delUser ({u_id}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/user/delete`,
        params: {
            u_id
        }
    })
}

/**
 * 修改用户
 */
function editUser ({u_id,u_name,u_oldPWD,u_newPWD,u_type,u_sex,u_phone,u_email}) {
    return request({
        method: 'post',
        url: `${process.env.VUE_APP_API}/user/edit`,
        data: {
            u_id,u_name,u_oldPWD,u_newPWD,u_type,u_sex,u_phone,u_email
        }
    })
}

/**
 * 添加用户
 */
function addUser ({u_account,u_name,u_password,u_type,u_sex,u_phone,u_email}) {
    return request({
        method: 'post',
        url: `${process.env.VUE_APP_API}/user/add`,
        data: {
            u_account,u_name,u_password,u_type,u_sex,u_phone,u_email
        }
    })
}

export {
    getUserDetails,getUserList,delUser,editUser,addUser
}
