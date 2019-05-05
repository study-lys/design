/**
* 头部标题栏
* Author: liyinsheng
* Date: 2019-01-28
* Time: 15:13
* Email:cq_liyinsheng@163.com
*/
<template>
    <div>
        <router-link :to="{name:'/',params:{'list':''}}">
            <p title="工作台" class="cont_head theme-header theme-font-white"><b>人事管理系统</b></p>
        </router-link>
    </div>
</template>

<script>
export default {
    name: "index",
    data(){
        return{
        }
    }
}
</script>

<style scoped lang="scss">
</style>
