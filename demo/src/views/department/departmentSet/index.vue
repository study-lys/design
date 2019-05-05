/**
* 部门设置（添加修改）
* Author: liyinsheng
* Date: 2019-01-29
* Time: 15:16
* Email:cq_liyinsheng@163.com
*/
<template>
    <div class="departmentSet">
        <el-form ref="form" :model="form" :rules="rules">
            <el-form-item label="部门名称" prop="d_name">
                <el-input v-model="form.d_name"></el-input>
            </el-form-item>
            <el-form-item label="部门简介" prop="d_details">
                <el-input type="textarea" v-model="form.d_details"></el-input>
            </el-form-item>
            <el-form-item>
                <div class="submit">
                    <el-button type="primary" @click="submitForm()">立即创建</el-button>
                    <el-button class="reset" @click="reset()">重置</el-button>
                </div>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
import {add} from '@/api/department'
export default {
    name: 'Index',
    data () {
        let department = (rule, value, callback) => {
            const reg=/^[\u4E00-\u9FA5A-Za-z0-9_]+$/  //中文、英文、数字包括下划线
            const double = /[^\x00-\xff]/g
            const Single = /[\x00-\xff]/g
            if (!reg.test(value)){
                callback(new Error('部门名不可含有下划线以外特殊字符'))
            }else {
                const doubleByte = value.match(double) ? value.match(double).length : 0
                const SingleByte = value.match(Single) ? value.match(Single).length : 0
                let total = doubleByte * 2 + SingleByte
                if (total > 16) {
                    callback(new Error('部门名不可大于16个字符'))
                } else {
                    callback()
                }
            }
        }
        let details = (rule, value, callback) => {
            const reg=/^[\u4E00-\u9FA5A-Za-z0-9_]+$/  //中文、英文、数字包括下划线
            const double = /[^\x00-\xff]/g
            const Single = /[\x00-\xff]/g
            if (value){
                if (!reg.test(value)){
                    callback(new Error('部门详情不可含有下划线以外特殊字符'))
                }else {
                    const doubleByte = value.match(double) ? value.match(double).length : 0
                    const SingleByte = value.match(Single) ? value.match(Single).length : 0
                    let total = doubleByte * 2 + SingleByte
                    if (total > 100) {
                        callback(new Error('部门详情不可超过100个字符'))
                    } else {
                        callback()
                    }
                }
            }else {
                callback()
            }
        }
        return {
            form:{},
            //验证规则
            rules: {
                d_name: [
                    { required: true, message: '部门名不能为空' },
                    { validator: department, trigger: 'blur' }
                ],
                d_details: [
                    { validator: details, trigger: 'blur' }
                ]
            }
        }
    },
    methods:{
        reset(){
            this.$refs.form.resetFields()
        },
        submitForm(){
            this.$refs.form.validate((valid) => {
                if (valid) {
                    add(this.form).then(res=>{
                        if (res.data.success){
                            this.$notify.success({
                                title: '添加部门成功',
                                message: `${res.data.message}`
                            })
                        }else {
                            this.$notify.error({
                                title: '添加部门失败',
                                message: `${res.data.message}`
                            })
                        }
                    }).catch(()=>{
                        this.$notify.error({
                            title: '添加部门失败',
                            message: '服务器或网络异常'
                        })
                    })
                }
            })
        }
    },
    computed: {

    }
}
</script>

<style scoped lang="scss">
@import '@/assets/styles/flex/flex.scss';
.departmentSet{
    &/deep/.el-form{
        .el-form-item{
            margin-bottom: .25rem!important;
        }
        .el-form-item__label{
            font-size: .18rem!important;
            width: 1.5rem!important;
            line-height: .55rem;
        }
        .el-form-item__content{
            margin-left: 1.5rem!important;
            width: 13rem!important;
            line-height: .55rem;
            .el-input__inner{
                font-size: .18rem!important;
                height: .55rem;
            }
        }
        textarea{
            height: 2.5rem;
            font-size: .18rem;
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
        .el-form-item__error{
            font-size: .18rem;
            padding-top: .05rem;
            line-height: .18rem;
        }
    }
}
</style>
