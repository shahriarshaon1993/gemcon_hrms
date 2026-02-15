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
                                    <li class="breadcrumb-item active"> Department
                                    </li>
                                     <li class="breadcrumb-item  ">
                                         <router-link :to="{ path: '/department-add' }">  <button class="btn btn-primary"> <i class="bx bx-add-alt"></i> New Department</button> </router-link>
                                          
                                     </li>
                                </ol> 
                            </div>
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
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Department Name</th>
                                                        <th>Budget</th>
                                                        <th>Experience</th>  
                                                        <th>Variance</th>  
                                                        <th>Report</th>  
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>IT</td>
                                                        <td>200000</td>
                                                        <td>100000</td>  
                                                        <td> <i class="bx bxs-right-arrow-circle success"></i></td> 
                                                        <td>
                                                            <a href="Budget.php"><div class="badge badge-pill badge-light-danger mr-1">Budget</div></a>
                                                            <a href="Exprenses.php"><div class="badge badge-pill badge-light-info mr-1">Exprenses</div></a> 
                                                        </td>  
                                                    </tr> 

                                                     <tr>
                                                        <td>Sales Admin</td>
                                                        <td>200000</td>
                                                        <td>50000</td>  
                                                        <td> <i class="bx bxs-down-arrow-circle warning"></i></td> 
                                                        <td>
                                                            <a href="Budget.php"><div class="badge badge-pill badge-light-danger mr-1">Budget</div></a>
                                                            <a href="Exprenses.php"><div class="badge badge-pill badge-light-info mr-1">Exprenses</div></a> 
                                                        </td>  
                                                    </tr>
                                                       <tr>
                                                        <td>SSG AGRO</td>
                                                        <td>200000</td>
                                                        <td>220000</td>  
                                                        <td> <i class="bx bxs-right-top-arrow-circle danger"></i></td> 
                                                        <td>
                                                            <a href="Budget.php"><div class="badge badge-pill badge-light-danger mr-1">Budget</div></a>
                                                            <a href="Exprenses.php"><div class="badge badge-pill badge-light-info mr-1">Exprenses</div></a> 
                                                        </td>  
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Department Name</th>
                                                        <th>Budget</th>
                                                        <th>Experience</th> 
                                                         <th>Variance</th>  
                                                         <th>Report</th> 
                                                    </tr>
                                                </tfoot>
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
export default {
  props: { 
  },
  components: {
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {
      base_url: window.base_url,
      
    };
  },
  created() { 
  },
  methods: {},
  computed: {},
};
</script>
