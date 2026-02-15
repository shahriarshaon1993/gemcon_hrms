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
                               <li class="breadcrumb-item active"> Feedback
                               </li>
                            </ol>
                         </div>
                      </div>
                      <!-- <div class=" col-sm-3">
                         <a class="btn btn-primary add-btn" @click="show_pop()" > <i class="bx bx-add-alt"></i> Add New MOS </a>
                      </div> -->
                   </div>
                </div>
             </div>
             <div class="content-body">
                <section id="basic-datatable" >
                   <div class="row">
                      <div class="col-12">
                         <div class="card">
                            <div class="card-content">
                                <div class="card-body card-dashboard"> 
                                    <div class="table-responsive">  
                                        <table class="table table-bordered table-striped table-sm">
                                        <tbody>
                                            <tr>
                                                <th class="text-left" width="15%"><strong>KRA</strong></th>
                                                <th class="text-left"><strong>{{ item.krajoin ? item.krajoin.kra_name : '' }}</strong></th>
                                                <th class="text-left" width="15%"><strong>KRA WEIGHTAGE</strong></th>
                                                <th class="text-left"><strong>{{ item.krajoin ? item.krajoin.kra_weight : '' }}</strong></th>
                                            </tr>
                                            <tr>
                                                <th class="text-left"><strong>KPI</strong></th>
                                                <th class="text-left"><strong>{{item.kpi_name}}</strong>
                                                </th>
                                                <th class="text-left"><strong>KPI WEIGHTAGE</strong></th>
                                                <th class="text-left"><strong>{{ item.kpi_weight }}</strong></th>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <table class="table table-bordered table-sm">
                                        <template  v-for="mos_item  in item.mosjoin">
                                            <tr class="thead-dark" v-bind:key="mos_item.id"  >
                                                <th colspan="26" class="text-center">{{mos_item.mos_name}}</th>
                                            </tr>
                                           
                                            <tr  :key="mos_item.id">
                                                <td></td>
                                                <td v-if="month_off.jan" colspan="2" class="text-center">Jan</td>
                                                <td v-if="month_off.feb" colspan="2" class="text-center">Feb</td>
                                                <td v-if="month_off.mar" colspan="2" class="text-center">Mar</td>
                                                <td v-if="month_off.apr" colspan="2" class="text-center">Apr</td>
                                                <td v-if="month_off.may" colspan="2" class="text-center">May</td>
                                                <td v-if="month_off.jun" colspan="2" class="text-center">Jun</td>
                                                <td v-if="month_off.jul" colspan="2" class="text-center">Jul</td>
                                                <td v-if="month_off.aug" colspan="2" class="text-center">Aug</td>
                                                <td v-if="month_off.sep" colspan="2" class="text-center">Sep</td>
                                                <td v-if="month_off.oct" colspan="2" class="text-center">Oct</td>
                                                <td v-if="month_off.nov" colspan="2" class="text-center">Nov</td>
                                                <td v-if="month_off.dec" colspan="2" class="text-center">Dec</td>
                                            </tr>
                                            <tr  :key="mos_item.id">
                                                <td></td>
                                                <td v-if="month_off.jan">Target</td>
                                                <td v-if="month_off.jan">Achievement</td>
                                                <td v-if="month_off.feb">Target</td>
                                                <td v-if="month_off.feb">Achievement</td>
                                                <td v-if="month_off.mar">Target</td>
                                                <td v-if="month_off.mar">Achievement</td>
                                                <td v-if="month_off.apr">Target</td>
                                                <td v-if="month_off.apr">Achievement</td>
                                                <td v-if="month_off.may">Target</td>
                                                <td v-if="month_off.may">Achievement</td>
                                                <td v-if="month_off.jun">Target</td>
                                                <td v-if="month_off.jun">Achievement</td>
                                                <td v-if="month_off.jul">Target</td>
                                                <td v-if="month_off.jul">Achievement</td>
                                                <td v-if="month_off.aug">Target</td>
                                                <td v-if="month_off.aug">Achievement</td>
                                                <td v-if="month_off.sep">Target</td>
                                                <td v-if="month_off.sep">Achievement</td>
                                                <td v-if="month_off.oct">Target</td>
                                                <td v-if="month_off.oct">Achievement</td>
                                                <td v-if="month_off.nov">Target</td>
                                                <td v-if="month_off.nov">Achievement</td>
                                                <td v-if="month_off.dec">Target</td>
                                                <td v-if="month_off.dec">Achievement</td>
                                            </tr>
                                            <tr  :key="mos_item.id">
                                                <td>
                                                    <label>{{mos_item.mos_name}}</label> 
                                                </td>
                                                <td v-if="month_off.jan" > {{mos_item.mostargetjoin.january}}</td>
                                                <td v-if="month_off.jan" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.january"  type="text" class="form-control "></td>  
                                                <td v-if="month_off.feb" > {{mos_item.mostargetjoin.february}}</td> 
                                                <td v-if="month_off.feb" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.february"  type="text" class="form-control "></td>
                                                <td v-if="month_off.mar" > {{mos_item.mostargetjoin.march}}</td> 
                                                <td v-if="month_off.mar" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.march"  type="text" class="form-control "></td>
                                                <td v-if="month_off.apr" > {{mos_item.mostargetjoin.april}}</td> 
                                                <td v-if="month_off.apr" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.april"  type="text" class="form-control "></td>
                                                <td v-if="month_off.may" > {{mos_item.mostargetjoin.may}}</td> 
                                                <td v-if="month_off.may" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.may"  type="text" class="form-control "></td>
                                                <td v-if="month_off.jun" > {{mos_item.mostargetjoin.june}}</td> 
                                                <td v-if="month_off.jun" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.june"  type="text" class="form-control "></td>
                                                <td v-if="month_off.jul" > {{mos_item.mostargetjoin.july}}</td> 
                                                <td v-if="month_off.jul" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.july"  type="text" class="form-control " ></td>
                                                <td v-if="month_off.aug" > {{mos_item.mostargetjoin.august}}</td> 
                                                <td v-if="month_off.aug" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.august"  type="text" class="form-control " ></td>
                                                <td v-if="month_off.sep" > {{mos_item.mostargetjoin.september}}</td> 
                                                <td v-if="month_off.sep" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.september"  type="text" class="form-control " ></td>
                                                <td v-if="month_off.oct" > {{mos_item.mostargetjoin.october}}</td> 
                                                <td v-if="month_off.oct" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.october"  type="text" class="form-control " ></td>
                                                <td v-if="month_off.nov" > {{mos_item.mostargetjoin.november}}</td> 
                                                <td v-if="month_off.nov" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.november"  type="text" class="form-control " ></td>
                                                <td v-if="month_off.dec" > {{mos_item.mostargetjoin.december}}</td> 
                                                <td v-if="month_off.dec" > <input @keypress="onlyNumber"  v-model="mos_item.mosachievementjoin.december"  type="text" class="form-control " ></td>
                                            </tr>
                                            
                                        </template>
                                        </table>
                                        <div class="row">
                                        <div class="col-12 text-right">
                                            <button @click="updateMOS()" class="btn btn-success">Update</button>
                                        </div>
                                        <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </section>
                <modal width="60%" height="70%" style="padding:50px" name="popup-singel">
                   <i @click="hide_pop()" class="bx bx-x-circle  x-circle"></i>
                   <div class="app-content ">
                      <div class="card">
                         <table class="table table-bordered table-striped table-sm">
                            <tbody>
                               <tr>
                                  <th colspan="2" class="text-center" width="15%"><strong>KRA</strong></th>
                               </tr>
                               <tr>
                                  <th class="text-center" width="15%"><strong>Name</strong></th>
                                  <th class="text-center" width="15%"><strong>Weightage</strong></th>
                               </tr>
                               <tr>
                                  <th class="text-center">{{ item.krajoin ? item.krajoin.kra_name : '' }}</th>
                                  <th class="text-center">{{ item.krajoin ? item.krajoin.kra_weight : '' }}</th>
                               </tr>
                               <tr>
                                  <th colspan="2" class="text-center" width="15%"><strong>KPI</strong></th>
                               </tr>
                               <tr>
                                  <th class="text-center">{{ item.kpi_name }}</th>
                                  <th class="text-center">{{ item.kpi_weight }}</th>
                               </tr>
                               <tr>
                                  <th colspan="2" class="text-center" width="15%"><strong>KPI</strong></th>
                               </tr>
                               <tr>
                                  <th class="text-center">{{ item.kpi_name }}</th>
                                  <th class="text-center">{{ item.kpi_weight }}</th>
                               </tr>
                               <tr>
                                  <th colspan="2" class="text-center" width="15%"><strong>MOS</strong></th>
                               </tr>
                               <tr>
                                  <th class="text-center">
                                     <input class="form-control text-center" placeholder="MOS Name" v-model="addForm.mos_name" >
                                  </th>
                                  <th class="text-center">
                                     <button @click="addMOS()" class="btn btn-success">Save</button>
                                  </th>
                               </tr>
                            </tbody>
                         </table>
                      </div>
                   </div>
                </modal>
             </div>
          </div>
       </div>
    </div>
 </template>
 <script>
    import axios from "../../axios_instance";
    import { Form } from "vform"; 
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
                item: [],   
                status: '',
                month_off : [], 
                updateForm: new Form({ 
                    arrayData: ""  
                }),
                addForm: new Form({ 
                    mos_name: "" ,
                    weightage : 0
                }),
            };
        },
        created() { 
            this.role_id = this.user_data.role_id ; 
            if(this.role_id ==  5){
                this.getDepartment().then(({ data }) => { 
                    if(data.success){ 
                        this.month_off =  data.data.setting ;  
                        console.log( this.month_off );
                    } 
                });
            }
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
            updateMOS(){
                try {
                    let loader = this.$loading.show(); 
                    this.updateForm.arrayData =   this.item ;
                    this.updateForm.post(this.api_url + "mos_update", {
                        headers: {
                        "Content-Type": "application/json", 
                        Authorization: this.token ? `Bearer ${this.token}` : ""
                        },
                    }).then((res) => {
                        console.log(res); 
                        if(res.data.success){ 
                        this.$toasted.show(res.data.message, {
                            theme: "bubble",
                            duration: 5000,
                            position: "bottom-right",
                            });
                    } 
                    loader.hide();  
                    
                    })
                } catch (error) { 
                console.log(error);
                }
                console.log( this.item );
            },
            addMOS(){
                try {
                    let loader = this.$loading.show(); 
                    this.addForm.kra_id =   this.item.krajoin.id  ;
                    this.addForm.kpi_id =   this.item.id ;
                    this.addForm.dept_id =   this.item.dept_id ;
                    this.addForm.post(this.api_url + "m_o_s", {
                        headers: {
                        "Content-Type": "application/json", 
                        Authorization: this.token ? `Bearer ${this.token}` : ""
                        },
                    }).then((res) => {
                        console.log(res); 
                        if(res.data.success){ 
                        this.hide_pop();
                        this.getItems(); 
                        this.$toasted.show(res.data.message, {
                            theme: "bubble",
                            duration: 5000,
                            position: "bottom-right",
                            });
                    } 
                    loader.hide();  
                    
                    })
                } catch (error) { 
                console.log(error);
                }
                console.log( this.item );
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
                                console.log( this.item );
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
 
 