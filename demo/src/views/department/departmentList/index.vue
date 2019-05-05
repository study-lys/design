/**
* 部门列表
* Author: liyinsheng
* Date: 2019-01-29
* Time: 15:16
* Email:cq_liyinsheng@163.com
*/
<template>
    <div class="departmentList">
        <!--S 内容区-->
        <div class="buttons">
            <el-button type="primary" @click="delBatch()">批量删除</el-button>
            <div>
                <el-input  placeholder="输入部门名称查询" v-model="search"></el-input>
                <el-button type="primary" class="search" @click="getlist('click')">搜索</el-button>
            </div>
        </div>
        <div class="content">
            <el-table
                    :data="tableData"
                    stripe
                    @selection-change="handleSelectionChange"
                    header-row-class-name="theme-table-header"
                    class="theme-table theme-border-checkbox-group"
                    style="width: 100%">
                <el-table-column
                        type="selection"
                        min-width="18.6%">
                </el-table-column>
                <el-table-column
                        prop="id"
                        align="center"
                        label="部门ID"
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        prop="d_name"
                        align="center"
                        label="部门名称"
                        min-width="60%">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="s_name"
                        min-width="60%"
                        label="部门负责人">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="s_email"
                        show-overflow-tooltip
                        label="负责人邮箱">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="d_details"
                        show-overflow-tooltip
                        label="部门简介">
                </el-table-column>
                <el-table-column
                        align="center"
                        min-width="40%"
                        label="操作">
                    <template slot-scope="scope">
                        <div class="SetIcon">
                            <i class="el-icon-edit-outline" title="修改" @click="edit('edit',scope.row)"></i>
                            <i class="el-icon-delete" @click="del(scope.row.id)" title="删除"></i>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <div class="paging">
            <el-pagination
                    background
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-size="pageSise"
                    class="theme-page-bgn theme-page-font"
                    layout="total, prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </div>
        <!--E 内容区-->

        <!--S dialog-->
        <div>
            <el-dialog
                    title="修改部门"
                    :visible.sync="dialogEdit">
                <div class="editBody">
                    <el-form ref="form" :model="addForm"
                             :rules="editRules">
                        <el-form-item label="部门名称" prop="d_name">
                            <el-input v-model="addForm.d_name"></el-input>
                        </el-form-item>
                        <el-form-item label="部门负责人">
                            <el-select
                                    v-model="addForm.s_id"
                                    filterable
                                    placeholder="请输入负责人名字模糊搜索">
                                <el-option
                                        v-for="item in staff"
                                        :key="item.s_id"
                                        :change="changeLeader()"
                                        :label="item.s_name"
                                        :value="item.s_id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="负责人邮箱" prop="s_email">
                            <el-input disabled v-model="addForm.s_email"></el-input>
                        </el-form-item>
                        <el-form-item label="部门简介" prop="d_details">
                            <el-input type="textarea" v-model="addForm.d_details"></el-input>
                        </el-form-item>
                    </el-form>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogEdit = false">取 消</el-button>
                    <el-button type="primary" @click="edit('submit')">确 定</el-button>
                </span>
            </el-dialog>
        </div>
        <!--E dialog-->
    </div>
</template>

