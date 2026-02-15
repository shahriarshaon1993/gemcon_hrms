<template>
<header>
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right"> 
                        
                         <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up"  v-if="unread > '0'">{{unread}}</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                 <li class="dropdown-menu-header">
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between">
                                        <span class="notification-title" v-if="unread == '0'">No New Notification</span>

                                        <!-- <span class="text-bold-400 cursor-pointer">Mark all as read</span> -->
                                    </div>
                                </li>  

                                 
                                <li class="scrollable-container media-list" v-if="!notification">
                                    
                                    <div class="media d-flex align-items-center">
                                        Loading..
                                    </div>
                                        
                                </li>
                                <li class="scrollable-container media-list" v-if="!notification.length">
                                    
                                    <div class="media d-flex align-items-center">
                                        No Data Found
                                    </div>
                                        
                                </li>


                               <!--  <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Read all notifications</a></li>  -->
                            </ul>
                        </li> 
                        <li @click="refresh()" class="dropdown dropdown-user nav-item">
                            <fieldset class="form-group">
                                <i class="bx 
                                bxs-analyse" style="font-size: 35px; padding-top: 10px;  padding-right: 20px;"></i>
                            </fieldset>
                        </li>
                        <li class="dropdown dropdown-notification nav-item"> 
                               
                        </li>
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
                                </div>
                                <span>
                                    <img class="round" :src="base_url+'assets/app-assets/images/profile/default-user.png'" alt="avatar" height="40" width="40" />
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pb-0">
                                <a class="dropdown-item" href="">
                                    <i class="bx bx-user mr-50"></i>
                                    <router-link   :to="{ path: '/profile' }"> <i class="bx bx-add-alt"></i> Profile  </router-link>
                                    
                                </a> 
                                <div class="dropdown-divider mb-0"></div>
                                <a class="dropdown-item" @click="Logout()">
                                    <i class="bx bx-power-off mr-50"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" style="touch-action: none; user-select: none;" data-scroll-to-active="true"> 
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="../">
                        <div class="brand-logo">
                            <img class="logo" :src="base_url+'assets/app-assets/images/logo/logo.png'" />
                        </div> 
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                        <i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                        <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item" >
                    <router-link :to="{ path: '/' }"> <i class="bx bx-home-alt"></i><span class="menu-item" data-i18n="Analytics">Dashboard</span> </router-link> 
                </li>
                
                <li   class=" nav-item"><a href="#" class="icon_right"><i class="bx 
                    bxl-redux"></i><span class="menu-title" data-i18n="Content">Entry</span>  <i class=" bx bx-chevron-down "></i></a>
                    
                    <ul class="menu-content">

                        <!-- <li   class="nav-item ">
                            <router-link :to="{ path: '/kra_kpi_mos' }"> <i class="bx bx-sitemap"></i><span class="menu-item" data-i18n="Analytics"> KRA KPI - 2021  </span> </router-link>
                        </li> -->
                        <li   class="nav-item ">
                            <router-link :to="{ path: '/kra_kpi_mos_list' }"> <i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Analytics"> KRA KPI List  </span> </router-link>
                        </li>
                        <li class="nav-item "   >
                            <router-link :to="{ path: '/kra_kpi_setting' }"> <i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Analytics">KRA & KPI Settings </span> </router-link>
                        </li>
                        <li class="nav-item "   >
                            <router-link :to="{ path: '/weightage_list' }"> <i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Analytics">Weightage List</span> </router-link>
                        </li>
                        <li class="nav-item "   >
                            <router-link :to="{ path: '/wings' }"> <i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Analytics">Second Layer</span> </router-link>
                        </li>
                        
                        
                    </ul>
                </li>

                
                <li class=" navigation-header"   ><span>Report </span></li>
                <li class="nav-item "   >
                    <router-link :to="{ path: '/bpt_report' }"> <i class="bx bx-bar-chart"></i><span class="menu-item" data-i18n="Analytics">BPT Report</span> </router-link>
                </li>  
                 
            </ul>
        </div>
    </div>
</header>
</template>

<script>
import axios from "./axios_instance";
export default {
    props: {},
    components: { 
    },
    data() {
        return {
            // token: this.$localStorage.get("d_token"),
            base_url: window.base_url,
            api_url: window.api_url,
            // user_data: JSON.parse(this.$localStorage.get("user")).data,
            role_id : '',
            // user: JSON.parse(this.$localStorage.get("user")).data,
            is_login: false,
            user_type: null, 
            notification: '',
            unread: ''
        };
    },
   
    methods: {
        changeYear(){  
            // this.$localStorage.set("year", this.year ); 
            this.$router.go(this.$router.currentRoute)
        },
        refresh(){
            this.$router.go(this.$router.currentRoute)  
        },
        Logout() {
            axios
                .get(this.api_url + "auth/logout", {
                    headers: {
                        "Content-Type": "application/json",
                        // Authorization: this.token ? `Bearer ${this.token}` : "",
                    },
                })
                .then((data) => {
                    console.log(data);
                });
            // this.$localStorage.remove("user");
            // this.$localStorage.remove("d_token");
            this.$router.push("/login");
        },
        async getNotification() {
            try {
                await axios
                    .get(this.api_url + "get-notification", {
                        headers: {
                            "Content-Type": "application/json",
                            // Authorization: this.token ? `Bearer ${this.token}` : ""
                        },
                    })
                    .then(({
                        data
                    }) => {
                        if (data) {
                            this.notification = data.notification ;
                            this.unread = data.unread ;

                            
                            console.log( this.notification );
                        }
                        //loader.hide();
                    });
            } catch (error) {
                console.log(error);
                //loader.hide();
            }
        },
         notificationRead(notifid) {
            //alert(notifid);
            axios
                .get(this.api_url + "read-notification?nid="+notifid, {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: this.token ? `Bearer ${this.token}` : "",
                    },
                })
                .then((data) => {
                    console.log(data);
                });
            
        },
    },
    created() { 
        // this.role_id  =  this.user_data.role_id ;
        // if (this.$localStorage.get("d_token")) { 
        //     this.is_login = true;
        //     this.user_type = this.user.type; 
        // } else {
        //     this.is_login = false;
        // }

        // this.getNotification();
    },
    computed: {},
};
</script>
