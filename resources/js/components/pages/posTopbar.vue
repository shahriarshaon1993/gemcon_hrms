<template>
	<div> 
	  <!-- Navbar -->
	 
		    <!-- Left navbar links -->
		    <ul class="navbar-nav">
		      <li class="nav-item">
		        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		      </li>
		      <li class="nav-item d-none d-sm-inline-block">
		        <a href="index.php" class="nav-link">Home</a>
		      </li>
		      <li class="nav-item d-none d-sm-inline-block">
		        <a href="#" class="nav-link">Contact</a>
		      </li>
		    </ul>
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar"  v-model="message" @keyup.enter="showMessage1" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" @click="showMessage" type="submit">
              <i class="fas fa-search"> </i>
            </button>
          </div>
        </div>
	</div>
		
</template>

<script>
    export default {
        data(){
            return {
                topMenuData:[],
                 message: '',
            }
        },
        methods:{
        	
            // topmenuList(){
            // 	console.log('helloS');
            //     axios.get(URL.baseUrl('getmenu'))
            //     .then(res => {
            //         this.topMenuData=res.data.menuTopbar;
            //         console.log()
            //     })
            //     .catch(error => {
            //         console.log(error);               
            //     });
            // },



        },
        created() {
            // this.topmenuList();
            // this.jequerys();
        }
    }
</script>

