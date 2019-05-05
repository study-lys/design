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
            <el-form-item label="姓名" prop="s_name">
                <el-input v-model="form.s_name"></el-input>
            </el-form-item>
            <el-form-item label="性别" prop="s_sex">
                <el-radio v-model="form.s_sex" label="男">男</el-radio>
                <el-radio v-model="form.s_sex" label="女">女</el-radio>
            </el-form-item>
            <el-form-item label="生日" prop="s_birthday">
                <el-date-picker
                        v-model="form.s_birthday"
                        type="date"
                        placeholder="年 - 月 - 日"
                        format="yyyy 年 MM 月 dd 日"
                        value-format="yyyy-MM-dd">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="学历" prop="s_education">
                <el-select v-model="form.s_education" placeholder="请选择学历">
                    <el-option
                            v-for="item in educationList"
                            :key="item"
                            :label="item"
                            :value="item">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="电话" prop="s_phone">
                <el-input type="number" v-model="form.s_phone"></el-input>
            </el-form-item>
            <el-form-item label="邮箱" prop="s_email">
                <el-input v-model="form.s_email"></el-input>
            </el-form-item>


            <el-form-item label="所在部门" prop="d_id">
                <el-select @change="deparmentChange()" v-model="form.d_id" placeholder="请选择部门">
                    <el-option
                            v-for="item in departmentList"
                            :key="item.d_id"
                            :label="item.d_name"
                            :value="item.d_id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="职务" prop="p_id">
                <!--jobList-->
                <el-select v-model="form.p_id" placeholder="请选择职务">
                    <el-option
                            v-for="item in jobList"
                            :key="item.p_id"
                            :label="item.p_name"
                            :value="item.p_id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="入职日期" prop="s_startTime">
                <el-date-picker
                        v-model="form.s_startTime"
                        type="date"
                        placeholder="年 - 月 - 日"
                        format="yyyy 年 MM 月 dd 日"
                        value-format="yyyy-MM-dd">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="婚姻状况" prop="s_maritalStatus">
                <el-select v-model="form.s_maritalStatus" placeholder="请选择婚姻状况">
                    <el-option
                            v-for="item in ['未婚','已婚']"
                            :key="item"
                            :label="item"
                            :value="item">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="民族" prop="s_nation">
                <el-input v-model="form.s_nation"></el-input>
            </el-form-item>
            <el-form-item label="籍贯" prop="s_nativePlace">
                <el-input v-model="form.s_nativePlace"></el-input>
            </el-form-item>
            <el-form-item label="所在地" prop="s_location">
                <el-input v-model="form.s_location"></el-input>
            </el-form-item>
            <el-form-item label="身高(CM)" prop="s_stature">
                <el-input type="number" v-model="form.s_stature"></el-input>
            </el-form-item>
            <el-form-item label="体重(KG)" prop="s_weight">
                <el-input type="number" v-model="form.s_weight"></el-input>
            </el-form-item>
            <el-form-item label="身份证号码" prop="s_idNumber">
                <el-input v-model="form.s_idNumber"></el-input>
            </el-form-item>
            <el-form-item label="掌握技能" prop="s_skill">
                <el-input type="textarea" v-model="form.s_skill"></el-input>
            </el-form-item>
            <el-form-item label="政治面貌" prop="s_politicsStatus">
                <el-input v-model="form.s_politicsStatus"></el-input>
            </el-form-item>
            <el-form-item  label=" ">
                <div class="submit">

                    <div v-if="isEdit === false">
                        <el-button type="primary" @click="add()">立即创建</el-button>
                        <el-button class="reset" @click="reset()">重置</el-button>
                    </div>
                    <div v-if="isEdit === true">
                        <el-button @click="editStaff()" type="primary">立即修改</el-button>
                        <router-link to="/staff/staffList">
                            <el-input class="reset" type="button" value="返回"></el-input>
                        </router-link>
                    </div>
                </div>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
