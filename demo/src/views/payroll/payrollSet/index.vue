/**
* 职位薪资
* Author: liyinsheng
* Date: 2019-01-29
* Time: 15:16
* Email:cq_liyinsheng@163.com
*/
<template>
    <div class="payrollSet">
        <!--S 头部-->
        <div class="buttons theme-font">
            <div class="table-title">
                <span>薪资设置</span>
                <i class="el-icon-circle-plus-outline" title="添加职位薪资" @click="set()"></i>
            </div>
            <div class="form">
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
                <el-button type="primary" @click="getPosts('click')" class="search">搜索</el-button>
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
                        prop="p_id"
                        align="center"
                        label="id"
                        show-overflow-tooltip
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        prop="d_name"
                        align="center"
                        show-overflow-tooltip
                        label="部门"
                        min-width="60%">
                </el-table-column>
                <el-table-column
                        prop="p_name"
                        align="center"
                        show-overflow-tooltip
                        label="职务"
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="p_wage"
                        show-overflow-tooltip
                        min-width="60%"
                        label="月薪(元)">
                </el-table-column>
                <el-table-column
                        align="center"
                        min-width="40%"
                        label="操作">
                    <template slot-scope="scope">
                        <div class="SetIcon">
                            <i class="el-icon-edit-outline" @click="set('edit',scope.row)" title="修改"></i>
                            <i class="el-icon-delete" @click="del(scope.row.p_id)" title="删除"></i>
                        </div>
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

        <!--S dialog-->
        <div>
            <el-dialog
                    :title="isEdit? '修改职务':'添加职务'"
                    :visible.sync="dialogSet">
                <div class="editBody">
                    <el-form ref="form" :model="setForm"
                             :rules="setRules">
                        <el-form-item label="部门" prop="d_id">
                            <el-select
                                    v-model="setForm.d_id">
                                <el-option
                                        v-for="item in departmentList"
                                        :key="item.d_id"
                                        :label="item.d_name"
                                        :value="item.d_id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="职务" prop="p_name">
                            <el-input v-model="setForm.p_name"></el-input>
                        </el-form-item>
                        <el-form-item label="月薪" prop="p_wage">
                            <el-input v-model="setForm.p_wage"></el-input>
                        </el-form-item>
                    </el-form>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogSet = false">取 消</el-button>
                    <el-button v-if="isEdit!==true" type="primary" @click="add()">确 定</el-button>
                    <el-button v-if="isEdit===true" type="primary" @click="edit()">确 定</el-button>
                </span>
            </el-dialog>
        </div>
        <!--E dialog-->
    </div>
</template>

