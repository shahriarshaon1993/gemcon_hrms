<template>
     <!-- Notifications Dropdown Menu -->
	 <!-- v-show="unreadnotifications.length > 0">{{unreadnotifications.length}} -->
		      <li class="nav-item dropdown">
		        <!-- <a class="nav-link" data-toggle="dropdown" href="#">
		          <i class="far fa-bell"></i> 
		          <span class="badge badge-warning navbar-badge" v-show="unreadnotifications.leaveApplication.length > 0"> {{unreadnotifications.leaveApplication.length}} </span>
		        </a> -->

            <a class="nav-link" data-toggle="dropdown" href="#">
		          <i style="font-size: 18px;" class="far fa-bell"></i>
		          <span style="margin-top: -11px;" class="badge badge-danger navbar-badge">
                <!-- {{unreadnotifications.leaveApplication.length}} -->
              </span>
		        </a>
		        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		          <span class="dropdown-item dropdown-header">{{unreadnotifications.length}} Notifications</span>
              <div v-for="(form_data, index) in unreadnotifications.leaveApplication" v-bind:key="form_data.id" i=index> 
                <div class="dropdown-divider"></div>
                <a @click="markAsRead(form_data.id)" class="dropdown-item">
                  <i class="fa fa-smile mr-2"></i> {{ form_data.log_name}}
                  <!-- 4 Leave Application -->
                  <span class="float-right text-muted text-sm">{{ form_data.tims}} mins</span><br>
                  <small style="margin-left: 24px;"> {{form_data.employee_id}} - {{ form_data.user_name}} </small>
                </a>
              </div>
              
		          <!-- <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <i class="fas fa-users mr-2"></i> 8 Service Requests
		            <span class="float-right text-muted text-sm">12 hours</span>
		          </a>
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item">
		            <i class="fas fa-file mr-2"></i> 3 Late Application
		            <span class="float-right text-muted text-sm">2 days</span>
		          </a> -->
		          <div class="dropdown-divider"></div>
		          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
		        </div>
		      </li>
		      <!-- Notifications Dropdown Menu -->
</template>
<script>
    export default {

        data(){
            return {
                unreadnotifications: {},
            }
        }, 
        created() {
          // this.timer = setInterval(() => {
          //   this.getNotifications();
          // }, 1000)
          
        },
        methods: {
            getNotifications(){
                axios.get(URL.baseUrl("unreadNotifications_get")).then((response) => {
                    this.unreadnotifications = response.data;
                    // console.log( this.unreadnotifications);
                    // console.log( "unreadnotifications");
                }).catch((errors) => {
                    console.log(errors)
                });
            }, 
            markAsRead(id){
                //let uri = URL.baseUrl('edit/otherCreate/'+id);
                
                axios.get(URL.baseUrl("markAsRead_get/"+id)).then((response) => {
                    //location.reload()
                    this.getNotifications();
                }).catch((errors) => {
                    console.log(errors)
                });
            }
        },
       
    }
</script>