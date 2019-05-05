/**
* 添加员工
* Author: liyinsheng
* Date: 2019-01-29
* Time: 15:16
* Email:cq_liyinsheng@163.com
*/
<template>
    <div class="staffSet">
        <el-form  :inline="true" ref="form" :model="form" :rules="rules">
            <el-form-item label="账号" prop="u_account">
                <el-input :disabled="isEdit === true" v-model="form.u_account"></el-input>
            </el-form-item>
            <el-form-item label="账号类型" prop="u_type">
                <el-radio :disabled="user.u_type !== '超级管理员'" v-model="form.u_type" label="管理员">管理员</el-radio>
                <el-radio :disabled="user.u_type !== '超级管理员'" v-model="form.u_type" label="超级管理员">超级管理员</el-radio>
            </el-form-item>
            <el-form-item v-if="isEdit === false" label="密码" prop="u_password">
                <el-input type="password" v-model="form.u_password"></el-input>
            </el-form-item>
            <el-form-item v-if="isEdit === false" label="确认密码" prop="confirmPWD">
                <el-input type="password" v-model="form.confirmPWD"></el-input>
            </el-form-item>
            <el-form-item v-if="isEdit === true" label="旧密码" prop="oldPWD">
                <el-input type="password" v-model="form.oldPWD"></el-input>
            </el-form-item>
            <el-form-item v-if="isEdit === true" label="新密码" prop="newPWD">
                <el-input type="password" v-model="form.newPWD"></el-input>
            </el-form-item>
            <el-form-item label="姓名" prop="u_name">
                <el-input v-model="form.u_name"></el-input>
            </el-form-item>
            <el-form-item label="性别" prop="u_sex">
                <el-radio v-model="form.u_sex" label="男">男</el-radio>
                <el-radio v-model="form.u_sex" label="女">女</el-radio>
            </el-form-item>
            <el-form-item label="电话" prop="u_phone">
                <el-input v-model="form.u_phone"></el-input>
            </el-form-item>
            <el-form-item label="邮箱" prop="u_email">
                <el-input v-model="form.u_email"></el-input>
            </el-form-item>
            <el-form-item  label=" ">
                <div class="submit">
                    <div v-if="isEdit === false">
                        <el-button @click="userAdd()" type="primary" :disabled="user.u_type !=='超级管理员'">立即创建</el-button>
                        <el-button class="reset" @click="reset()">重置</el-button>
                    </div>
                    <div v-if="isEdit === true">
                        <el-button type="primary" @click="userEdit()">立即修改</el-button>
                        <router-link to="/user/userList">
                            <el-input class="reset" type="button" value="返回"></el-input>
                        </router-link>
                    </div>
                </div>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
