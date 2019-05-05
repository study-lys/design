/**
 * 部门模块api
 * Author: liyinsheng
 * Date: 2019-02-21
 * Time: 00:38
 * Email:cq_liyinsheng@163.com
 */
import request from 'axios'

/**
 * 获取列表
 */
function getList ({d_name,pageSise,currentPage}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/department/getList`,
        params: {
            d_name,pageSise,currentPage
        }
    })
}

/**
 * 添加部门
 */
function add ({d_name,d_details}) {
    return request({
        method: 'post',
        url: `${process.env.VUE_APP_API}/department/add`,
        data: {
            d_name,d_details
        }
    })
}

/**
 * 修改部门
 */
function edits ({d_id,d_name,s_id,d_details}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/department/edit`,
        params: {
            d_id,d_name,s_id,d_details
        }
    })
}

/**
 * 根据部门ID获取员工列表
 */
function getStaff ({id}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/department/getStaff`,
        params: {
            id
        }
    })
}

/**
 * 删除部门
 */
function del ({d_id}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/department/delete`,
        params: {
            d_id
        }
    })
}

/**
 * 批量删除部门
 */
function batchDelete ({selection}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/department/batchDelete`,
        params: {
            selection
        }
    })
}

export {
    getList,add,edits,del,batchDelete,getStaff
}
