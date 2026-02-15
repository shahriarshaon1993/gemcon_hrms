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
                                        <li class="breadcrumb-item active"> KRA , KPI and MOS 
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
                        <div  class="users-list-filter px-1">  
                            <div class="row border rounded py-2 mb-2">
                                <div class="col-12 col-sm-12 "> 
                                    <div class="form-inline justify-content-center row" style="padding-top: 10px;">
                                        <label class="mb-2 mr-sm-2 col-1">Show <strong>KRA</strong> <input type="checkbox" checked="" value="1" v-model="filterForm.show_kra"></label>
                                        <label class="mb-2 mr-sm-2 col-1">Show <strong>KPI</strong> <input type="checkbox" checked="" value="1"  v-model="filterForm.show_kpi"></label>
                                        <label class="mb-2 mr-sm-2 col-1">Show <strong>MOS</strong> <input type="checkbox" checked="" value="1"  v-model="filterForm.show_mos"></label>
                                        <label class="mb-2 mr-sm-2 col-1">Show <strong>Y.Achi.%</strong> <input type="checkbox" value="1"  v-model="filterForm.show_yachi"></label>
                                    </div>
                                </div>     
                                <div  class="col-12 col-sm-6 col-lg-2">
                                    <label for="users-list-verified">Quarter </label>
                                    <fieldset class="form-group">
                                      <select class="form-control" v-model="filterForm.quarter"  id="users-list-verified">
                                        <option>All</option>
                                        <option  v-for="row in quarter_months" :key="row.id"  :value="row.id">{{ row.name }}</option>
                                        <option value="5">1st Half yearly</option>
                                        <option value="6">2nd Half yearly</option>
                                      </select>
                                    </fieldset>
                                  </div>
                                  <div  class="col-12 col-sm-6 col-lg-2">
                                    <label for="users-list-verified">Month </label>
                                    <fieldset class="form-group">
                                      <select class="form-control" v-model="filterForm.month"  id="users-list-verified">
                                        <option>All</option>
                                        <option  v-for="row in months" :key="row.id"  :value="row.id">{{ row.name }}</option>
                                      </select>
                                    </fieldset>
                                  </div> 
                               <div v-if="role_id == 1 || role_id == 2 || role_id == 3 || role_id == 4 || role_id == 8 " class="col-12 col-sm-6 col-lg-2">
                                  <label for="users-list-verified">Department</label>
                                  <fieldset class="form-group">
                                     <select  v-on:change="getKRA()"  class="form-control"  v-model="filterForm.dept_id"  id="users-list-verified" >
                                         <option>Select One</option>
                                         <option v-for="row in deptItems" :key="row.id" :value="row.id" >
                                         {{ row.name }}
                                         </option>
                                     </select> 
                                  </fieldset>
                               </div>
                               <div  class="col-12 col-sm-6 col-lg-2">
                                    <label for="Profession">KRA</label>
                                    <fieldset class="form-group">
                                        <div class="controls">
                                            <select  id="Profession" name="kra_id"  v-on:change="getKpi()"  v-model="filterForm.kra_id"   class="form-control">
                                                <option>Select one</option>
                                                <option  v-for="row in kraItem" :key="row.id" :value="row.id">{{ row.kra_name}}</option>  
                                            </select>
                                        </div>
                                    </fieldset>
                               </div>
                               <div  class="col-12 col-sm-6 col-lg-2">
                                <label for="Profession">KPI</label>
                                <fieldset class="form-group">
                                    <div class="controls">
                                        <select  id="Profession" name="kpi_id" v-on:change="getItems()"   v-model="filterForm.kpi_id"  class="form-control">
                                            <option>Select one</option>
                                            <option  v-for="row in kpiItem" :key="row.id" :value="row.id">{{ row.kpi_name}}</option>  
                                        </select>
                                    </div>
                                </fieldset>
                           </div>  
                        </div>  
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body card-dashboard"> 
                                            <div class="table-responsive">  
                                                <table class="table table-bordered table-sm">
                                                    <thead class="thead-dark"> 
                                                    <tr> 
                                                        <th v-if="filterForm.show_kra==1">KRA</th>
                                                        <!-- <th v-if="filterForm.show_kra==1">Weightage</th> -->
                                                        <th v-if="filterForm.show_kpi==1">KPI</th>
                                                        <th v-if="filterForm.show_kpi==1">MOS</th>
                                                        <!-- <th v-if="filterForm.show_mos==1">MOS</th> 
                                                        <th>{{ filterForm.month !=''? 'm.Target' : filterForm.quarter == 1 ||  filterForm.quarter == 2 || filterForm.quarter == 3 || filterForm.quarter == 4 ? 'Q.Target' : filterForm.quarter == 5 || filterForm.quarter == 6 ? 'H.Target' : 'Y.Target' }}</th>
                                                        <th>{{ filterForm.month !=''? 'm.Achi' : filterForm.quarter == 1 ||  filterForm.quarter == 2 || filterForm.quarter == 3 || filterForm.quarter == 4  ? 'Q.Achi' : filterForm.quarter == 5 || filterForm.quarter == 6 ? 'H.Achi' : 'Y.Achi' }}</th>
                                                        <th v-if="filterForm.show_yachi==1">{{ filterForm.month !=''? 'm.Achieve.%' : filterForm.quarter == 1 ||  filterForm.quarter == 2 || filterForm.quarter == 3 || filterForm.quarter == 4  ? 'Q.Achieve.%' : filterForm.quarter == 5 || filterForm.quarter == 6 ? 'H.Achieve%' : 'Y.Achieve.%' }}</th>
                                                        <th v-if="select_months('jan')"  >Jan </th>
                                                        <th v-if="select_months('feb')"  >Feb</th>
                                                        <th v-if="select_months('mar')"  >Mar</th>
                                                        <th v-if="select_months('apr')"  >Apr</th>
                                                        <th v-if="select_months('may')"  >May</th>
                                                        <th v-if="select_months('jun')"  >Jun</th>
                                                        <th v-if="select_months('jul')"  >Jul</th>
                                                        <th v-if="select_months('aug')"  >Aug</th>
                                                        <th v-if="select_months('sep')"  >Sep</th>
                                                        <th v-if="select_months('oct')"  >Oct</th>
                                                        <th v-if="select_months('nov')"  >Nov</th>
                                                        <th v-if="select_months('dec')"  >Dec</th>   -->

                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template v-for="(item , index )  in items" >  
                                                            <template v-for="item2 in item.kpijoin" > 
                                                                <template v-for="item3 in item2.mosjoin" :key="item3.id"> 
                                                         
                                                                    <tr :class="index" > 
                                                                        
                                                                        <td  v-if="filterForm.show_kra==1 && (items[index > 0 ? index - 1 : 0 ].kra_id != item.kra_id || index ==0)" :rowspan="item.kpiandmosnumber" > 1 == {{item.kra_name}}</td>
                                                                        <!-- <td :rowspan="item.kpiandmosnumber" >{{kra_weight}}</td> -->
                                                                         
                                                                        <!-- <td  v-if="filterForm.show_kra==1 && (items[index > 0 ? index - 1 : 0 ].kra_id != item.kra_id || index ==0)" :rowspan="item.kpiandmosnumber" :rowspan="item2.mosnumber"   > 2 =={{item2.kpi_name}}</td>
                                                                        <td    > 3 =={{item3.mos_name}}</td> -->
                                                                            
                                                                        
                                                                    </tr>
                                                                </template>
                                                            </template>
                                                                        <!-- <td    >{{ item.krajoin ? item.krajoin.kra_name : '' }}</td>
                                                                        <td    >{{ item.krajoin ? item.krajoin.kra_weight : '' }}</td>
                                                                        <td  >{{ item.kpijoin ? item.kpijoin.kpi_name : '' }}</td>
                                                                        
                                                                        <td v-if="filterForm.show_mos==1">{{ item.mos_name }}</td>
                                                                        <td>{{ Number(targetTotal(item)).toFixed(0)}}</td>
                                                                        <td>{{ Number(achievementjoinTotal(item)).toFixed(0) }}</td>
                                                                        <td v-if="filterForm.show_yachi==1">{{achievementTotal(targetTotal(item), achievementjoinTotal(item))}}%</td>
                                                                        <td v-if="select_months('jan')" v-bind:class=" achievement(item , 'january') >  100 ? 'gb_color_green': achievement(item , 'january') <  100  && achievement(item , 'january') > 0 ? 'gb_color_yellow' : ''" >
                                                                            {{achievement(item , 'january') > 0 ?  achievement(item , 'january') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'january') == 0 && item.mostargetjoin ? item.mostargetjoin.january : 0 > 0 "  class="bx bx-map"  v-bind:class=" colorCheck(1) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                        <td v-if="select_months('feb')" v-bind:class=" achievement(item , 'february') >  100 ? 'gb_color_green': achievement(item , 'february') <  100  && achievement(item , 'february') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'february') > 0 ?  achievement(item , 'february') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'february') == 0 && item.mostargetjoin ? item.mostargetjoin.february : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(2) == 'red' ? 'color_red': '' "></i> 
                                                                        </td>
                                                                        <td v-if="select_months('mar')" v-bind:class=" achievement(item , 'march') >  100 ? 'gb_color_green': achievement(item , 'march') <  100  && achievement(item , 'march') > 0 ? 'gb_color_yellow' : ''" >
                                                                            {{achievement(item , 'march') > 0 ?  achievement(item , 'march') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'march') == 0 && item.mostargetjoin ? item.mostargetjoin.march : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(3) == 'red' ? 'color_red': '' "></i> 
                                                                        </td>
                                                                        <td v-if="select_months('apr')"  v-bind:class=" achievement(item , 'april') >  100 ? 'gb_color_green': achievement(item , 'april') <  100  && achievement(item , 'april') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'april') > 0 ?  achievement(item , 'april') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'april') == 0 && item.mostargetjoin ? item.mostargetjoin.april : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(4) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                        <td v-if="select_months('may')"  v-bind:class=" achievement(item , 'may') >  100 ? 'gb_color_green': achievement(item , 'may') <  100  && achievement(item , 'may') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'may') > 0 ?  achievement(item , 'may') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'may') == 0 && item.mostargetjoin ? item.mostargetjoin.may : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(5) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                        <td v-if="select_months('jun')"  v-bind:class=" achievement(item , 'june') >  100 ? 'gb_color_green': achievement(item , 'june') <  100  && achievement(item , 'june') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'june') > 0 ?  achievement(item , 'june') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'june') == 0 && item.mostargetjoin ? item.mostargetjoin.june : 0 > 0 " class="bx bx-map "   v-bind:class=" colorCheck(6) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                            
                                                                        <td v-if="select_months('jul')"  v-bind:class=" achievement(item , 'july') >  100 ? 'gb_color_green': achievement(item , 'july') <  100  && achievement(item , 'july') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'july') > 0 ?  achievement(item , 'july') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'july') == 0 && item.mostargetjoin ? item.mostargetjoin.july : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(7) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                        <td v-if="select_months('aug')"  v-bind:class=" achievement(item , 'august') >  100 ? 'gb_color_green': achievement(item , 'august') <  100  && achievement(item , 'august') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'august') > 0 ?  achievement(item , 'august') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'august') == 0 && item.mostargetjoin ? item.mostargetjoin.august : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(8) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                        <td v-if="select_months('sep')"  v-bind:class=" achievement(item , 'september') >  100 ? 'gb_color_green': achievement(item , 'september') <  100  && achievement(item , 'september') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'september') > 0 ?  achievement(item , 'september') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'september') == 0 && item.mostargetjoin ? item.mostargetjoin.september : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(9) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                        <td v-if="select_months('oct')"  v-bind:class=" achievement(item , 'october') >  100 ? 'gb_color_green': achievement(item , 'october') <  100  && achievement(item , 'october') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'october') > 0 ?  achievement(item , 'october') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'october') == 0 && item.mostargetjoin ? item.mostargetjoin.october : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(10) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                            
                                                                        <td v-if="select_months('nov')"  v-bind:class=" achievement(item , 'november') >  100 ? 'gb_color_green': achievement(item , 'november') <  100  && achievement(item , 'november') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'november') > 0 ?  achievement(item , 'november') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'november') == 0 && item.mostargetjoin ? item.mostargetjoin.november : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(11) == 'red' ? 'color_red': '' "></i> 
                                                                        </td> 
                                                                            
                                                                        <td v-if="select_months('dec')"  v-bind:class=" achievement(item , 'december') >  100 ? 'gb_color_green': achievement(item , 'december') <  100  && achievement(item , 'december') > 0 ? 'gb_color_yellow' : ''">
                                                                            {{achievement(item , 'december') > 0 ?  achievement(item , 'december') + '%' : ''}}  
                                                                            <i v-if="achievement(item , 'december') == 0 && item.mostargetjoin ? item.mostargetjoin.december : 0 > 0 " class="bx bx-map"  v-bind:class=" colorCheck(12) == 'red' ? 'color_red': '' "></i> 
                                                                        </td>  
                                                                        
                                                                        <td>  
                                                                            <div class="dropup">
                                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                                                                </span>
                                                                                <div class="dropdown-menu dropdown-menu-right"> 
                                                                                    <router-link  v-if="role_id == 5 || role_id == 6"  class="dropdown-item" :to="{ path: '/achievement/'+ item.id }" ><i class="bx bx-edit-alt mr-1"></i>  Achievement </router-link>
                                                                                    <router-link class="dropdown-item" :to="{ path: '/bpt_report_details/'+ item.kpi_id }"  ><i class="bx bx-edit-alt mr-1"></i> Details </router-link> 
                                                                                </div>
                                                                            </div> 
        
                                                                        </td>  --> 
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
    import { Form } from "vform"; 
    export default {
        props: {},
        components: {
            // VueRecaptcha, facebookLogin
        },
        data() {
            return {
                base_url: window.base_url,
                api_url: window.api_url,
                token: this.$localStorage.get("d_token"),
                user_data: JSON.parse(this.$localStorage.get("user")).data,
                role_id : '',
                items: [],   
                deptItems: [],   
                filterForm: new Form({ 
                    dept_id: "",
                    kra_id : "",
                    kpi_id : "",
                    quarter : "",
                    month : "",
                    show_kra: 1,
                    show_kpi: 1,
                    show_mos: 1,
                    show_yachi: 1,
                }),
                status: '',
                kraItem: [] ,  
                kpiItem: [] ,  
                mosItem: [] , 
            };
        },
        created() { 
            this.role_id = this.user_data.role_id ; 
            if( this.role_id == 5 || this.role_id == 6 || this.role_id == 7){
            this.filterForm.dept_id =   this.user_data.department ; 
            this.getKRA();
            this.getItems(); 
            }else{
                this.getDept();
            } 
           
        },
        methods: {
            achievementTotal(target , achieve){ 
                if(target > 0 && achieve > 0 ){ 
                    return ((achieve/target)*100).toFixed()  ;
                }else {
                    return 0 ;
                } 
            },
            achievement(item , month){
                let target  = item.mostargetjoin[month] ;
                let achievement  = item.mosachievementjoin[month] ;
                if(target > 0 && achievement > 0 ){ 
                    return ((achievement/target)*100).toFixed()  ;
                }else {
                    return 0 ;
                } 
            },
            colorCheck(month_id){
                var currentTime = new Date() 
                var month = currentTime.getMonth() + 1;
                if(month_id < month  ){
                    return 'red' ;
                } 
            },
            targetTotal(item){
                let target = item.mostargetjoin ; 
                let total  = 0 ;
                let q1 ;
                let q2 ;
                let q3;
                let q4 ;
                let q5;
                let q6 ;
                q1  = target.january + target.february + target.march ; 
                q2  = target.april + target.may +  target.july ;
                q3  = target.june +  target.august + target.september ; 
                q4  = target.october + target.november + target.december; 
                q5  = q1 + q2 ; 
                q6  = q3 + q4 ; 
                if(this.filterForm.month =='' ){
                    if(this.filterForm.quarter ==1 ){
                        total =  q1 ;
                    }else if(this.filterForm.quarter == 2){
                        total = q2 ;
                    }else if(this.filterForm.quarter == 3){
                        total =  q3;
                    }else if(this.filterForm.quarter == 4){
                        total = q4 ;
                    }else if(this.filterForm.quarter == 5){
                        total = q5/6 ;
                    }else if(this.filterForm.quarter == 6){
                        total = q6/6 ;
                    }else{
                        total =  q1 + q2 + q3+ q4 ;
                    }  
                }else{ 
                    if(this.filterForm.month == 'jan'){
                        total = target.january ;
                    }else if(this.filterForm.month == 'feb'){ 
                        total = target.february ;
                    }else if(this.filterForm.month == 'mar'){ 
                        total = target.march;
                    }else if(this.filterForm.month == 'apr'){ 
                        total = target.april;
                    }else if(this.filterForm.month == 'may'){ 
                        total = target.may ;
                    }else if(this.filterForm.month == 'jun'){ 
                        total = target.june ;
                    }else if(this.filterForm.month == 'jul'){ 
                        total = target.july ;
                    }else if(this.filterForm.month == 'aug'){ 
                        total = target.august;
                    }else if(this.filterForm.month == 'sep'){ 
                        total = target.september;
                    }else if(this.filterForm.month == 'oct'){ 
                        total = target.october ;
                    }else if(this.filterForm.month == 'nov'){  
                        total = target.november ;
                    }else if(this.filterForm.month == 'dec'){ 
                        total = target.december ;
                    }else{
                        total = 0 ;
                    } 
                }   
                return total ;  
            },
            achievementjoinTotal(item){
                let achievement = item.mosachievementjoin ; 
                let total  = 0 ;
                let q1 ;
                let q2 ;
                let q3;
                let q4 ;
                let q5;
                let q6 ;
                q1  = achievement.january + achievement.february + achievement.march ; 
                q2  = achievement.april + achievement.may +  achievement.july ;
                q3  = achievement.june +  achievement.august + achievement.september ; 
                q4  = achievement.october + achievement.november + achievement.december; 
                q5  = q1+ q2 ;
                q6  = q3+ q4 ;
                if(this.filterForm.month =='' ){
                    if(this.filterForm.quarter ==1 ){
                        total =  q1 ;
                    }else if(this.filterForm.quarter == 2){
                        total = q2 ;
                    }else if(this.filterForm.quarter == 3){
                        total =  q3;
                    }else if(this.filterForm.quarter == 4){
                        total = q4 ;
                    }else if(this.filterForm.quarter == 5){
                        total =  q5/6;
                    }else if(this.filterForm.quarter == 6){
                        total = q6/6 ;
                    }else{
                        total =  q1 + q2 + q3+ q4 + q5 + q6 ;
                    }  
                }else{ 
                    if(this.filterForm.month == 'jan'){
                        total = achievement.january ;
                    }else if(this.filterForm.month == 'feb'){ 
                        total = achievement.february ;
                    }else if(this.filterForm.month == 'mar'){ 
                        total = achievement.march;
                    }else if(this.filterForm.month == 'apr'){ 
                        total = achievement.april;
                    }else if(this.filterForm.month == 'may'){ 
                        total = achievement.may ;
                    }else if(this.filterForm.month == 'jun'){ 
                        total = achievement.june ;
                    }else if(this.filterForm.month == 'jul'){ 
                        total = achievement.july ;
                    }else if(this.filterForm.month == 'aug'){ 
                        total = achievement.august;
                    }else if(this.filterForm.month == 'sep'){ 
                        total = achievement.september;
                    }else if(this.filterForm.month == 'oct'){ 
                        total = achievement.october ;
                    }else if(this.filterForm.month == 'nov'){  
                        total = achievement.november ;
                    }else if(this.filterForm.month == 'dec'){ 
                        total = achievement.december ;
                    }else{
                        total = 0 ;
                    } 
                }   
                return total ;  
            },
            select_months(mo){ 
                //const d = new Date();  
                if(this.filterForm.month !=''){
                    if(this.filterForm.month ==  mo){
                        return true ;
                    }else{
                        return false ;
                    }
                }else{ 
                    if(this.filterForm.quarter !=''){
                        if(this.filterForm.quarter ==  1  && (mo == 'jan' || mo == 'feb'|| mo == 'mar')){
                            return true ;
                        }else if(this.filterForm.quarter ==  2  && (mo == 'apr' || mo == 'may'|| mo == 'jun')){
                            return true ;
                        }else if(this.filterForm.quarter ==  3  && (mo == 'jul' || mo == 'aug'|| mo == 'sep')){
                            return true ;
                        }else if(this.filterForm.quarter ==  4  && (mo == 'oct' || mo == 'nov'|| mo == 'dec')){
                            return true ;
                        }else if(this.filterForm.quarter ==  5  && (mo == 'jan' || mo == 'feb'|| mo == 'mar' || mo == 'apr' || mo == 'may' || mo == 'jun')){
                            return false ;
                        }else if(this.filterForm.quarter ==  6  && (mo == 'jul' || mo == 'aug'|| mo == 'sep' || mo == 'oct' || mo == 'nov'|| mo == 'dec' )){
                            return false ;
                        }else{
                            return false ;
                        }
                    }else{
                        return  true
                    }
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
            async getDept(){
                    let loader = this.$loading.show();
                    this.getDepartments( this.status ).then(({ data }) => { 
                        if(data.success){
                            loader.hide();
                            this.deptItems =  data.data ;
                            this.getItems(); 
                        }else{
                            loader.hide(); 
                        }
                    }); 
            },
            async  getKRA(){   
                await axios.get(this.api_url + "k_r_a_s?dept_id="+this.filterForm.dept_id, {
                        headers: {
                        "Content-Type": "application/json", 
                        Authorization: this.token ? `Bearer ${this.token}` : ""
                        },
                    })
                .then(({ data }) => {  
                    this.getItems();
                    this.kraItem =  data.data ;
                    console.log(this.kraItem );   
                });
            },
            async getKpi(){ 
                console.log(this.filterForm.kra_id);
                await axios.get(this.api_url + "k_p_i_s?kra_id="+this.filterForm.kra_id, {
                            headers: {
                            "Content-Type": "application/json", 
                            Authorization: this.token ? `Bearer ${this.token}` : ""
                            },
                        })
                .then(({ data }) => {  
                    this.getItems();
                        this.kpiItem =  data.data ;
                        console.log(this.roles );   
                });
            }, 

            async getItems() {
                if (this.filterForm.dept_id) {
                    let where = '?'; 
            
                    if (this.filterForm.dept_id) {
                        where += '&dept_id=' + this.filterForm.dept_id;
                    }
                    if (this.filterForm.kra_id) {
                        where += '&kra_id=' + this.filterForm.kra_id;
                    }
                    if (this.filterForm.kpi_id) {
                        where += '&kpi_id=' + this.filterForm.kpi_id;
                    }
                    let loader = this.$loading.show();
                    try {
                        await axios
                            .get(this.api_url + "kra_kpi_mos_tree" + where, {
                                headers: {
                                    "Content-Type": "application/json",
                                    Authorization: this.token ? `Bearer ${this.token}` : ""
                                },
                            })
                            .then(({
                                data
                            }) => {
                                if (data.success) {
                                    this.items = data.data ;
                                    console.log( this.items );
                                }
                                loader.hide();
                            });
                    } catch (error) {
                        loader.hide();
                    }
                }
            },
        
        },
        computed: {},
    };
    </script>
    <style>
        .color_red{
            color: red;
        }
        .gb_color_green{
            background-color: seagreen;
            color: seashell;
        }
        .gb_color_yellow{
            background-color: yellow;
            color: black;
        }
    </style>
    