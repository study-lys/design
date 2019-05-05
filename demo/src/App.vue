<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
import _ from 'lodash'
// import { mapActions } from 'vuex'
export default {
  name: 'app',
  methods: {
      /**
       * 设置根元素html的文字大小，保证其最小文字大小为12px
       */
      setRootFontSize () {
          window.document.getElementsByTagName('html')[0].style.fontSize =
              // (window.document.body.clientWidth >= 1280 ? window.document.body.clientWidth : 1440) * 100 / 1920 + 'px'
              (window.document.body.clientWidth >= 1024 ? window.document.body.clientWidth : 1024) * 100 / 1920 + 'px'
      },
      /**
       * 初始化方法
       * 1. 设置 rem
       */
      init () {
          // 初始化设置根元素文本大小（rem）
          this.setRootFontSize()
      }
  },
  mounted () {
      // 应用初始化方法
      this.init()
      // 添加全局resize监听，以设置文字大小
      window.addEventListener('resize', _.throttle(() => this.setRootFontSize(), 50))
  }
}
</script>

<style>
  #app {
    min-width:1024px;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }
</style>
