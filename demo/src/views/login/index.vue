/**
* 登录
* Author: liyinsheng
* Date: 2019-01-29
* Time: 15:16
* Email:cq_liyinsheng@163.com
*/

<template>
    <div class="login">
        <div class="login__container">
            <div class="login__panel">
                <p style="margin: 0;font-size: .5rem;line-height: .8rem">login</p>
                <p>人事管理系统</p>
                <el-form
                        label-position="top"
                        :rules="rules"
                        ref="ruleForm"
                        :model="form"
                >
                    <el-form-item prop="u_account">
                        <el-input class="login__input" placeholder="账号" v-model="form.u_account"></el-input>
                    </el-form-item>
                    <el-form-item prop="u_password">
                        <el-input class="login__input" type="password" placeholder="密码" v-model="form.u_password"></el-input>
                    </el-form-item>
                    <el-button class="login__button" :loading="loginLoading" @click="onSubmit">登录</el-button>
                </el-form>
            </div>
        </div>
        <div class="login__footer">
            <p>推荐使用谷歌、火狐、Chrome内核的浏览器访问。</p>
            <a href="https://www.google.cn/intl/zh-CN/chrome/" target="_blank">点击下载浏览器</a>
        </div>
    </div>
</template>

<script>
import { mapMutations } from 'vuex'
import { mutationTypes } from '@/store.js'
import { loginSYS} from '@/api/login'
export default {
    name: 'Login',
    data(){
        let u_account = (rule, value, callback) => {
            let blank = /[ ]/g // 空格
            const Single = /[\x00-\xff]/g
            if (!Single.test(value)){
                callback(new Error('账号不可含有双字节字符'))
            }else {
                if (blank.test(value)){
                    callback(new Error('账号不可含有空格'))
                } else {
                    callback()
                }
            }
        }
        return{
            form: {
                u_account:'',
                u_password:'',
            },
            rules: {
                u_account: [
                    { required: true, message: '请输入账号', trigger: 'blur' },
                    { validator: u_account, trigger: 'blur' },
                    { max: 15, message: '账号最多15个字符', trigger: 'blur' }
                ],
                u_password: [
                    { required: true, message: '请输入密码', trigger: 'blur' },
                    { min: 5, message: '最少5个字符', trigger: 'blur' }
                ]
            },
            loginLoading:false
        }
    },
    methods: {
        ...mapMutations({
            setUser: mutationTypes.SET_LOGIN
        }),
        /**
         * 登录方法
         */
        onSubmit () {
            this.$refs.ruleForm.validate(async valid => {
                if (valid) {
                    // 登录
                    loginSYS(this.form).then(res=>{
                        if (res.data.success){
                            this.setUser(res.data.data[0])
                            this.$notify.success({
                                title: '登录成功',
                                message: `${res.data.message}`
                            })
                            let url = this.$route.query.navigate
                            if (url!==undefined) {
                                this.$router.push({ path:url})
                            }else {
                                this.$router.push({ path:'/'})
                            }

                        }else {
                            this.$notify.error({
                                title: '登录失败',
                                message: `${res.data.message}`
                            })
                        }

                    }).catch(()=>{
                        this.$notify.error({
                            title: '登陆失败',
                            message: `服务器或网络异常`
                        })
                    })
                }
            })
        }
    },
    mounted(){
        window.addEventListener('keydown',(event)=>{
            if (event.keyCode == "13") {
                this.onSubmit()
            }
        })
    }
}
</script>

<style scoped lang="scss">
    @import '@/assets/styles/flex/flex.scss';
    @import '@/assets/styles/colors/colors.scss';
    .login {
        @include f-cn-sb-s;
        height: 100vh;
        min-width: 1024px;
        overflow: auto;
        background: url("../../assets/images/login_bkg.jpg") no-repeat;
        background-size: cover;

        &__container {
            @include f-rn-fe-c;
            height: 100%;
            box-sizing: border-box;
            padding-right: 1.6rem;
        }

        &__panel {
            @include f-cn-fs-c;
            width: 6rem;
            height: 6rem;
            background: #142f46;
            box-sizing: border-box;
            padding: 0.5rem 0.65rem 0;

            img {
                height: 0.45rem;
            }

            p {
                font-size: 0.6rem;
                letter-spacing: 0.1rem;
                margin: 0.25rem 0;
                background-image: -webkit-gradient(
                                linear,
                                0 0,
                                0 bottom,
                                from(rgba(255, 255, 255, 1)),
                                to(rgba(176, 238, 255, 1))
                );
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            form {
                width: 100%;

                .el-form-item {
                    margin-bottom: 0.35rem;
                }
            }
        }

        /deep/ &__input.el-input {
            input {
                width: 100%;
                height: 0.6rem;
                background: #213a51;
                border-color: #296f7e;
                color: $color-font-gray;
            }
        }

        &__button.el-button {
            width: 100%;
            height: 0.6rem;
            margin-top: 0;
            font-size: 0.24rem !important;
            font-weight: 500;
            color: $color-font-white !important;
            background: #08a3ad !important;
            border-color: #08a3ad !important;

            &:hover {
                background: lighten(#08a3ad, 5%) !important;
            }

            &:active {
                background: darken(#08a3ad, 5%) !important;
            }
        }
        &__footer {
            /*text-align: center;*/
            @include f-rn-c-c;
            height: 0.8rem;
            background: rgba(20, 48, 71, 0.5);
            /*padding-right: .1rem;*/

            p {
                font-size: .18rem;
                color: $color-font-gray;
            }

            a {
                font-size: .18rem;
                color: #3ab4c1;
                text-decoration: none;
            }
        }
    }
</style>
