/**
 * 登录模块api
 * Author: liyinsheng
 * Date: 2019-02-21
 * Time: 00:38
 * Email:cq_liyinsheng@163.com
 */
import request from 'axios'

/**
 * 登陆
 */
function loginSYS ({u_account,u_password}) {
    return request({
        method: 'post',
        url: `${process.env.VUE_APP_API}/user/login`,
        data: {
            u_account,
            u_password
        }
    })
}

export {
    loginSYS
}
