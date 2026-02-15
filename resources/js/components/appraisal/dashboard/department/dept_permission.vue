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
                                    <li class="breadcrumb-item active"> Department permission
                                    </li>
                                     
                                </ol> 
                            </div>
                        </div>
                        <div class=" col-sm-3"> 
                            <a class="btn btn-primary add-btn" @click="show_pop()" > <i class="bx bx-add-alt"></i>Update permission </a>               
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
                                                        <th>Department Name </th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="row in items" :key="row.id">
                                                        <td > <a @click="popUp(row)">{{ row.name }}</a></td>  
                                                       
                                                        
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
              
                <modal width="75%" height="60%" style="padding:50px" name="popup-singel">
                    <i @click="hide_pop()" class="bx bx-x-circle  x-circle"></i>
                    <div class="app-content ">
                       <div class="card"> 
                          <table class="table table-bordered table-striped table-sm">
                             <tbody> 
                                <tr>
                                 
                                    <th colspan="3"  class="text-center">  

                                        <div class=" col-sm-12">
                                          
                                            <fieldset class="form-group">
                                                <multiselect 
                                                v-model="items" 
                                                :options="dept_selects" 
                                                :multiple="true" 
                                                placeholder="Select(Dept)" 
                                                :label="'name'" 
                                                track-by="id" 
                                                :searchable="true"
                                                :close-on-select="false"
                                                :show-labels="false" 
                                                >
                                                    <template slot="selection" slot-scope="{ values , isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                                                </multiselect>
                                            </fieldset>
                                        </div>
                                   </th> 
                               
                                   <th class="text-center">
                                      <button @click="create()" class="btn btn-success">Save</button>
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
import { Form } from "vform"; 
import axios from "../../axios_instance";
import Multiselect from 'vue-multiselect'; 
export default {
  props: { 
  },
  components: {
    Multiselect
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {
        base_url: window.base_url,
        api_url: window.api_url, 
        token: this.$localStorage.get("d_token"),
        items:[], 
        item : [], 
        dept_users : [],
        dept_selects : [],
        user_id : this.$route.params.user_id,
        status :  '' ,
        dept_permission: new Form({  
            dept_selects : "", 
         }),
      
    };
  },
  created() {  
    this.getItems();
  },
  methods: {
    async show_pop(){ 
        let loader = this.$loading.show(); 
        await axios.get(this.api_url + "departments?status=1", {
                headers: {
                "Content-Type": "application/json", 
                Authorization: this.token ? `Bearer ${this.token}` : ""
                },
            })
        .then(({ data }) => {  
            loader.hide(); 
            this.dept_selects =  data.data ;  
        }); 
        this.$modal.show("popup-singel"); 
    },
    hide_pop() {
        this.$modal.hide("popup-singel");
    }, 
    async statusChange(item , status){
        let editForm =  new Form({    
            status: status,
            name : item.name
        })
        try {
         let loader = this.$loading.show();
            editForm.put(this.api_url + "departments/"+ item.id, {
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
                this.getItems();
            },(error)=>{
            console.log(error);
            loader.hide(); 
            })
        } catch (error) {
            // loader.hide(); 
            console.log(error);
        }
    }, 
    async delete_row(id){ 
        let loader = this.$loading.show();
        try {
            await axios
            .delete(this.api_url + "departments/"+id, {
                    headers: {
                    "Content-Type": "application/json", 
                    Authorization: this.token ? `Bearer ${this.token}` : ""
                    },
                })
            .then(({ res }) => {  
                    this.$toasted.show(res.data.message, {
                        theme: "bubble",
                        duration: 5000,
                        position: "bottom-right",
                        });
                    this.getItems();
               
                loader.hide();
            });
        } catch (error) {
            loader.hide();
        }
      },
       async getItems(){
           //departments_all
           let loader = this.$loading.show();
           await axios.get(this.api_url + "dept_permission?user_id="+this.user_id, {
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
           
      },
      create(){ 
                try {
                    let loader = this.$loading.show(); 
                    this.dept_permission.dept_selects = this.items ;
                    this.dept_permission.user_id = this.user_id ;
                    this.dept_permission.post(this.api_url + "dept_permission", {
                        headers: {
                        "Content-Type": "application/json", 
                        Authorization: this.token ? `Bearer ${this.token}` : ""
                        },
                    }).then((res) => { 
                        if(res.data.success){
                            this.$toasted.show(res.data.message, {
                                theme: "bubble",
                                duration: 5000,
                                position: "bottom-right",
                            });
                        } 
                        loader.hide();  
                        this.hide_pop();
                       // this.$router.push('/daily_work');
                    },(error)=>{
                    console.log(error);
                    loader.hide(); 
                    })
                } catch (error) {
                    // loader.hide(); 
                    console.log(error);
                }
                },
                async dept() {
                this.getDepartments().then(({ data }) => {
                    if (data.success) {
                    this.DepartmentsItems = data.data;
                    }
                });
                }, 
  },
  computed: {},
};
</script>
