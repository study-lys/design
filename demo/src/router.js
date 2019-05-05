import Vue from 'vue'
import Router from 'vue-router'
import MainLayout from '@/layout/MainLayout'
import Home from '@/views/home'
import Login from '@/views/login'
import DepartmentList from '@/views/department/departmentList'
import DepartmentSet from '@/views/department/departmentSet'
import StaffList from '@/views/staff/staffList'
import StafftSet from '@/views/staff/staffSet'
import PayrollList from '@/views/payroll/payrollList'
import PayrollSet from '@/views/payroll/payrollSet'
import UserSet from '@/views/user/userSet'
import UserList from '@/views/user/userList'

Vue.use(Router)

export default new Router({
  routes: [
      {
          path: '/',
          name: '/',
          component: MainLayout,
          redirect: { name: '/' },
          meta: {
              auth:true
          },
          children: [
            {
                path: '/',
                name: '/',
                component: Home
            }
          ]
        },
      {
          path: '/login',
          name: 'login',
          component: Login
      },
      {
          path: '/department',
          name: 'department',
          component: MainLayout,
          redirect: { name: 'departmentList' },
          meta: {
              auth:true
          },
          children: [
              {
                  path: 'departmentList',
                  name: 'departmentList',
                  component: DepartmentList
              },
              {
                  path: 'departmentSet',
                  name: 'departmentSet',
                  component: DepartmentSet
              }
          ]
      },
      {
          path: '/staff',
          name: 'staff',
          component: MainLayout,
          redirect: { name: 'staffList' },
          meta: {
              auth:true
          },
          children: [
              {
                  path: 'staffList',
                  name: 'staffList',
                  component: StaffList
              },
              {
                  path: 'staffSet',
                  name: 'staffSet',
                  component: StafftSet
              }
          ]
      },
      {
          path: '/payroll',
          name: 'payroll',
          component: MainLayout,
          redirect: { name: 'payrollList' },
          meta: {
              auth:true
          },
          children: [
              {
                  path: 'payrollList',
                  name: 'payrollList',
                  component: PayrollList
              },
              {
                  path: 'payrollSet',
                  name: 'payrollSet',
                  component: PayrollSet
              }
          ]
      },
      {
          path: '/user',
          name: 'user',
          component: MainLayout,
          redirect: { name: 'userList' },
          meta: {
              auth:true
          },
          children: [
              {
                  path: 'userList',
                  name: 'userList',
                  component: UserList
              },
              {
                  path: 'userSet',
                  name: 'userSet',
                  component: UserSet
              }
          ]
      }
  ]
})
