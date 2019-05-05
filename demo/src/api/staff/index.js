/**
 * 员工管理api
 * Author: liyinsheng
 * Date: 2019-02-21
 * Time: 00:38
 * Email:cq_liyinsheng@163.com
 */
import request from 'axios'

/**
 * 添加员工
 */
function addStaff ({s_name,s_sex,s_birthday,s_phone,s_education,s_email,d_id,p_id,s_startTime,
                       s_maritalStatus,s_nation,s_nativePlace,s_location,s_stature,s_weight,s_idNumber,
                       s_skill,s_politicsStatus}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/staff/add`,
        params: {
            s_name,s_sex,s_birthday,s_phone,s_education,s_email,d_id,p_id,s_startTime,
            s_maritalStatus,s_nation,s_nativePlace,s_location,s_stature,s_weight,s_idNumber,
            s_skill,s_politicsStatus
        }
    })
}

/**
 * 修改员工
 */
function edit ({s_id,s_name,s_sex,s_birthday,s_phone,s_education,s_email,d_id,p_id,s_startTime,
                       s_maritalStatus,s_nation,s_nativePlace,s_location,s_stature,s_weight,s_idNumber,
                       s_skill,s_politicsStatus}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/staff/edit`,
        params: {
            s_id,s_name,s_sex,s_birthday,s_phone,s_education,s_email,d_id,p_id,s_startTime,
            s_maritalStatus,s_nation,s_nativePlace,s_location,s_stature,s_weight,s_idNumber,
            s_skill,s_politicsStatus
        }
    })
}

/**
 * 获取员工列表
 */
function getList ({d_ids,s_name,pageSise,currentPage}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/staff/getList`,
        params: {
            d_ids,s_name,pageSise,currentPage
        }
    })
}

/**
 * 删除员工
 */
function staffDelete ({s_id}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/staff/delete`,
        params: {
           s_id
        }
    })
}

/**
 * 批量删除员工
 */
function batchDelete ({selection}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/staff/batchDelete`,
        params: {
            selection
        }
    })
}

/**
 * 获取员工详情
 */
function getDetail ({s_id}) {
    return request({
        method: 'get',
        url: `${process.env.VUE_APP_API}/staff/getDetail`,
        params: {
            s_id
        }
    })
}

export {
    addStaff,staffDelete,getList,batchDelete,getDetail,edit
}