import {getDepartment,getList} from '@/api/payroll'
import {addStaff,edit,getDetail} from '@/api/staff'
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
        let chinese = (rule, value, callback) => {
            const reg=/[\u4e00-\u9fa5]/  //中文
            if (value){
                if (!reg.test(value)){
                    callback(new Error('必须为中文'))
                }else {
                    callback()
                }
            } else {
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
        let idNumber = (rule, value, callback) => {
            const reg=/^([0-9]){7,18}(x|X)?$ 或 ^\d{8,18}|[0-9x]{8,18}|[0-9X]{8,18}?$/  //身份证
            if (!reg.test(value)){
                callback(new Error('身份证号码格式错误'))
            }else {
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
        return {
            form:{
                s_name:'',
                s_sex:'男',
                s_birthday:'',
                s_phone:'',
                s_education:'',
                s_email:'',
                p_id:'',
                d_id:'',
                s_startTime:'',
                s_maritalStatus:'',
                s_nation:'',
                s_nativePlace:'',
                s_location:'',
                s_stature:'',
                s_weight:'',
                s_idNumber:'',
                s_skill:'',
                s_politicsStatus:''
            },
            //验证规则
            rules: {
                s_name: [
                    { required: true, message: '姓名不能为空' },
                    { validator: noSpecial, trigger: 'blur' }
                ],
                s_sex: [
                    { required: true, message: '性别不能为空' }
                ],
                s_birthday: [
                    { required: true, message: '生日不能为空' }
                ],
                s_education: [
                    { required: true, message: '学历不能为空' }
                ],
                s_phone: [
                    { validator: phone, trigger: 'blur' }
                ],
                s_email: [
                    { validator: email, trigger: 'blur' }
                ],
                d_id: [
                    { required: true, message: '部门名不能为空' }
                ],
                p_id: [
                    { required: true, message: '职务不能为空' }
                ],
                s_startTime: [
                    { required: true, message: '入职时间不能为空' }
                ],
                s_nation: [
                    { validator: chinese, trigger: 'blur' }
                ],
                s_nativePlace:[
                    { validator: chinese, trigger: 'blur' }
                ],
                s_location:[
                    { validator: chinese, trigger: 'blur' }
                ],
                s_idNumber:[
                    { required: true, message: '身份证号码不能为空' },
                    { validator: idNumber, trigger: 'blur' }
                ],
                s_skill:[
                    { validator: noSpecial, trigger: 'blur' }
                ],
                s_politicsStatus:[
                    { validator: chinese, trigger: 'blur' }
                ]
            },
            educationList:['小学','初中','高中','专科','本科','硕士','博士'],//学历列表
            departmentList:[],//部门列表
            jobList:[],//职务列表
            isEdit:false //是否为修改页面
        }
    },
    methods:{
        reset(){
            this.$refs.form.resetFields()
        },
        // 获取部门列表
        getDepartmentList(){
            getDepartment().then(res=>{
                if (res.data.success){
                    this.departmentList = res.data.data
                }
            }).catch(()=>{
                this.$notify.error({
                    title: '获取部门列表失败',
                    message: `服务器或网络异常`
                })
            })
            // todo 重写一个不分页的获取部门接口
            // this.departmentList
        },
        // 获取职务列表
        getPostList(d_id){
            getList({d_id:d_id}).then(res=>{
                if (res.data.success){
                    this.jobList = res.data.data
                }
            }).catch(()=>{
                this.$notify.error({
                    title: '获取职务列表失败',
                    message: `服务器或网络异常`
                })
            })
        },
        // 添加员工
        add(){
            this.$refs.form.validate((valid) => {
                if (valid){
                    let form = {
                        s_name:this.form.s_name,
                        s_sex:this.form.s_sex,
                        s_birthday:this.form.s_birthday,
                        s_phone:this.form.s_phone,
                        s_education:this.form.s_education,
                        s_email:this.form.s_email,
                        d_id:this.form.d_id,
                        p_id:this.form.p_id,
                        s_startTime:this.form.s_startTime,
                        s_maritalStatus:this.form.s_maritalStatus,
                        s_nation:this.form.s_nation,
                        s_nativePlace:this.form.s_nativePlace,
                        s_location:this.form.s_location,
                        s_stature:this.form.s_stature,
                        s_weight:this.form.s_weight,
                        s_idNumber:this.form.s_idNumber,
                        s_skill:this.form.s_skill,
                        s_politicsStatus:this.form.s_politicsStatus
                    }
                    addStaff(form).then(res=>{
                        if (res.data.success){
                            this.$message({
                                type: 'success',
                                message: '员工添加成功'
                            })
                        }else {
                            this.$notify.error({
                                title: '员工添加失败',
                                message: `${res.data.message}`
                            })
                        }
                    }).catch(()=>{
                        this.$notify.error({
                            title: '员工添加失败',
                            message: `服务器或网络异常`
                        })
                    })
                }
            })
        },
        // 部门选中切换
        deparmentChange(){
            this.getPostList(this.form.d_id)
            this.form.p_id = ''
        },

        // 修改员工
        editStaff(){
            this.$refs.form.validate((valid) => {
                if (valid){
                    let form = {
                        s_id:this.form.s_id,
                        s_name:this.form.s_name,
                        s_sex:this.form.s_sex,
                        s_birthday:this.form.s_birthday,
                        s_phone:this.form.s_phone,
                        s_education:this.form.s_education,
                        s_email:this.form.s_email,
                        d_id:this.form.d_id,
                        p_id:this.form.p_id,
                        s_startTime:this.form.s_startTime,
                        s_maritalStatus:this.form.s_maritalStatus,
                        s_nation:this.form.s_nation,
                        s_nativePlace:this.form.s_nativePlace,
                        s_location:this.form.s_location,
                        s_stature:this.form.s_stature,
                        s_weight:this.form.s_weight,
                        s_idNumber:this.form.s_idNumber,
                        s_skill:this.form.s_skill,
                        s_politicsStatus:this.form.s_politicsStatus
                    }
                    edit(form).then(res=>{
                        if (res.data.success){
                            this.$message({
                                type: 'success',
                                message: '员工修改成功'
                            })
                            this.getStaff(this.$route.query.id)
                        }else {
                            this.$notify.error({
                                title: '员工修改失败',
                                message: `${res.data.message}`
                            })
                        }
                    }).catch(()=>{
                        this.$notify.error({
                            title: '员工修改失败',
                            message: `服务器或网络异常`
                        })
                    })
                }
            })
        },
        // 获取员工详情
        getStaff(id){
            getDetail({s_id:id}).then(res=>{
                if (res.data.success){
                    this.getPostList(res.data.data[0].d_id)
                    this.form = res.data.data[0]
                }else {
                    this.$notify.error({
                        title: '获取员工详情失败',
                        message: `${res.data.message}`
                    })

                }
            }).catch(()=>{
                this.$notify.error({
                    title: '获取员工详情失败',
                    message: `服务器或网络异常`
                })

            })
        }
    },
    computed: {

    },
    watch: {
        $route: {
            immediate: true,
            handler: function (/*val, oldVal*/) {
                if (this.$route.query.id){
                    // console.log(this.$route.query.id)
                    this.isEdit = true
                    // todo 根据传过来的用户ID查询员工详情
                    this.getStaff(this.$route.query.id)
                }else {
                    this.isEdit = false
                }

            }
        }
    },
    mounted(){
        this.getDepartmentList()
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
