/**
* 侧边栏
* Author: liyinsheng
* Date: 2019-01-28
* Time: 15:13
* Email:cq_liyinsheng@163.com
*/
<template>
    <div id="side" class="theme-side">
        <!--S 头部-->
        <div class="side_head theme-border">
            <div class="pic">
                <el-upload
                        title="更换头像"
                        class="avatar-uploader"
                        :action="uploadHeader"
                        :show-file-list="false"
                        :on-success="handleSuccess"
                        :before-upload="beforeUpload">
                    <img v-if="user.u_img === null || user.u_img === ''" :src="defaultHeader" class="avatar">
                    <img v-if="user.u_img !== null && user.u_img !== ''" :src="setHeadPortrait" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
                <span class="theme-user">{{user.u_name}}</span><br>
                <el-button type="warning" @click="quit()">注销</el-button>
            </div>
        </div>
        <!--E 头部-->

        <!--S 内容区（导航菜单）-->
        <div class="side_cont">
            <el-menu
                    default-active="2"
                    class="el-menu-vertical-demo"
                    background-color="#545c64"
                    text-color="#fff"
                    active-text-color="#fff">
                <!--默认激活栏、未知、打开事件、取消事件、背景色、字体色、激活后字体色-->
                <el-submenu v-for="(value,index) in construction" :key="index" :index='value.index'>
                    <template slot="title">
                        <i class="el-icon-location"></i>
                        <span>{{value.name}}</span>
                    </template>

                    <router-link v-for="(value2,index2) in value.child"
                                 :key="index2"
                                 :to="{path:value2.to}">
                        <el-menu-item
                                :class="[value2.to.split('/')[value2.to.split('/').length - 1] === list ? 'side_lib_active':'']"
                                :index="index + '-' +(index2+1)">
                            {{value2.name}}
                        </el-menu-item>
                    </router-link>
                </el-submenu>
            </el-menu>
        </div>
        <!--E 内容区（导航菜单）-->

    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import { mutationTypes } from '@/store.js'
import {getUserDetails} from '@/api/user'
export default {
    name: 'Side',
    data () {
        return {
            font_color: 'red'
        }
    },
    methods: {
        ...mapMutations({
            setContentNav: mutationTypes.SET_CONTENTNAV,
            setUser: mutationTypes.SET_LOGIN,
        }),
        // 头像上传成功
        handleSuccess(res, file) {
            if (res.success){
                this.$message({
                    type: 'success',
                    message: '头像修改成功'
                })
                getUserDetails({u_id:this.user.u_id}).then(res=>{
                    if (res.data.success){
                        this.setUser(res.data.data[0])
                    }
                })
            }else {
                this.$notify.error({
                    title: '头像修改失败',
                    message: `${res.message}`
                })
            }
        },
        beforeUpload(file) {
            const isJPG = file.type === 'image/jpeg';
            const isLt2M = file.size / 1024 / 1024 < 2;
            if (!isJPG) {
                this.$message.error('上传头像图片只能是 JPG 格式!');
            }
            if (!isLt2M) {
                this.$message.error('上传头像图片大小不能超过 2MB!');
            }
            return isJPG && isLt2M;
        },
        quit(){
            this.$confirm('确认要退出系统？', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                dangerouslyUseHTMLString: true,
                type: 'warning',
            }).then(()=>{
                this.$notify.success({
                    title: '退出成功',
                    message: `退出成功`
                })
                this.setUser('')
                this.$router.push({ path:'/login'})
            }).catch(()=>{

            })
        }
    },
    watch: {
        $route: {
            immediate: true,
            handler: function (/*val, oldVal*/) {
                // 当前页面所属大类（部门、员工、薪资、用户）
                this.setContentNav(this.$route.path.split('/')[1])
                // 当前页面所属小类（大类下的页面）
                this.$store.commit('setlist', {'list': this.$route.name})
            }
        }
    },
    computed: {
        ...mapState(['construction', 'list','user']),
        // 修改头像的请求地址
        uploadHeader(){
            let local = process.env.VUE_APP_API
            let api = '/user/uploadHeader'
            let get ='?u_id='
            return local+api +get + this.user.u_id
        },
        // 当用户未设置头像时 显示默认头像
        defaultHeader(){
            let local = process.env.VUE_APP_API
            let url = '/upload/20190423/6cef77b9556c4eeb382db4881c8aa588.jpg'
            return local+url
        },
        // 计算头像路径
        setHeadPortrait(){
            let local = process.env.VUE_APP_API
            return local + '/' + this.user.u_img
        }
    }
}
</script>

<style scoped lang="scss">
    @import '@/assets/styles/flex/flex.scss';
    .side_head{
        width: 100%;
        height: 2.5rem;
        box-sizing: border-box;
        border-width: 0 0 1px 0 !important;
        .pic{
            padding-top: .2rem;
            text-align: center;
            &/deep/.el-upload{
                display: inline-block;
                i{
                    line-height:1.2rem;
                    font-size: .22rem;
                    color: white;
                }
                background-color: #737679;
                height: 1.2rem;
                width: 1.2rem;
                overflow: hidden;
                border-radius: 50%;
                .avatar{
                    height: 100%;
                    position: relative;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%,-50%);
                }
            }
            .el-button{
                font-size: .22rem;
            }
        }
    }
    .side_cont{
        height: calc(100vh - 2.5rem);
        @include scroll-bar;
    }
</style>
