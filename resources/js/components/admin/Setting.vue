<template>
	<div>
		<div class="widget box">
	        <div class="widget-header customer-config">
                <div class="customer-config-list">
                	<ul>
                		<li @click="setActive('companyInfo')" :class="isActive('companyInfo')">Company Information</li>
                		<li  @click="setActive('preference')" :class="isActive('preference')">Preferences</li>
                		<li  @click="setActive('emailsetup')" :class="isActive('emailsetup')">Email Setup</li>
                	</ul>
                </div>
                <keep-alive>
                	<component :is='activeItem'></component>
                </keep-alive>
	        </div>
    	</div>
	</div>
</template>

<script>
    import { required} from "vuelidate/lib/validators";
    import CompanyInformation from './CompanyInformation.vue';
    import Prefrence from './preference.vue';
    import emailsetup from './EmailSetup.vue';
    export default {
    	data(){
    		return {
    			activeItem:'companyInfo'
    		}
    	},
    	created(){
            /*this.getResults(1);*/
        },
        methods:{	
        	isActive(menuItem) {
		      if(this.activeItem === menuItem){
		      	return 'active'
		      }else{
		      	return ''
		      }
		    },
		    setActive(menuItem) {
		      this.activeItem = menuItem // no need for Vue.set()
		    }
        },
        components:{
        	companyInfo:CompanyInformation,
        	preference:Prefrence,
        	emailsetup:emailsetup
        }
    }
</script>