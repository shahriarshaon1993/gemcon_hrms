<template>
     <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/dashboards" class="brand-link">
          <span v-if="logos">
            
            <!-- <img src="admin_assets/images/{{logos}}" alt="Gemcon Group Logo" class="brand-image elevation-3"> -->
            <img :src="`company_logo/${logos}`" alt="Gemcon Group Logo" class="brand-image elevation-3">
          </span>
          <span v-else> 
               <img src="admin_assets/images/gemcon-logo.png" alt="Gemcon Group Logo" class="brand-image elevation-3">
          </span>
         <!-- {{Sbu_name}} -->
          <span class="brand-text font-weight-light"><strong>{{Sbu_name}}</strong></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar Menu -->
          <!-- v-if="this.uris['3']=='admin'" -->
          <!-- {{ menuListData[0].menu_name }} -->
          <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- <li v-if="menuListData[0].menu_name == 'Employee'" class="nav-item" :class="$route.meta.title == 'Dashboard'?'current':''">
                <router-link to="/" class="nav-link active">
                  <i class="fa fa-tachometer-alt" ></i>
                  <p> Dashboard</p>
                </router-link>
              </li>
              <li v-else-if="menuListData[0].menu_name == 'Payroll Management'" class="nav-item" :class="$route.meta.title == 'Dashboard'?'current':''">
                <router-link to="/payroll" class="nav-link active">
                  <i class="fa fa-tachometer-alt" ></i>
                  <p> Dashboard</p>
                </router-link>
              </li> -->

              <li class="nav-item" :class="$route.meta.title == 'Dashboard'?'current':''">
                <router-link to="/" class="nav-link active">
                  <i class="fa fa-tachometer-alt" ></i>
                  <p> Dashboard</p>
                </router-link>
              </li>

               <li class="nav-item has-treeview" v-for="list in menuListData" :class="$route.meta.title == list.menu_name?'current':''">
                   <router-link  class="nav-link" :to="list.menu_link ? list.menu_link :''">
                       <!-- <i class="fa fa-users nav-icon"></i> -->
                        <i :class="list.menu_icon"></i>
                      <p> 
                       {{list.menu_name}}
                         <i v-if="list.children" class="fas fa-angle-left right"></i>
                        <!-- <span class="badge badge-info right">6</span> -->
                      </p> 
                  </router-link>
                <ul class="nav nav-treeview" v-if="list.children">
                  <li class="nav-item" v-for="sub in list.children" :class="$route.meta.subtitle == sub.menu_name?'current':''">
                      <router-link :to="sub.menu_link ? sub.menu_link :''" class="nav-link">
                      <i :class="sub.menu_icon"></i>
                      <p> {{sub.menu_name}} </p>
                      <i v-if="sub.children" class="fas fa-angle-left right"></i>
                    </router-link>
                    <ul class="nav nav-treeview" v-if="sub.children">
                      <li class="nav-item" v-for="deep in sub.children"  :class="$route.meta.deeptitle == deep.menu_name?'current':''">
                          <router-link :to="deep.menu_link" class="nav-link">
                          <i :class="deep.menu_icon"></i>
                          <p> {{deep.menu_name}} </p>
                        </router-link>
                      </li>
                    </ul>
                  </li>
                 
               </ul>
             </li>
           </ul>



<!--             <ul id="nav">
              <li  :class="$route.meta.title == 'Dashboard'?'current':''">
                  <router-link to="/">
                      <i class="icon-dashboard"></i>
                      Dashboard
                  </router-link>
              </li>
              <li class="nav-item has-treeview" v-for="list in menuListData" :class="$route.meta.title == list.menu_name?'current':''">
                  <router-link  class="nav-link" :to="list.menu_link ? list.menu_link :''">
                      <i :class="list.menu_icon"></i>
                      {{list.menu_name}}
                  </router-link>
                  <ul class="sub-menu" v-if="list.children">
                      <li v-for="sub in list.children" :class="$route.meta.subtitle == sub.menu_name?'current':''">
                          <router-link :to="sub.menu_link ? sub.menu_link :''">
                              <i :class="sub.menu_icon"></i>
                              {{sub.menu_name}}
                              <span v-if="sub.children" class="arrow"></span>
                          </router-link>
                          <ul class="sub-menu" v-if="sub.children">
                              <li v-for="deep in sub.children"  :class="$route.meta.deeptitle == deep.menu_name?'current':''">
                                  <router-link :to="deep.menu_link">
                                      <i :class="deep.menu_icon"></i>
                                      {{deep.menu_name}}
                                  </router-link>
                              </li>
                          </ul>
                      </li>
                  </ul>
              </li>
            </ul> -->
      
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
</template>

<script>
    export default {
        data(){
            return {
                menuListData:[],
                pathes:'',  
                logos:'',
                Sbu_name:'',
                uris:''
            }
        },
        created(){
          // this.uris = URL.baseUrl('').split('/');
        },
        methods:{
            getmenuList(){
              // alert('ddd');
                // console.log('okk');
                this.pathes=this.$route.fullPath;
               console.log(this.$route.fullPath);
                axios.get(URL.baseUrl('getmenu'))
                .then(res => {
                   console.log(res.data.menu_list);
                    // alert(res.data.menu_list);
                    this.menuListData=res.data.menu_list;
                    this.logos=res.data.logos;
                    this.Sbu_name=res.data.Sbu_name;
                    // setTimeout(function(){
                    //     initAllJs();
                    // }, 1000);
                })
                .catch(error => {
                    console.log(error);               
                });
            }
        },
        created() {
            this.getmenuList();
        }
    }

</script>