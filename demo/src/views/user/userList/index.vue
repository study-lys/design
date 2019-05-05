/**
* 用户列表
* Author: liyinsheng
* Date: 2019-01-29
* Time: 15:16
* Email:cq_liyinsheng@163.com
*/
<template>
    <div class="staffList">
        <!--S 内容区-->
        <div class="buttons theme-font">
            <div class="form">
                <div>
                    <span>账号类型：</span>
                    <el-select
                            v-model="form.u_type"
                            collapse-tags
                            placeholder="请选择">
                        <el-option
                                v-for="item in adminType"
                                :key="item.id"
                                :label="item.name"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div>
                    <span>账号：</span>
                    <el-input  placeholder="输入用户账号查询" v-model="form.u_account"></el-input>
                </div>
                <div>
                    <span>姓名：</span>
                    <el-input  placeholder="输入用户姓名查询" v-model="form.u_name"></el-input>
                    <el-button type="primary" @click="getUser('click')" class="search">搜索</el-button>
                </div>
            </div>
        </div>
        <div class="content">
            <el-table
                    :data="tableData"
                    stripe
                    header-row-class-name="theme-table-header"
                    class="theme-table theme-border-checkbox-group"
                    style="width: 100%">
                <el-table-column
                        prop="u_id"
                        align="center"
                        show-overflow-tooltip
                        label="id"
                        min-width="30%">
                </el-table-column>
                <el-table-column
                        prop="u_type"
                        align="center"
                        show-overflow-tooltip
                        label="账号类型"
                        min-width="30%">
                </el-table-column>
                <el-table-column
                        prop="u_account"
                        align="center"
                        label="账号"
                        show-overflow-tooltip
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        prop="u_name"
                        align="center"
                        label="姓名"
                        show-overflow-tooltip
                        min-width="40%">
                </el-table-column>
                <el-table-column
                        prop="u_sex"
                        align="center"
                        label="性别"
                        show-overflow-tooltip
                        min-width="30%">
                </el-table-column>
                <el-table-column
                        align="center"
                        min-width="40%"
                        label="操作">
                    <template slot-scope="scope">
                        <div class="SetIcon" v-if="user.u_type ==='超级管理员' || user.u_id === scope.row.u_id">
                            <router-link :to="{path:'/user/userSet',query: {u_id: scope.row.u_id }}">
                                <i class="el-icon-edit-outline" title="修改"></i>
                            </router-link>
                            <i v-if="user.u_id !== scope.row.u_id" class="el-icon-delete" @click="del(scope.row.u_id)" title="删除"></i>
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
import { mapState } from 'vuex'
import {getUserList,delUser} from '@/api/user'
export default {
    name: 'Index',
    data () {
        return {
            loading:false,
            form:{
                u_account:'',//账号
                u_name:'',
                u_type:'',//账号类型
            },
            saveForm:{
                u_account:'',//账号
                u_name:'',
                u_type:'',//账号类型
            },//保存搜索条件
            currentPage: 1,//当前页
            pageSise:8,//每页大小
            adminType:[
                {
                    id:1,
                    name:'全部',
                    value:''
                },
                {
                    id:2,
                    name:'管理员',
                    value:'管理员'
                },
                {
                    id:3,
                    name:'超级管理员',
                    value:'超级管理员'
                }
            ],//管理员类型
            total:0,//总数据数量
            tableData:[]//表格
        }
    },
    methods:{
        // 分页
        handleSizeChange(val) {
            // console.log(`每页 ${val} 条`);
        },
        handleCurrentChange(val) {
            this.currentPage = val
            this.getUser()
        },
        // 删除
        del(id){
            this.$confirm('确认删除该用户？', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                dangerouslyUseHTMLString: true,
                type: 'warning',
            }).then(()=>{
                delUser({u_id:id}).then(res=>{
                    if (res.data.success){
                        this.getUser()
                        this.$message({
                            type: 'success',
                            message: '删除成功'
                        });
                    }else {
                        this.$notify.error({
                            title: '用户删除失败',
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
        // 获取用户列表
        getUser(status){
            if (status ==='click'){
                this.currentPage =1
                this.saveForm = JSON.parse(JSON.stringify(this.form))
            }
            this.saveForm.currentPage = this.currentPage
            this.saveForm.pageSise = this.pageSise
            getUserList(this.saveForm).then(res=>{
                if (res.data.success){
                    this.tableData = res.data.data
                    this.total = res.data.total
                } else {
                    this.$notify.error({
                        title: '获取用户列表失败',
                        message: `${res.data.message}`
                    })
                }
            }).catch(()=>{
                this.$notify.error({
                    title: '获取用户列表失败',
                    message: `服务器或网络异常`
                })
            })
        }
    },
    computed: {
        ...mapState(['user'])
    },
    mounted(){
        this.getUser()
    }
}
</script>

<style scoped lang="scss">
@import '@/assets/styles/flex/flex.scss';
.staffList{
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
        .form{
            @include f-rn-sb-fs;
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
                margin: 0 0rem 0 .1rem!important;
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
