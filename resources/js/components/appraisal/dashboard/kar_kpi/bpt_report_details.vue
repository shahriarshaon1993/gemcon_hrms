<template>
    <div>
        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-12 mb-1 mt-0">
                        <div class="row breadcrumbs-top">
                            <div class="col-sm-9">
                                <div class="breadcrumb-wrapper col-9">
                                    <ol class="breadcrumb p-0 mb-0">
                                        <li class="breadcrumb-item">
                                            <router-link :to="{ path: '/' }"><i class="bx bx-home-alt"></i></router-link>
                                        </li>
                                        <li class="breadcrumb-item active"> BPT Report Details
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            <!-- <div class=" col-sm-3">
                                <router-link class="btn btn-primary add-btn" :to="{ path: '/add_daily_work' }"> <i class="bx bx-add-alt"></i> Add daily work </router-link>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="content-body"> 
                    <section id="basic-datatable"> 
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body card-dashboard"> 
                                            <div class="table-responsive">  
                                                <table class="table table-bordered table-sm">
                                                    <thead class="thead-dark"> 
                                                        <tr class="text-center"> 
                                                            <tr>
                                                                <td colspan="3">KRA</td>
                                                                <td colspan="3"> {{ item.krajoin ? item.krajoin.kra_name : ''}}</td>
                                                                <td colspan="4">KPI</td>
                                                                <td colspan="4">{{item.kpi_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">KRA weight</td>
                                                                <td colspan="3">{{ item.krajoin ? item.krajoin.kra_weight : '' }}</td>
                                                                <td colspan="4">KPI weight</td>
                                                                <td colspan="4">{{ item.kpi_weight }}</td>
                                                             </tr> 
                                                    </thead> 
                                                    <tbody>
                                                        <template  v-for="(mos_item , intex)  in item.mosjoin">
                                                            <tr class="thead-dark" v-bind:key="mos_item.id"  >
                                                                <th colspan="13" class="text-center">MOS - {{intex + 1}} : {{mos_item.mos_name}} (Target - {{mos_item.mostargetjoin ? mos_item.mostargetjoin.total : '0' }}) (weight - {{mos_item.weightage}})</th>
                                                            </tr> 
                                                            <tr  :key="mos_item.id">
                                                                <td>
                                                                    <div class="custom-control "> 
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Jan_0_1">Jan</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Feb_0_2">Feb</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Mar_0_3">Mar</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Apr_0_4">Apr</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="May_0_5">May</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Jun_0_6">Jun</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Jul_0_7">Jul</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Aug_0_8">Aug</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Sep_0_9">Sep</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Oct_0_10">Oct</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Nov_0_11">Nov</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control ">
                                                                    <label for="Dec_0_12">Dec</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr  :key="mos_item.id"  class="text-right">
                                                                <td>
                                                                    <label> TARGET</label>
                                                                    <p style="color:red" ></p>
                                                                </td>
                                                                <td> 
                                                                    {{ mos_item.mostargetjoin.january }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.february }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.march }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.april }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.may }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.june }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.july }}
                                                                    
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.august }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.september }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.october }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.november }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mostargetjoin.december }}
                                                                </td>
                                                            </tr>
                                                            <tr  :key="mos_item.id"  class="text-right" >
                                                                <td>
                                                                    <label>Module</label>
                                                                    <p style="color:red" ></p>
                                                                </td>
                                                                <td> 
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.january : '0' }} 
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.february : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.march : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.april : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.may : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.june : '0' }}
                                                                 </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.july : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.august : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.september : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.october : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.november : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosmodulejoin ? mos_item.mosmodulejoin.december : '0' }}
                                                                </td>  
                                                            </tr>
                                                            <tr  :key="mos_item.id"  class="text-right" >
                                                                <td>
                                                                    <label>Achievement </label>
                                                                    <p style="color:red" ></p>
                                                                </td>
                                                                <td> 
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.january : '0' }} 
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.february : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.march : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.april : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.may : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.june : '0' }}
                                                                 </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.july : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.august : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.september : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.october : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.november : '0' }}
                                                                </td>
                                                                <td>
                                                                    {{ mos_item.mosachievementjoin ? mos_item.mosachievementjoin.december : '0' }}
                                                                </td>  
                                                            </tr>
                                                           
                                                        <template v-if="mos_item.feadback">
                                                            <tr  :key="mos_item.id"  >
                                                                <td colspan="13" class="text-center">Feedback</td> 
                                                            </tr>
                                                            <tr  :key="mos_item.id"  >
                                                                <td colspan="1">SI</td>
                                                                <td colspan="1">Month</td>
                                                                <td colspan="7">Comment</td>
                                                                <td colspan="2">Date</td>
                                                                <td colspan="2">User Name</td>
                                                                <td colspan="2">Action</td>
                                                            </tr>
                                                        
                                                            <tr  v-for="(feadback , intex2)  in   mos_item.feadback"  :key="feadback.id"  >
                                                                <td colspan="1">{{ intex2 + 1 }}</td> 
                                                                <td colspan="1"> <p v-if='feadback.fmonth > 0'>{{ months[feadback.fmonth-1].name}}</p></td>
                                                                <td colspan="7" v-html="feadback.msg"></td>
                                                                <td colspan="2"></td>
                                                                <td colspan="2">{{ format_Date(feadback.date)  }}</td>
                                                                <td colspan="2" class="text-center">
                                                                    <i @click="delete_feedback(feadback)"  class="bx bx-trash"></i>  
                                                                </td>
                                                            </tr>
                                                            <tr  :key="mos_item.id"  >
                                                                <td colspan="13" class="text-center"></td> 
                                                            </tr>

                                                        </template>
                                                          

                                                            <!-- feadback -->
                                                        
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </section>
                </div>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import axios from "../../axios_instance"; 
    export default {
        props: {},
        components: {
            // VueRecaptcha, facebookLogin
        },
        data() {
            return {
                kpi_id : this.$route.params.id,
                base_url: window.base_url,
                api_url: window.api_url,
                token: this.$localStorage.get("d_token"),
                user_data: JSON.parse(this.$localStorage.get("user")).data,
                role_id : '',
                item: [],   
               
            };
        },
        created() { 
            this.role_id = this.user_data.role_id ; 
            this.getItems();
           
        },
        methods: {
           
            hide_pop() {
                this.$modal.hide("popup-singel");
            },
            show_pop() { 
                this.$modal.show("popup-singel"); 
            },
            target(mos_item){ 
                return ( Number(mos_item.january) + Number(mos_item.february) + Number(mos_item.march) + Number(mos_item.april) + Number(mos_item.may) + Number(mos_item.june) + Number(mos_item.july) + Number(mos_item.august) + Number(mos_item.september) + Number(mos_item.october) + Number(mos_item.november) + Number(mos_item.december) ) ; 
            },
            async delete_feedback(item){ 
                let loader = this.$loading.show();
                try {
                    await axios
                        .delete(this.api_url + "mos_feadbacks/" + item.id, {
                            headers: {
                                "Content-Type": "application/json",
                                Authorization: this.token ? `Bearer ${this.token}` : ""
                            },
                        })
                        .then(({
                            res
                        }) => {
                            this.getItems();
                            if (res.data.success) {
                                this.$toasted.show(res.data.message, {
                                    theme: "bubble",
                                    duration: 5000,
                                    position: "bottom-right",
                                });
                            }
                            loader.hide();
                        });
                } catch (error) {
                    loader.hide();
                }
            },
            onlyNumber ($event) {
                //console.log($event.keyCode); //keyCodes value
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }
            },
            checkConditionKra( length , kpi_index , mos_index  ){ 
                if(kpi_index == 0 &&  mos_index == 0 ){
                    return  true ;
                }else{
                    return  false ;
                } 
            },
            checkConditionKpi( length  , mos_index  ){ 
                if(mos_index == 0 ){
                    return  true ;
                }else{
                    return  false ;
                } 
            },
            async getItems() {
                
                let loader = this.$loading.show();
                try {
                    await axios
                        .get(this.api_url + "k_p_i_s/" + this.kpi_id, {
                            headers: {
                                "Content-Type": "application/json",
                                Authorization: this.token ? `Bearer ${this.token}` : ""
                            },
                        })
                        .then(({
                            data
                        }) => {
                            if (data.success) {
                                this.item = data.data ;
                                console.log( 'this.item', this.item );
                            }
                            loader.hide();
                        });
                } catch (error) {
                    loader.hide();
                }
            },
        
        },
        computed: {},
    };
    </script>
    