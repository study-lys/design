<template>
    <div class="home">
        <el-row>
            <el-col :span="5" v-for="(value,index) in btnData" :key="index">
                <router-link :to="{path:value.to,params:{'list':value.params}}">
                    <div class="theme-font-white option_button" :style="{backgroundColor:value.backgroundColor}">
                        <i class="home_icon pull-left" :class="value.icon"></i>
                        <b class=" home_btn_title">{{value.name}}</b>
                    </div>
                </router-link>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    export default {
        name: 'Home',
        data () {
            return {
                // btnData:[]
            }
        },
        computed: {
            ...mapState(['construction']),
            btnData: function () {
                let data = []
                this.construction.forEach(value => {
                    value.child.forEach(value => {
                        data.push(value)
                    })
                })
                return data
            }
        },
        // methods:{
        //     setBtnData(){
        //         let data = []
        //         this.construction.forEach(value => {
        //             value.child.forEach(value => {
        //                 data.push(value)
        //             })
        //         })
        //         this.btnData = data
        //     }
        // },
        // mounted(){
        //     this.setBtnData()
        // }
    }
</script>

<style scoped>
    .option_button{
        width: 100%;
        height: 1.3rem;
        border-radius: 5%;
        display: flex;
        align-items: center;
        justify-content:center;
    }
    .option_button:hover{
        opacity: 0.7;
    }
    .option_button:active{
        opacity:1.5;
    }
    .el-col{
        margin-right:2.381%;
        margin-bottom: .3rem;
    }
    .el-col:nth-of-type(4n)
    {
        margin-right: 4.762%;
    }
    .el-col:nth-of-type(4n+1)
    {
        margin-left: 4.762%;
    }
    .home{
        margin-top: .4rem;
    }
    .home_icon{
        font-size: 1rem;
        margin-right: 5%;
    }
    .home_btn_title{
        /*font-size: 18px;*/
        font-size: .26rem;
        display: inline-block;
    }
</style>
