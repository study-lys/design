/**
* 主要布局，包含头部标题栏、导航栏、尾部标题栏，嵌套路由为主要内容
* Author: liyinsheng
* Date: 2019-01-28
* Time: 15:13
* Email:cq_liyinsheng@163.com
*/
<template>
    <div class="mainLayout">
        <!--S 侧边栏-->
        <div class="side">
            <side-bar></side-bar>
        </div>
        <!--E 侧边栏-->

        <!--S 内容区（头部、内容、尾部）-->
        <div class="content theme-content">
            <header-bar></header-bar>

            <div class="area">
                <!--S 头部bar-->
                <div class="content_bar theme-border" v-if="contentNav.length !==0">
                    <router-link v-for="(value,index) in contentNav" :key="index" :to=value.to>
                        <span :class="value.value === list? 'active':''">{{value.name}}</span>
                    </router-link>
                </div>
                <!--E 头部bar-->
                <div class="area_content">
                    <router-view></router-view>
                </div>
            </div>

            <footer-bar></footer-bar>
        </div>
        <!--E 内容区（头部、内容、尾部）-->
    </div>
</template>

<script>
import { mapState } from 'vuex'
import SideBar from '@/components/SideBar'
import HeaderBar from '@/components/HeaderBar'
import FooterBar from '@/components/FooterBar'
export default {
    name: 'Index',
    components: {
        HeaderBar,
        SideBar,
        FooterBar
    },
    computed: {
        ...mapState(['contentNav','list'])
    }
}
</script>

<style scoped lang="scss">
    @import '@/assets/styles/flex/flex.scss';
    .mainLayout{
        //@include f-rn-fs-cs;
        @include f-rn-fs-cs;
        .side{
            width: 3.5rem;
        }
        .content{
            width: calc(100vw - 3.5rem);
            min-width: calc(1024px - 3.5rem);;
            .area{
                /*.area_content{*/
                    /*padding-top: .15rem;*/
                    /*overflow: auto;*/
                    /*height: calc(100vh - .98rem - .4rem - .82rem + .12rem);*/
                /*}*/
                overflow: auto;
                height: calc(100vh - .98rem - .4rem + .04rem);
                padding: .1rem .3rem .3rem .3rem;
            }
        }
    }
    .content_bar{
        padding: 0;
        /*margin-bottom: .4rem;*/
        margin-bottom: .2rem;

        border-width: 0 0 1px 0 !important;
        span{
            display: inline-block;
            border-bottom: 2px solid transparent;
            font-size: .22rem;
            padding: .15rem 0;
            margin-right: .2rem;
            cursor: pointer;
        }
        .active{
            border-color: #409EFF;
            color: #409EFF;
        }
    }

</style>
