<template>
	<div class="modify-wraper pos-line-set">
        <div v-if="modal_loading">
            <form  @submit.prevent="add({add:'add/vendor'})" class="form-horizontal  row-border" id="validate-1">
                <div class="my-form-wraper">
                    <div v-if="errors" class="alert alert-danger">
                        <div v-for="(error, index) in errors">
                            <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                            <span v-if="!isObject(error)">{{error}}</span>
                        </div>
                    </div>
                    <div class="upper-part">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group modify-input">
                                    <label class="col-md-3 control-label">Company Name</label>
                                    <div class="col-md-9">
                                        <input v-model="form_data.company_name" type="text" class="form-control required" placeholder="Contact Name">
                                    </div>
                                </div>
                                <div class="form-group modify-input">
                                    <label class="col-md-3 control-label">Address</label>
                                    <div class="col-md-9">  
                                        <textarea v-model="form_data.company_address" type="text" class="form-control required textarea-height-set" placeholder="Address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                    <div class="lower-part">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group modify-input">
                                    <label class="col-md-5 control-label city-label">Phone</label>
                                    <div class="col-md-7 set-left-padding">
                                        <input v-model="form_data.vendor_phone" type="text" class="form-control required" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group modify-input">
                                    <label class="col-md-4 fax control-label">Fax</label>
                                    <div class="col-md-8 set-left-padding">
                                        <input v-model="form_data.vendor_fax" type="text" class="form-control required" placeholder="Fax">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group modify-input">
                                    <label class="col-md-4 control-label">Next Invoice #</label>
                                    <div class="col-md-8 set-left-padding" >
                                        <input v-model="form_data.vendor_email" type="text" class="form-control required" placeholder="Next Invoice">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group modify-input">
                                    <label class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control required" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group modify-input">
                                    <label class="col-md-4 control-label">Next PO #</label>
                                    <div class="col-md-8 set-left-padding">
                                        <input type="text" class="form-control required" placeholder="Next PO">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group modify-input">
                                    <div class="vendor-table pos">
                                        <h5>Sales Vat Code</h5>
                                        <div class="col-md-12">
                                            <div class="table-border post-table">
                                                <div class="col-md-3">
                                                    <label class="col-md-5 control-label label-rignt" style="padding: 0px;font-weight: 400;">1)</label>
                                                    <div class="col-md-7">
                                                        <input v-model="form_data.sales_tax_a" style="text-align: right;" type="text" class="form-control required" placeholder="$0.00">
                                                        <span class="percent">%</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-md-5 control-label label-rignt" style="padding: 0px;font-weight: 400;">2)</label>
                                                    <div class="col-md-7">
                                                        <input v-model="form_data.sales_tax_b" style="text-align: right;" type="text" class="form-control required" placeholder="$0.00">
                                                        <span class="percent">%</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-md-5 control-label label-rignt" style="padding: 0px;font-weight: 400;">3)</label>
                                                    <div class="col-md-7">
                                                        <input v-model="form_data.sales_tax_c" style="text-align: right;" type="text" class="form-control required" placeholder="$0.00">
                                                        <span class="percent">%</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-md-5 control-label label-rignt" style="padding: 0px;font-weight: 400;">4)</label>
                                                    <div class="col-md-7">
                                                        <input v-model="form_data.sales_tax_d" style="text-align: right;" type="text" class="form-control required" placeholder="$0.00">
                                                        <span class="percent">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="company-info-wraper">
                                <div class="col-md-6">
                                    <h4 class="text-center">Accounting Total Header</h4>
                                    <div class="col-md-4">
                                        <select class="form-control" v-model="form_data.account_header_a">
                                            <option :value="1">Daily</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                       <select class="form-control" v-model="form_data.account_header_b">
                                            <option :value="2">Monthly</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" v-model="form_data.account_header_c">
                                            <option :value="3">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group modify-input">
                                        <div class="vendor-table">
                                            <h5>Total Purchases</h5>
                                            <p>TMSS ICT Point Of Sale<br> Software For Retail Stores<br>2018</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <button type="button" @click="add_config({add:'add/customerinfo'})" class="btn btn-primary pull-right">Submit</button>
            </form>
        </div>
        <div v-if="!modal_loading">
            <pageLoading></pageLoading>
        </div> 
    </div>
</template>

<script>
    import { required} from "vuelidate/lib/validators";

    export default {
    	created(){
            this.getCustomerInfo();
        },
        methods:{
            add_config(addUrl){
                axios.post(URL.baseUrl(addUrl.add),this.form_data)
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
            },
            getCustomerInfo(){
                var fetchUrl = this.$route.meta.fetchUrl;
                axios.get(URL.baseUrl(fetchUrl))
                .then(res => {
                  this.form_data = res.data;
                  this.option_data = res.data;
                  this.modal_loading= true;
                })
                .catch(error => {
                  this.showToster({status:0,message:'opps! something went wrong'});
                  this.modal_loading= true;
                })
            }
        }
    }
</script>