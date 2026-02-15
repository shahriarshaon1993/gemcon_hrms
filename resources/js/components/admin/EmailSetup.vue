<template>
	<div class="modify-wraper pos-line-set">
        <form @submit.prevent="add({add:'add/vendor'})" class="form-horizontal  row-border" id="validate-1">
            <div class="my-form-wraper">
                <div v-if="errors" class="alert alert-danger">
                    <div v-for="(error, index) in errors">
                        <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                        <span v-if="!isObject(error)">{{error}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="email-setup">
                            <h4>Server Information</h4>
                            <div class="form-group modify-input">
                                <label class="col-md-6 control-label">Outgoing Server Name(SMTP)</label>
                                <div class="col-md-6">
                                    <input v-model="form_data.vendor_contact_person" type="text" class="form-control required" placeholder="Contact Name">
                                </div>
                            </div>
                            <div class="form-group modify-input">
                                <label class="col-md-6 control-label">Outgoing Server Port(SMTP)</label>
                                <div class="col-md-6">
                                    <div class="col-md-4 set-left-padding">
                                        <input v-model="form_data.vendor_contact_person" type="text" class="form-control required" placeholder="Contact Name">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="pos-instruction">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import { required} from "vuelidate/lib/validators";

    export default {
    	created(){
            
        }
    }
</script>