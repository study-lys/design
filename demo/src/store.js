import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)
export const mutationTypes = {
    SET_CONTENTNAV: 'SET_CONTENTNAV [设置内容导航]',
    SET_LOGIN: 'SET_LOGIN [设置登录用户信息]'
}
export default new Vuex.Store({
  state: {
      list: '',//当前所在
      construction: [
        {
            index: '1',
            name: '部门管理',
            value:'department',
            child: [
                {
                    name: '部门设置',
                    to: '/department/departmentSet',
                    backgroundColor: '#B3D52B',
                    icon: 'el-icon-circle-plus'
                },
                {
                    to: '/department/departmentList',
                    name: '部门列表',
                    backgroundColor: '#D5B32B',
                    icon: 'el-icon-circle-plus'
                }
            ]
        },
        {
            index: '2',
            name: '员工管理',
            value:'staff',
            child: [
                {
                    to: '/staff/staffSet',
                    name: '员工设置',
                    backgroundColor: '#66cccc',
                    icon: 'el-icon-circle-plus'
                },
                {
                    to: '/staff/staffList',
                    name: '员工列表',
                    backgroundColor: '#33cccc',
                    icon: 'el-icon-circle-plus'
                }
            ]
        },
        {
            index: '3',
            name: '薪资管理',
            value:'payroll',
            child: [
                {
                    to: '/payroll/payrollSet',
                    name: '职位薪资',
                    backgroundColor: '#ffcc00',
                    icon: 'el-icon-circle-plus'
                },
                {
                    to: '/payroll/payrollList',
                    name: '薪资详情',
                    backgroundColor: '#ffcc33',
                    icon: 'el-icon-circle-plus'
                }
            ]
        },
        {
            index: '4',
            name: '用户管理',
            value:'user',
            child: [
                {
                    to: '/user/userSet',
                    name: '用户设置',
                    backgroundColor: '#66cc00',
                    icon: 'el-icon-circle-plus'
                },
                {
                    to: '/user/userList',
                    name: '用户列表',
                    backgroundColor: '#66cc33',
                    icon: 'el-icon-circle-plus'
                }
            ]
        }
    ],// 项目结构
      contentNav:[],
      user:''//当前登录用户信息
  },
  mutations: {
        setlist (state, value) {
            state.list = value.list
        },
      // 设置内容导航
      [mutationTypes.SET_CONTENTNAV] (state, payload) {
          state.construction.some(value => {
              if (value.value === payload){
                  let contentNav = []
                  value.child.forEach(value1 => {
                      contentNav.push({
                          name:value1.name,
                          to:value1.to,
                          value:value1.to.split('/')[value1.to.split('/').length - 1]
                      })
                  })
                  state.contentNav = contentNav
                  return true
              }else {
                  state.contentNav = []
              }
          })
      },

      // 设置登录用户信息
      [mutationTypes.SET_LOGIN] (state, payload) {
          state.user = payload
      }
  },
  actions: {

  },
  plugins: [
    createPersistedState({
      // 当刷新时将state持久化于cookie中
      storage: window.sessionStorage
      //   ,
      // reducer: (state) => {
      //     let sessionState = Object.assign({}, state)
      //
      //     // 不将权限信息持久化
      //     delete sessionState.permission
      //     return sessionState
      // }
    })
  ]
})
