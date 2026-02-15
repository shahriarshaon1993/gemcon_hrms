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
                            <div class=" col-sm-3">
                                <router-link class="btn btn-primary add-btn" :to="{ path: '/add_daily_work' }"> <i class="bx bx-add-alt"></i> Add daily work </router-link>
                            </div>
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
                                                    <tr>
                                                        <th>Sl</th>
                                                        <th>KRA</th>
                                                        <th>Weightage</th>
                                                        <th>KPI</th>
                                                        <th>MOS</th> 
                                                        <th>Jan</th>
                                                        <th>Feb</th>
                                                        <th>Mar</th>
                                                        <th>Apr</th>
                                                        <th>May</th>
                                                        <th>Jun</th>
                                                        <th>Jul</th>
                                                        <th>Aug</th>
                                                        <th>Sep</th>
                                                        <th>Oct</th>
                                                        <th>Nov</th>
                                                        <th>Dec</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template v-for="(item , index ) in items" >  
                                                            <template v-for="kpi_item in item.kpijoin"   >  
                                                                <template v-for="mos_item  in kpi_item.mosjoin" :key="mos_item.id">
                                                                    <tr>  
                                                                        <td>{{index + 1 }}</td> 
                                                                        <td>{{ item.kra_name }}</td>
                                                                        <td>{{ item.kra_weight }}</td>
                                                                        <td>{{ kpi_item.kpi_name }} </td>
                                                                        <td>{{ mos_item.mos_name }}</td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.january : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.february : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.march : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.april : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.may : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.june : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.july : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.august : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.september : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.october : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.november : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td><i v-if=" mostargetjoin  ? mos_item.mostargetjoin.december : 0 > 0" class="bx bx-map"></i> </td>
                                                                        <td> 
                                                                            <button class="btn btn-success btn-sm" > Add || Edit KPI  </button>
                                                                            <router-link class="btn btn-primary add-btn" :to="{ path: '/measure_of_success/'+ kpi_item.id }"> <i class="bx bx-add-alt"></i>MOS  </router-link> 
                                                                            <a class="btn btn-primary btn-sm" href="https://bpt.ssgbd.com/value_fwr/125/378">FWR</a> 
                                                                        </td> 
                                                                    </tr> 
                                                                </template>
                                                            </template>  
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
                base_url: window.base_url,
                api_url: window.api_url,
                token: this.$localStorage.get("d_token"),
                items: [],   
                status: '',
            };
        },
        created() { 
            this.getItems(); 
        },
        methods: {
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
                let where = '?'; 
          
                // if (this.status) {
                //     where += '&status=' + this.status;
                // }
                let loader = this.$loading.show();
                try {
                    await axios
                        .get(this.api_url + "kra_kpi_mos" + where, {
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
            },
        
        },
        computed: {},
    };
    </script>
    