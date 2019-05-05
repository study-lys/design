/**
* 薪资详情
* Author: liyinsheng
* Date: 2019-01-29
* Time: 15:16
* Email:cq_liyinsheng@163.com
*/
<template>
    <div class="payrollList">
        <!--S 头部-->
        <div class="buttons theme-font">
            <div class="form">
                <div>
                    <span>部门：</span>
                    <el-select
                            v-model="form.d_ids"
                            multiple
                            collapse-tags
                            style="margin-left: 20px;"
                            placeholder="请选择">
                        <el-option
                                v-for="item in departmentList"
                                :key="item.d_id"
                                :label="item.d_name"
                                :value="item.d_id">
                        </el-option>
                    </el-select>
                </div>
                <div>
                    <span>职务：</span>
                    <el-select
                            v-model="form.posts"
                            multiple
                            collapse-tags
                            style="margin-left: 20px;"
                            placeholder="请选择">
                        <el-option
                                v-for="item in postList"
                                :key="item"
                                :label="item"
                                :value="item">
                        </el-option>
                    </el-select>
                </div>
                <div>
                    <span>姓名：</span>
                    <el-input  placeholder="输入员工姓名查询" v-model="form.s_name"></el-input>
                    <el-button type="primary" @click="getList('click')" class="search">搜索</el-button>
                </div>
            </div>
        </div>
        <!--E 头部-->

        <!--S 内容区-->
        <div class="content">
            <el-table
                    :data="tableData"
                    stripe
                    header-row-class-name="theme-table-header"
                    class="theme-table theme-border-checkbox-group"
                    style="width: 100%">
                <el-table-column
                        prop="s_name"
                        show-overflow-tooltip
                        align="center"
                        label="姓名"
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        prop="s_sex"
                        show-overflow-tooltip
                        align="center"
                        label="性别"
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        prop="d_name"
                        align="center"
                        label="部门"
                        show-overflow-tooltip
                        min-width="60%">
                </el-table-column>
                <el-table-column
                        prop="p_name"
                        align="center"
                        show-overflow-tooltip
                        label="职务"
                        min-width="60%">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="p_wage"
                        min-width="60%"
                        show-overflow-tooltip
                        label="月薪(元)">
                </el-table-column>
                <el-table-column
                        align="center"
                        show-overflow-tooltip
                        prop="a_attendance"
                        min-width="60%"
                        label="普通出勤(天)">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="a_vacate"
                        show-overflow-tooltip
                        min-width="60%"
                        label="请假(天)">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="a_overtime"
                        show-overflow-tooltip
                        min-width="60%"
                        label="加班(天)">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="a_specialOvertime"
                        min-width="60%"
                        show-overflow-tooltip
                        label="国假加班(天)">
                </el-table-column>
                <el-table-column
                        align="center"
                        show-overflow-tooltip
                        prop="specialOvertime"
                        min-width="60%"
                        label="应发金额(元)">
                    <template slot-scope="scope">
                        {{ (( parseInt(scope.row.a_attendance) +
                            parseInt(scope.row.a_overtime) * defaultOvertime +
                            parseInt(scope.row.a_specialOvertime) * specialOvertime ) *
                            (scope.row.p_wage/22) ).toFixed(2)
                        }}
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <!--S 内容区-->

        <!--S 分页-->
        <div class="paging">
            <el-pagination
                    background
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-size="pageSise"
                    class="theme-page-bgn theme-page-font"
                    layout="total, prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </div>
        <!--E 分页-->
    </div>
</template>