<script>
    import {getPostName,getDepartment,getPostList,deletePost,editPost,addPost} from '@/api/payroll'
    export default {
        name: 'Index',
        data () {
            return {
                loading:false,
                form:{
                    d_ids:[],//选择部门
                    posts:[]// 职务名
                },
                saveForm:{
                    d_ids:[],//选择部门
                    posts:[]// 职务名
                },//保存搜索后的条件
                currentPage: 1,//当前页
                pageSise:8,//每页大小
                total:0,//总数据数量
                tableData:[
                    {
                        id:1,
                        department:'研发部',
                        post:'项目经理',
                        wage:'4000',
                    },
                    {
                        id:1,
                        name:'张三',
                        sex:'男',
                        department:'研发部',
                        post:'项目经理',
                        phone:'13389625778',
                        email:'1071645772@qq.com',
                    },
                    {
                        id:1,
                        name:'张三',
                        sex:'男',
                        department:'研发部',
                        post:'项目经理',
                        phone:'13389625778',
                        email:'1071645772@qq.com',
                    },
                    {
                        id:1,
                        name:'张三',
                        sex:'男',
                        department:'研发部',
                        post:'项目经理',
                        phone:'13389625778',
                        email:'1071645772@qq.com',
                    }
                ],//表格
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
                    d_id: [
                        { required: true, message: '部门名不能为空' }
                    ],
                    p_name: [
                        { required: true, message: '职务不能为空' },
                    ],
                    p_wage: [
                        { required: true, message: '不能为空' },
                    ]
                    // todo 缺少验证规则 无网暂搁置
                },
            }
        },
        methods:{
            // 分页
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                this.currentPage =val
                this.getPosts()
            },
            // 职务薪资添加/修改 diaolog打开
            set(status,value){
                if (status === 'edit'){
                    this.setForm = JSON.parse(JSON.stringify(value))
                    this.isEdit = true
                }else {
                    this.isEdit = false
                }
                this.dialogSet = true
            },
            // 删除
            del(id){
                this.$confirm('确认删除该职务薪资？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    dangerouslyUseHTMLString: true,
                    type: 'warning',
                }).then(()=>{
                    let form = {
                        p_id:id
                    }
                    deletePost(form).then(res=>{
                        if (res.data.success){
                            this.getPosts()
                        }else {
                            this.$notify.error({
                                title: '职务删除失败',
                                message: `${res.data.message}`
                            })
                        }
                    }).catch(()=>{
                        this.$notify.error({
                            title: '职务删除失败',
                            message: `服务器或网络异常`
                        })
                    })
                }).catch(()=>{
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                })
            },
            edit(){
                this.$refs.form.validate((valid) => {
                    if (valid){
                        let form = {
                            p_id: this.setForm.p_id,
                            d_id: this.setForm.d_id,
                            p_wage: this.setForm.p_wage,
                            p_name: this.setForm.p_name,
                        }
                        editPost(form).then(res=>{
                            if (res.data.success){
                                this.getPosts()
                                this.dialogSet = false
                                this.$message({
                                    type: 'success',
                                    message: '职务修改成功'
                                })
                            }else {
                                this.$notify.error({
                                    title: '职务修改失败',
                                    message: `${res.data.message}`
                                })
                            }
                        }).catch(()=>{
                            this.$notify.error({
                                title: '职务修改失败',
                                message: `服务器或网络异常`
                            })
                        })
                    }
                })
            },
            add(){
                this.$refs.form.validate((valid) => {
                    if (valid){
                        let form = {
                            d_id: this.setForm.d_id,
                            p_wage: this.setForm.p_wage,
                            p_name: this.setForm.p_name,
                        }
                        addPost(form).then(res=>{
                            if (res.data.success){
                                this.getPosts()
                                this.$message({
                                    type: 'success',
                                    message: '职务添加成功'
                                })
                                this.dialogSet = false
                            }else {
                                this.$notify.error({
                                    title: '职务添加失败',
                                    message: `${res.data.message}`
                                })
                            }
                        }).catch(()=>{
                            this.$notify.error({
                                title: '职务添加失败',
                                message: `服务器或网络异常`
                            })
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
            // 获取职务列表
            getPosts(state){
                if (state === "click"){
                    this.currentPage =1
                    this.saveForm = JSON.parse(JSON.stringify(this.form))
                }
                let posts =''
                // 修改posts数组的格式
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
                    d_ids:this.saveForm.d_ids.join()
                }
                getPostList(form).then(res=>{
                   if (res.data.success){
                       this.tableData = res.data.data
                       this.total =res.data.total
                   }
                }).catch(()=>{
                    this.$notify.error({
                        title: '获取职务列表失败',
                        message: `服务器或网络异常`
                    })
                })
            }
        },
        mounted(){
            this.getPostNameList()
            this.getDepartmentList()
            this.getPosts()
        },
        computed:{
        }
    }
</script>

<style scoped lang="scss">
    @import '@/assets/styles/flex/flex.scss';
    @import '@/assets/styles/colors/colors.scss';
    .payrollSet{
        .SetIcon{
            i{
                cursor: pointer;
                margin: 0 .1rem;
            }
        }
        .buttons{
            @include f-rn-sb-c;
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
                    margin: 0 2.5rem 0 .1rem!important;
                    &:nth-last-of-type(1){
                        margin-right: 0!important;
                    }
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