<script>
import {getList, edits, del, batchDelete,getStaff} from '@/api/department'
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
        let email = (rule, value, callback) => {
           const reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
           if (value){
               if (reg.test(value)) {
                   callback()
               }else {
                   callback(new Error('邮箱格式错误'))
               }
           } else {
               callback()
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
            loading:false,
            currentPage: 1,//当前页
            pageSise:8,//每页大小
            total:0,//总数据数量
            dialogEdit:false,
            search:'',//搜索框
            saveSearch:'',//保存搜索内容
            tableData:[],
            addForm:'',//修改表单
            //验证规则
            editRules: {
                d_name: [
                    { required: true, message: '部门名不能为空' },
                    { validator: department, trigger: 'blur' }
                ],
                s_email: [
                    { validator: email, trigger: 'blur' },
                    { min: 0, max: 20, message: '邮箱长度为20字符以内', trigger: 'blur' },
                ],
                d_details: [
                    { validator: details, trigger: 'blur' }
                ]
            },
            // 部门员工
            staff:[],
            selection:[]//批量选择
        }
    },
    methods:{
        // 批量操作-选择
        handleSelectionChange(val) {
            this.selection = val
        },
        handleCurrentChange(val) {
            this.currentPage = val
            this.getlist()
        },
        changeLeader(){
            if (this.addForm !==''){
                this.staff.some(value => {
                    value.s_id === this.addForm.s_id ? this.addForm.s_email = value.s_email:''
                })
            }
        },
        // 修改部门
        edit(state,value){
            if (state === 'edit'){
                // 打开
                this.dialogEdit = true
                this.addForm = JSON.parse(JSON.stringify(value))
                getStaff({id:this.addForm.id})
                    .then(res=>{
                        this.staff = res.data.data
                    })
            } else {
                // 保存
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        let form =JSON.parse(JSON.stringify(this.addForm))
                        form.d_id = form.id
                        edits(form)
                            .then(res=>{
                                if (res.data.success){
                                    this.$message({
                                        type: 'success',
                                        message: '修改部门成功'
                                    })
                                    this.dialogEdit = false
                                    this.getlist()
                                } else {
                                    this.$notify.error({
                                        title: '修改部门失败',
                                        message: `${res.data.message}`
                                    })
                                }
                            })
                            .catch(()=>{
                                this.$notify.error({
                                    title: '修改部门失败',
                                    message: `服务器或网络异常`
                                })
                            })
                    }
                })
            }
        },
        // 删除
        del(id){
            this.$confirm('确认删除该部门？', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                dangerouslyUseHTMLString: true,
                type: 'warning',
            }).then(()=>{
                del({d_id:id}).then(res =>{
                        if (res.data.success) {
                            this.$message({
                                type: 'success',
                                message: '删除成功'
                            });
                            this.getlist()
                        }else {
                            this.$notify.error({
                                title: '部门删除失败',
                                message: `${res.data.message}`
                            })
                        }
                    })
            }).catch(()=>{
                this.$message({
                    type: 'info',
                    message: '已取消删除'
                });
            })
        },
        // 批量删除
        delBatch(){
            if (this.selection.length!==0){
                this.$confirm('确认删除选中部门？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(()=>{
                    let id = []
                    this.selection.forEach(value => {
                        id.push(value.id)
                    })
                    batchDelete({selection:id.join()}).then(res=>{
                        if (res.data.success) {
                            this.$message({
                                type: 'success',
                                message: '删除成功'
                            });
                            this.currentPage =1
                            this.getlist()
                        }else {
                            this.$notify.error({
                                title: '部门删除失败',
                                message: `${res.data.message}`
                            })
                        }
                    })
                }).catch(()=>{
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                })
            } else {
                this.$alert('选择为空', '提示', {
                    confirmButtonText: '确定',
                    type: 'warning',
                })
            }
        },
        //获取列表
        getlist(status){
            if (status === 'click'){
                this.currentPage = 1
                this.saveSearch =JSON.parse(JSON.stringify(this.search))
            }
            let form = {
                d_name:this.saveSearch,
                pageSise:this.pageSise,
                currentPage:this.currentPage
            }
            getList(form)
                .then(res =>{
                    if (res.data.success){
                        this.tableData = res.data.data
                        this.total = res.data.total
                    }else {
                        this.$notify.error({
                            title: '获取部门列表失败',
                            message: `${res.data.message}`
                        })
                    }

                })
                .catch(()=>{
                    this.$notify.error({
                        title: '获取部门列表失败',
                        message: `服务器或网络异常`
                    })
                })
        }
    },
    computed: {

    },
    mounted(){
        this.getlist()
    },
    watch:{
        dialogEdit(value){
            if (value === false){
                this.$refs.form.resetFields()
            }
        }
    }
}
</script>

<style scoped lang="scss">
@import '@/assets/styles/flex/flex.scss';
.departmentList{
    .SetIcon{
        i{
            cursor: pointer;
            margin: 0 .1rem;
        }
    }
    .buttons{
        *{
            font-size: .18rem;
        }
        @include f-rn-sb-c;
        margin-bottom: .1rem;
        .search{
            margin:0 0rem 0 .2rem ;
        }
        &/deep/.el-input{
            .el-input__inner{
                height: .45rem!important;
                line-height: .45rem!important;
            }
            width: 4rem;
        }
        &/deep/.el-button{
            height: .45rem!important;
            line-height: .45rem!important;
            padding: 0 .25rem!important;
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
