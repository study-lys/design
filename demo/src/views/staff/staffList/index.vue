/**
* 员工列表
* Author: liyinsheng
* Date: 2019-01-29
* Time: 15:16
* Email:cq_liyinsheng@163.com
*/
<template>
    <div class="staffList">
        <!--S 内容区-->
        <!--todo 是否加上切换头像删除原头像功能？-->
        <!--todo 是否加上添加员工对应创建其考勤表，删除对应考勤表？-->
        <div class="buttons theme-font">
            <el-button type="primary" @click="delBatch()">批量删除</el-button>
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
                <el-input  placeholder="输入员工姓名查询" v-model="form.s_name"></el-input>
                <el-button type="primary" @click="getStaffList('click')" class="search">搜索</el-button>
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
                        prop="s_id"
                        align="center"
                        label="id"
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        prop="s_name"
                        align="center"
                        label="姓名"
                        min-width="60%">
                </el-table-column>
                <el-table-column
                        prop="s_sex"
                        align="center"
                        label="性别"
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="d_name"
                        min-width="60%"
                        label="所属部门">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="p_name"
                        show-overflow-tooltip
                        min-width="60%"
                        label="职位">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="s_phone"
                        show-overflow-tooltip
                        label="手机号">
                </el-table-column>
                <el-table-column
                        align="center"
                        prop="s_email"
                        show-overflow-tooltip
                        label="邮箱">
                </el-table-column>
                <el-table-column
                        align="center"
                        min-width="40%"
                        label="操作">
                    <template slot-scope="scope">
                        <div class="SetIcon">
                            <router-link :to="{path:'/staff/staffSet',query: {id: scope.row.s_id }}">
                                <i class="el-icon-edit-outline" title="修改"></i>
                            </router-link>
                            <i class="el-icon-delete" @click="del(scope.row.s_id)" title="删除"></i>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>
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
        <!--E 内容区-->
    </div>
</template>

<script>
    import {getDepartment} from '@/api/payroll'
    import {getList,staffDelete,batchDelete} from '@/api/staff'
export default {
    name: 'Index',
    data () {
        return {
            loading:false,
            form:{
                d_ids:[],//选择部门
                s_name:''
            },
            saveForm:{
                d_ids:[],//选择部门
                s_name:''
            },
            currentPage: 1,//当前页
            pageSise:8,//每页大小
            total:0,//总数据数量
            tableData:[],//表格
            departmentList:[],// 部门列表
            selection:[],//批量选择
        }
    },
    methods:{
        // 批量操作-选择
        handleSelectionChange(val) {
            this.selection = val
        },
        // 分页
        handleSizeChange(/*val*/) {
            // console.log(`每页 ${val} 条`);
        },
        handleCurrentChange(val) {
            this.currentPage = val
            // console.log(`当前页: ${val}`);
            this.getStaffList()
        },
        // 删除
        del(s_id){
            this.$confirm('确认删除该员工？', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                dangerouslyUseHTMLString: true,
                type: 'warning',
            }).then(()=>{
                console.log(s_id)
                staffDelete({s_id:s_id}).then(res=>{
                    if (res.data.success){
                        this.$message({
                            type: 'success',
                            message: '员工删除成功'
                        })
                        this.getStaffList()
                    }else {
                        this.$notify.error({
                            title: '员工删除失败',
                            message: `${res.data.message}`
                        })
                    }
                }).catch(()=>{
                    this.$notify.error({
                        title: '员工删除失败',
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
        // 批量删除
        delBatch(){
            if (this.selection.length!==0){
                this.$confirm('确认删除员工？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(()=>{
                    let id = []
                    this.selection.forEach(value => {
                        id.push(value.s_id)
                    })
                    batchDelete({selection:id.join()}).then(res=>{
                        if (res.data.success) {
                            this.$message({
                                type: 'success',
                                message: '删除成功'
                            });
                            this.getStaffList()
                        }else {
                            this.$notify.error({
                                title: '员工删除失败',
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
        },
        // 获取员工列表
        getStaffList(state){
            if (state === 'click'){
                this.currentPage = 1
                this.saveForm = JSON.parse(JSON.stringify(this.form))
            }
            let form = {
                d_ids:this.saveForm.d_ids.join(),
                s_name:this.saveForm.s_name,
                pageSise:this.pageSise,
                currentPage:this.currentPage
            }
            getList(form).then(res=>{
                if (res.data.success){
                    this.total = res.data.total
                    this.tableData = res.data.data
                }
            }).catch(()=>{
                this.$notify.error({
                    title: '获取员工列表失败',
                    message: `服务器或网络异常`
                })
            })
        }

    },
    mounted(){
        this.getDepartmentList()
        this.getStaffList()
    }
}
</script>

<style scoped lang="scss">
@import '@/assets/styles/flex/flex.scss';
.staffList{
    .SetIcon{
        i{
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
