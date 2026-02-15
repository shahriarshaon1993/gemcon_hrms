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
                                    <li class="breadcrumb-item active"> Department
                                    </li>
                                     
                                </ol> 
                            </div>
                        </div>
                        <div class=" col-sm-3"> 
                            <router-link class="btn btn-primary add-btn" :to="{ path: '/new_department' }">   <i class="bx bx-add-alt"></i> New Department  </router-link>
                                          
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
                                                        <th>Status</th>  
                                                        <th>Action</th>  
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="row in items" :key="row.id">
                                                        <td > <a @click="popUp(row)">{{ row.name }}</a></td>  
                                                        <td>
                                                            <a v-if="row.status ==  0 "><div class="badge badge-pill badge-light-danger mr-1">Inactive</div></a>
                                                            <a v-if="row.status ==  1 " ><div class="badge badge-pill badge-light-info mr-1">Active</div></a> 
                                                            <div class="dropup" style="float: inline-start;">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right"> 
                                                                     <a class="dropdown-item" @click="statusChange(row , row.status == 0 ? 1  : 0  )"><i class="bx bx-edit-alt mr-1"></i> {{ row.status == 0 ? ' Active '  :  'Inactive'}} </a>  
                                                                </div>
                                                            </div> 
                                                        </td>
                                                        <td>
                                                            <div class="dropup">
                                                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                                                </span>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                     <router-link class="dropdown-item" :to="{ path: '/edit_department/'+row.id }"><i class="bx bx-edit-alt mr-1"></i> edit </router-link>
                                                                     <a class="dropdown-item" @click="delete_row(row.id)"><i class="bx bx-trash mr-1"></i> Delete</a>  
                                                                </div>
                                                            </div> 
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
                <modal width="60%" height="70%" style="padding:50px" name="popup-singel">
                    <i @click="hide_pop()" class="bx bx-x-circle  x-circle"></i>
                    <div class="app-content ">
                       <div class="card">
                          <table class="table table-bordered table-striped table-sm">
                             <tbody> 
                                 <tr>
                                    <td>Department Name</td>
                                    <td>{{item.name}}</td>
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
export default {
  props: { 
  },
  components: {
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
        status :  '' ,
      
    };
  },
  created() {  
    this.getItems();
  },
  methods: {
    async popUp(item){
        this.item =  item ;
        let loader = this.$loading.show();
        
        await axios.get(this.api_url + "department_assigns?dept_id="+item.id, {
                headers: {
                "Content-Type": "application/json", 
                Authorization: this.token ? `Bearer ${this.token}` : ""
                },
            })
        .then(({ data }) => {  
            loader.hide(); 
            this.dept_users =  data.data ;  
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
           await axios.get(this.api_url + "departments_all", {
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