<script>
    import {getAttendanceList,getPostName,getDepartment} from '@/api/payroll'
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
            return {
                loading:false,
                defaultOvertime:'1.5',// 默认加班费倍数
                specialOvertime:'3',// 特殊加班费倍数
                form:{
                    s_name:'',//姓名
                    d_ids:[],//选择部门
                    posts:[]// 职务名
                },
                saveForm:{
                    s_name:'',//姓名
                    d_ids:[],//选择部门
                    posts:[]// 职务名
                },//保存搜索条件
                currentPage: 1,//当前页
                pageSise:8,//每页大小
                total:0,//总数据数量
                tableData:[],//表格
                addForm:{
                    // department:'',
                    // leader:'',
                    // email:'',
                    // details:''
                },//修改
                setForm:{},//添加、修改表单
                dialogSet:false, //添加、修改弹窗
                isEdit:false,//是否为修改弹框
                postList:[],//职务列表
                departmentList:[],// 部门列表
                //验证规则
                setRules: {
                    department: [
                        { required: true, message: '部门名不能为空' },
                        { validator: department, trigger: 'blur' }
                    ],
                    post: [
                        { required: true, message: '职务不能为空' },
                        // { validator: details, trigger: 'blur' }
                    ],
                    wage: [
                        { required: true, message: '不能为空' },
                        // { validator: details, trigger: 'blur' }
                    ]
                    // todo 缺少验证规则 无网暂搁置
                },
            }
        },
        methods:{
            // 分页
            handleSizeChange() {
            },
            handleCurrentChange(val) {
                this.currentPage =val
                this.getList()
            },
            // 职务薪资添加/修改 diaolog打开
            set(status,value){
                if (status === 'edit'){
                    this.setForm = JSON.parse(JSON.stringify(value))
                    this.departmentList.some(value1 => {
                        if (value1.name === this.setForm.department){
                            this.setForm.department = value1.id
                            return true
                        }
                    })
                }
                this.dialogSet = true
            },
            // 获取考勤列表
            getList(state){
                if (state === 'click'){
                    this.saveForm = JSON.parse(JSON.stringify(this.form))
                    this.currentPage = 1
                }
                // 修改posts数组的格式
                let posts =''
                this.saveForm.posts.forEach((value,index) => {
                    if (index ===0){
                        posts = "'"+value+"'"
                    } else {
                        posts +=","+ "'"+value+"'"
                    }
                })
                let form = {
                    currentPage:this.currentPage,
                    pageSise:this.pageSise,
                    posts:posts,
                    d_ids:this.saveForm.d_ids.join(),
                    s_name:this.saveForm.s_name
                }
                getAttendanceList(form).then(res =>{
                    if (res.data.success){
                        this.total = res.data.total
                        this.tableData = res.data.data
                    }else {
                        this.$notify.error({
                            title: '获取考勤列表失败',
                            message: `服务器或网络异常`
                        })
                    }
                })
            },
            // 获取职务名称列表
            getPostNameList(){
                getPostName().then(res=>{
                    if (res.data.success){
                        this.postList = res.data.data
                    }
                }).catch(()=>{
                    this.$notify.error({
                        title: '获取职务名称列表失败',
                        message: `服务器或网络异常`
                    })
                })
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
        },
        computed: {

        },
        mounted(){
            this.getList()
            this.getPostNameList()
            this.getDepartmentList()
        }
    }
</script>

<style scoped lang="scss">
    @import '@/assets/styles/flex/flex.scss';
    @import '@/assets/styles/colors/colors.scss';
    .payrollList{
        .SetIcon{
            i{
                cursor: pointer;
                margin: 0 .1rem;
            }
        }
        .buttons{
            margin-bottom: .1rem;
            .search{
                margin:0 0rem 0 .2rem ;
            }
            .table-title{
                font-size:.22rem!important;
                font-weight: 500;
                i{
                    cursor: pointer;
                    color: $color-primary;
                    margin-left: .05rem;
                }
            }
            .form{
                @include f-rn-sb-fs;
                *{
                    font-size: .18rem;
                }
                &/deep/.el-input{
                    .el-input__inner{
                        height: .45rem!important;
                        line-height: .45rem!important;
                    }
                    width: 3rem;

                }
                &/deep/.el-button{
                    height: .45rem!important;
                    line-height: .45rem!important;
                    padding: 0 .25rem!important;
                }
                &/deep/.el-select{
                    width: 2.5rem;
                    /*margin: 0 2.1rem 0 .1rem!important;*/
                    *{
                        font-size: .18rem;
                    }
                    .el-tag{
                        margin: .01rem 0 .01rem .06rem;
                        padding: 0 .1rem;
                    }
                    .el-input{
                        width: 2.5rem;
                    }
                    .el-input__icon{
                        line-height: .18rem;
                    }
                }
            }
        }
        .paging{
            @include f-rn-fe-c;
            margin-top: .1rem;
            &/deep/.el-pagination{
                *{
                    font-size: .18rem!important;
                    font-weight: 400;
                }

            }
        }
        &/deep/.el-dialog{
            width: 7rem!important;
        }
        &/deep/.el-form-item__error{
            font-size:.18rem!important;
        }
        &/deep/.el-form-item{
            margin-bottom: .3rem;
        }
        &/deep/.el-form-item__label{
            width: 1.6rem !important;
            font-size: .18rem!important;
        }
        &/deep/.el-form-item__content{
            width: 4.5rem;
            margin-left: 1.6rem !important;
            .el-input__inner{
                font-size: .18rem!important;
            }
            .el-textarea{
                font-size: .18rem!important;
            }
        }
        &/deep/.el-select{
            width: 4.5rem;
        }
        .editBody{
            /*margin: 0 .2rem;*/
        }
    }

</style>
