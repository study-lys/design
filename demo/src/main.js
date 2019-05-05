import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './assets/styles/index.scss'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)

Vue.config.productionTip = false

// 注册全局路由
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        // 判断登录状态，如未登录，存下当前路由，待登录后导航至指定路由
        if (store.state.user !=='') {
            next()
        } else {
            next({
                path: '/login',
                query: {
                    navigate: to.fullPath
                }
            })
        }
    } else {
        next()
    }
})

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
