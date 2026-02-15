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
                                   <li class="breadcrumb-item"><router-link :to="{ path: '/' }"><i class="bx bx-home-alt"></i></router-link>
                                    </li>
                                    <li class="breadcrumb-item active"> Monthly Date range Form
                                    </li>
                                     
                                </ol> 
                            </div>
                        </div>
                        <div class=" col-sm-3"> 
                            <a class="btn btn-primary add-btn" @click="update()" > <i class="bx bx-add-alt"></i> Update</a>       
                        </div> 
                    </div>
                </div>
            </div> 
            <div class="content-body">
                <!-- Zero configuration table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                  
                                <div class="card-content">
                                    <div class="card-body card-dashboard"> 
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr> 
                                                        <th>SL</th>
                                                        <th>Dept Name</th>
                                                        <th>
                                                            <div v-if="checked_all == true" class="row">
                                                                <div   class="col-12 col-sm-6 ">
                                                                    <label class="control-label"> Start Date </label>
                                                                    <fieldset class="form-group"> 
                                                                        <datepicker  @closed="startDateClosedFunction" :disabled-dates="state.disabledDates"  v-model="start_date" name="start_date" class="form-control"  ></datepicker> 
                                                                    </fieldset>
                                                                </div>
                                                                <div   class="col-12 col-sm-6  ">
                                                                    <label class="control-label">End Date </label>
                                                                        <fieldset class="form-group"> 
                                                                            <datepicker  @closed="endDateClosedFunction" :disabled-dates="state.disabledDates"  v-model="end_date" name="end_date" class="form-control"  ></datepicker>
                                                                        </fieldset>
                                                                </div> 
                                                            </div>
                                                        </th>
                                                        <th>Status <input type="checkbox" value="1"  @change="check()"  id="checked_all" v-model="checked_all"> </th>
                                                         
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(row ,index) in items" :key="row.id">
                                                        <td>{{ index + 1 }}</td>  
                                                        <td>{{ row.name }}</td>  
                                                        <td v-if="row.monthly_date_range.status">
                                                            <div class="row  ">
                                                                <div   class="col-12 col-sm-6 ">
                                                                    <label class="control-label"> Start Date </label>
                                                                     <fieldset class="form-group"> 
                                                                        <datepicker  @closed="datepickerClosedFunction" :disabled-dates="state.disabledDates"  v-model="row.monthly_date_range.start_date" name="start_date" class="form-control"  ></datepicker> 
                                                                    </fieldset>
                                                                </div>
                                                                <div   class="col-12 col-sm-6  ">
                                                                    <label class="control-label">End Date </label>
                                                                        <fieldset class="form-group"> 
                                                                            <datepicker  @closed="datepickerClosedFunction" :disabled-dates="state.disabledDates"  v-model="row.monthly_date_range.end_date" name="end_date" class="form-control"  ></datepicker>
                                                                        </fieldset>
                                                                </div> 
                                                            </div>
                                                           
                                                        </td>
                                                        <td v-if="!row.monthly_date_range.status"></td>
                                                        <td>
                                                            <input type="checkbox"  value="1"  v-model="row.monthly_date_range.status">  
                                                        </td> 
                                                    </tr> 
                                                    <tr v-if="items.length < 1">
                                                        <td colspan="4">Data not found</td>
                                                    </tr> 
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
import { Form } from "vform"; 
import axios from "../../axios_instance";
import Datepicker from 'vuejs-datepicker';
export default {
  props: { 
  },
  components: {
    Datepicker
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {
       
        start_date: ''  ,
        end_date: '' ,
        checked_all :  false ,
        checkbox :  false ,
        base_url: window.base_url,
        api_url: window.api_url, 
        token: this.$localStorage.get("d_token"),
        items:[],  
        status :  '' ,
        updateForm: new Form({ 
           items : '',   
        }),
        state : {
                disabledDates: {
                    to:  new Date(2021, 0, 0), // Disable all dates up to specific date
                    from: new Date(2022, 0, 0)  // Disable all dates after specific date
                    
                }
            }
    };
  },
  created() {  
    this.getItems();
  },
  methods: {
    check(){  
        console.log( this.checked_all ); 
        for (let index = 0; index < this.items.length; index++) { 
            this.items[index].monthly_date_range.status = this.checked_all;
        } 
    },
    datepickerClosedFunction(){

    },
    startDateClosedFunction(){
        console.log(this.start_date ); 
        for (let index = 0; index < this.items.length; index++) { 
            this.items[index].monthly_date_range.start_date = this.start_date  ;
        } 
    }, 
    endDateClosedFunction(){
        console.log(this.start_date ); 
        for (let index = 0; index < this.items.length; index++) { 
            this.items[index].monthly_date_range.end_date = this.end_date  ;
        } 
    }, 
    update(){
 
        let loader = this.$loading.show();
        this.updateForm.items = this.items ;  
        this.updateForm.post(this.api_url + "department_monthly_report_update", {
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
           //this.$router.push('/department');
       },(error)=>{
         console.log(error);
          loader.hide(); 
       })
      
   } ,
    
       async getItems(){
           //departments_all
           let loader = this.$loading.show();
           await axios.get(this.api_url + "monthly_date_range", {
                    headers: {
                    "Content-Type": "application/json", 
                    Authorization: this.token ? `Bearer ${this.token}` : ""
                    },
                })
            .then(({ data }) => {  
                this.items =  data.data
                loader.hide();
                console.log(this.WingsItems );   
            }); 
           
      }
  },
  computed: {},
};
</script>
