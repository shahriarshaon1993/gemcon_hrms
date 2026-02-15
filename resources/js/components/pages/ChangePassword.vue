<template>
	<div class="widget box">
        <div class="widget-header">
            <h4><i class="icon-reorder"></i>Change Password</h4>
            <div class="toolbar no-padding ">
                <div class="btn-group"> <span class="btn btn-xs  widget-collapse"><i class="icon-refresh"> </i></span> </div>
            </div>
        </div>
        <div class="widget-content">
        	<form @submit.prevent="submitPassword({chang_pass:'user/passwordchange'})" class="form-horizontal  row-border" id="validate-1">
        		<div class="change-passwor-container t">
	                <div class="my-form-wraper">
	                    <!-- <div v-if="errors" class="alert alert-danger">
	                        <div v-for="(error, index) in errors">
	                            <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
	                            <span v-if="!isObject(error)">{{error}}</span>
	                        </div>
	                    </div> -->
	                    <div class="form-group modify-input">
	                        <label class="col-md-3 control-label">Old Password<span class="required">*</span></label>
	                        <div class="col-md-9" >
	                            <input v-model="form_data.oldpassword"  type="password" class="form-control required">
	                        </div>
	                    </div>
	                    <div class="form-group modify-input">
	                        <label class="col-md-3 control-label">New Password<span class="required">*</span></label>
	                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.newpassword.$error }">
	                        	{{$v.form_data.newpassword.$touch()}}
	                            <input v-model="form_data.newpassword"  type="password" class="form-control required">
	                        </div>
	                    </div>
	                    <div class="form-group modify-input">
	                        <label class="col-md-3 control-label">Confirm Password<span class="required">*</span></label>
	                        <div class="col-md-9" :class="{ 'has-error': $v.form_data.confirmpassword.$error }">
	                        	{{$v.form_data.confirmpassword.$touch()}}
	                            <input v-model="form_data.confirmpassword" @keyup='checkNewPassword'  type="password" class="form-control required" style="margin-bottom: 15px;">
	                            <input type="submit" :disabled="checkConfirmPassword" value="Submit" class="btn btn-primary">
	                        </div>
	                    </div>
	                </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
	import { required,minLength } from "vuelidate/lib/validators";
	export default{
		data(){
            return { 
               checkConfirmPassword:true,
            }
        },
		validations(){
			return {
                form_data: {
                  newpassword:{ required, min: minLength(6) },
                  confirmpassword:{ required, min: minLength(6) }
                }
            }

		},
		methods:{
			checkNewPassword(){
				if(this.form_data.newpassword == this.form_data.confirmpassword){
					this.checkConfirmPassword = false;
				}else{
					this.checkConfirmPassword = true;
				}
			},
			submitPassword(url){
				axios.post(url.chang_pass,this.form_data)
		      	.then(res => {
			        this.errors =null;
			        this.showToster(res.data);
		      	})
		      	.catch(error => {
			        if(error.response.status == 422){
			          this.errors = error.response.data.errors;
			        }
			        var msg = 'opps! something went wrong';
			        this.showToster({status:0,message:msg});
		      	});

			}
		}
	}

</script>