import { mapState,mapMutations } from 'vuex'
import { mutationTypes } from '@/store.js'
import {getUserDetails,editUser,addUser} from '@/api/user'
export default {
    name: 'Index',
    data () {
        let noSpecial = (rule, value, callback) => {
            const reg=/^[\u4E00-\u9FA5A-Za-z0-9_]+$/  //中文、英文、数字包括下划线
            if (value !== ''){
                if (!reg.test(value)){
                    callback(new Error('不可含有下划线以外的特殊字符'))
                }else {
                    callback()
                }
            } else {
                callback()
            }
        }
        let account = (rule, value, callback) => {
            const Single = /[\x00-\xff]/g
            const blank = /[ ]/g
            if (!Single.test(value)) {
                callback(new Error('账号不可含有双字节字符'))
            }else if (blank.test(value)){
                callback(new Error('账号不可含有空格'))
            }else {
                callback()
            }
        }
        let phone = (rule, value, callback) => {
            const reg=/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/  //电话号码
            if (value){
                if (!reg.test(value)){
                    callback(new Error('手机号格式错误'))
                }else {
                    callback()
                }
            } else {
                callback()
            }
        }
        let email = (rule, value, callback) => {
            const reg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/  //邮箱
            if (value){
                if (!reg.test(value)){
                    callback(new Error('邮箱格式错误'))
                }else {
                    callback()
                }
            } else {
                callback()
            }
        }
        let confirmPWD = (rule, value, callback) => {
            if (this.form.u_password !== value){
                callback(new Error('两次密码输入不一致'))
            }else {
                callback()
            }
        }
        let oldPWD = (rule, value, callback) => {
            if (value!=='' && value!==undefined){
                if (this.form.newPWD === ''|| this.form.newPWD === undefined){
                    callback(new Error('新密码不能为空'))
                }else {
                    callback()
                }
            }else {
                callback()
            }
        }
        let newPWD = (rule, value, callback) => {
            if (value!=='' && value!==undefined){
                if (this.form.oldPWD ==='' || this.form.oldPWD === undefined){
                    callback(new Error('旧密码不能为空'))
                }else {
                    callback()
                }
            }else {
                callback()
            }
        }
        return {
            form:{
                u_account:'',
                u_type:'管理员',
                u_password:'',
                confirmPWD:'',
                u_name:'',
                u_sex:'男',
                u_phone:'',
                u_email:'',
                newPWD:'',
                oldPWD:''
            },
            isEdit:false,
            /**
            * 验证规则
            */
            rules: {
                u_name: [
                    { required: true, message: '姓名不能为空' },
                    { validator: noSpecial, trigger: 'blur' }
                ],
                u_sex: [
                    { required: true, message: '性别不能为空' }
                ],
                u_account: [
                    { required: true, message: '账号不能为空' },
                    { validator: account, trigger: 'blur' },
                    { min: 5, message: '账号长度至少5个字符', trigger: 'blur' }
                ],
                u_type: [
                    { required: true, message: '账号类型不能为空' }
                ],
                u_password: [
                    { required: true, message: '密码不能为空' },
                    { min: 5, message: '密码长度至少5个字符', trigger: 'blur' }
                ],
                u_email: [
                    { validator: email, trigger: 'blur' }
                ],
                oldPWD: [
                    { validator:oldPWD, trigger: 'blur' }
                ],
                newPWD: [
                    { validator: newPWD, trigger: 'blur' }
                ],
                confirmPWD: [
                    { required: true, message: '确认密码不能为空' },
                    { validator: confirmPWD, trigger: 'blur' }
                ],
                u_phone: [
                    { validator: phone, trigger: 'blur' }
                ]
            }
        }
    },
    methods:{
        ...mapMutations({
            setUser: mutationTypes.SET_LOGIN,
        }),
        reset(){
            this.$refs.form.resetFields()
        },
        userEdit(){
            this.$refs.form.validate((valid) => {
                if (valid) {
                    let form ={
                        u_id:this.form.u_id,
                        u_name:this.form.u_name,
                        u_oldPWD:this.form.oldPWD,
                        u_newPWD:this.form.newPWD,
                        u_type:this.form.u_type,
                        u_sex:this.form.u_sex,
                        u_phone:this.form.u_phone,
                        u_email:this.form.u_email,
                    }
                    editUser(form).then(res=>{
                        if (res.data.success){
                            this.$message({
                                type: 'success',
                                message: `${res.data.message}`
                            })
                            if (parseInt(this.$route.query.u_id) ===parseInt(this.user.u_id)){
                                getUserDetails({u_id:this.user.u_id}).then(res=>{
                                    if (res.data.success){
                                        this.setUser(res.data.data[0])
                                    }
                                })
                            }
                        } else {
                            this.$notify.error({
                                title: '修改用户信息失败',
                                message: `${res.data.message}`
                            })
                        }
                    })
                }
            })
        },

        userAdd(){
            this.$refs.form.validate((valid) => {
                if (valid) {
                    let form ={
                        u_account:this.form.u_account,
                        u_name:this.form.u_name,
                        u_password:this.form.u_password,
                        u_type:this.form.u_type,
                        u_sex:this.form.u_sex,
                        u_phone:this.form.u_phone,
                        u_email:this.form.u_email,
                    }
                    addUser(form).then(res=>{

                        if (res.data.success){
                            console.log(res)
                            this.$message({
                                type: 'success',
                                message: `${res.data.message}`
                            })
                        } else {
                            this.$notify.error({
                                title: '添加用户失败',
                                message: `${res.data.message}`
                            })
                        }
                    })
                }
            })
        }

    },
    watch: {
        $route: {
            immediate: true,
            handler: function (/*val, oldVal*/) {
                if (this.$route.query.u_id){
                    this.isEdit = true
                    getUserDetails({u_id:this.$route.query.u_id}).then(res=>{
                        if (res.data.success){
                            this.form = res.data.data[0]
                        }else {
                            this.$notify.error({
                                title: '获取用户信息失败',
                                message: `${res.data.message}`
                            })
                        }
                    }).catch(()=>{
                        this.$notify.error({
                            title: '获取用户信息失败',
                            message: `服务器或网络异常`
                        })
                    })
                }else {
                    this.isEdit = false
                    this.$nextTick(() => {
                        this.reset()
                    })
                }

            }
        }
    },
    computed: {
        ...mapState(['user'])
    }
}
</script>

<style scoped lang="scss">
@import '@/assets/styles/flex/flex.scss';
.staffSet{
    &/deep/.el-form{
        .el-form-item__error{
            font-size: .18rem;
            padding-top: .05rem;
            line-height: .18rem;
        }
        .el-form-item{
            margin-bottom: .25rem!important;
            &:nth-of-type(2n){
                margin-left: 1rem;
            }
        }
        .el-form-item__label{
            font-size: .18rem!important;
            width: 1.8rem!important;
            line-height: .55rem;
        }
        .el-form-item__content,
        .el-select,
        .el-date-editor.el-input,
        .el-date-picker{
            width: 4rem!important;
            line-height: .55rem;
            .el-input__inner{
                height: .55rem;
            }
            &__header{
                margin: .1rem;
                *{
                    font-size: .22rem!important;
                }
                width: 3.8rem;
            }
            .el-picker-panel__content{
                width: 3.6rem!important;
                margin: .2rem;
                *{
                    font-size: .18rem!important;
                }
            }
        }
        .el-input__icon{
            line-height: .55rem;
        }
        textarea{
            height: .95rem;
        }
        .submit{
            @include f-rn-fs-cs;
            .reset{
                width: .9rem;
                height: .4rem!important;
                line-height: 0;
                .el-input__inner{
                    padding: 0!important;
                    height: .4rem;
                    line-height: .4rem;
                    font-size: .18rem!important;
                }
            }
            .el-button{
                font-size: .18rem;
                margin-right: .2rem;
                height: .4rem!important;
            }
        }
        *{
            font-size: .18rem;
        }
    }

}
</style>
