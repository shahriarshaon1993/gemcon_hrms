<template>
    <div>
        <div class="app-content content"> 
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-1 mt-0">
                    <div class="row breadcrumbs-top">
                        <div class="col-12"> 
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                     <li class="breadcrumb-item"><router-link :to="{ path: '/' }"><i class="bx bx-home-alt"></i></router-link>
                                    </li>
                                    <li class="breadcrumb-item  "> <router-link :to="{ path: '/department' }"> Department </router-link>
                                    </li>
                                    <li class="breadcrumb-item active"> Edit Department ({{editForm.name}})
                                    </li>
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">  
                <section class="input-validation">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Edit Department</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form @submit.prevent="update()">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <div class="controls">
                                                            <input type="text" name="name" v-model="editForm.name" :class="{  'is-invalid': editForm.errors.has('name'),  }" class="form-control" data-validation-required-message="This field is required" placeholder=" Name">
                                                        </div>
                                                    </div>
                                                     
                                                     
                                                    <div class="form-group">
                                                         <label for="Profession">Status</label>
                                                         <div class="controls">
                                                            <select  id="Profession" name="status" v-model="editForm.status" :class="{  'is-invalid': editForm.errors.has('status'),  }" class="form-control">
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option> 
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div> 
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Input Validation end -->
            </div>
        </div>
    </div>
    </div> 
</template>
<script>
import { Form } from "vform"; 
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
        id : this.$route.params.id,
        item : {}, 
        editForm: new Form({ 
            name: "",  
            status: 1, 
        })
    };
  },
  created() {  
    this.getItem("departments/"+this.id).then(({ data }) => {  
         if(data.success){
              this.item =  data.data ; 
              this.editForm.name =  this.item.name ; 
              this.editForm.status =  this.item.status ; 
          } 
     }); 
 
  },
  methods: {  
    update(){ 
      try {
         let loader = this.$loading.show();
        this.editForm.put(this.api_url + "departments/"+this.id, {
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
            this.$router.push('/department');
        },(error)=>{
          console.log(error);
           loader.hide(); 
        })
      } catch (error) {
         // loader.hide(); 
        console.log(error);
      }
    }
  },
  computed: {},
};
</script>
