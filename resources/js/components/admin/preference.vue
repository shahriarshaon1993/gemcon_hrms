<template>
	<div class="modify-wraper pos-line-set">
        <div v-if="modal_loading">
            <form @submit.prevent="add({add:'add/vendor'})" class="form-horizontal  row-border" id="validate-1">
                <div class="my-form-wraper">
                    <div v-if="errors" class="alert alert-danger">
                        <div v-for="(error, index) in errors">
                            <span v-if="isObject(error)" v-for="err in error">{{err}}</span>
                            <span v-if="!isObject(error)">{{error}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pos-instruction">
                                <ul>
                                    <li>
                                        <input type="checkbox" name="text_exempt"> Show point of sale screen on start-up
                                    </li>
                                    <li>
                                        <input type="checkbox" name="text_exempt"> Save invoices and quotations in history file
                                    </li>
                                    <li>
                                        <input type="checkbox" name="text_exempt"> Save closed statement in history file
                                    </li>
                                    <li>
                                        <input type="checkbox" name="text_exempt"> View Daily Accontating totals without password
                                    </li>
                                    <li>
                                        <input type="checkbox" name="text_exempt"> Allow manual invoice number 
                                    </li>
                                     <li>
                                        <input type="checkbox" name="text_exempt"> Select New salesperson on each sale
                                    </li>
                                     <li>
                                        <input type="checkbox" name="text_exempt"> Change interest on past due account
                                        <input type="number" name="quantity"> % APR
                                    </li>
                                </ul>
                                <div class="form-group modify-input">
                                    <div class="vendor-table">
                                        <h5>To Calculae Profit Use</h5>
                                        <div class="col-md-12">
                                            <div class="table-border">
                                                <ul>
                                                    <li>
                                                        <!-- item last cost -->
                                                        <label><input v-model="form_data.calculate_profit_type" type="radio" name="status" value="1">The Item Last Cost</label>
                                                    </li>
                                                    <li>
                                                        <!-- item average cost -->
                                                        <label><input v-model="form_data.calculate_profit_type" type="radio" name="status" value="2">The Item Average Cost</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group modify-input">
                                    <div class="vendor-table">
                                        <h5>LedgerOne Accounting</h5>
                                        <div class="col-md-12">
                                            <div class="table-border">
                                                <label class="ledger-top"><input type="checkbox" name="status" value="0">Link sales and credits to LedgerOne Accounting</label>
                                                <div class="selected-panel">
                                                    <label>Taxable Accot #</label> 
                                                    <select class="form-control">
                                                        <option>--All--</option> 
                                                        <option value="1">Admin</option>
                                                        <option value="2">POS</option>
                                                    </select>
                                                </div>
                                                <div class="selected-panel">
                                                    <label>Taxable Accot #</label> 
                                                    <select class="form-control">
                                                        <option>--All--</option> 
                                                        <option value="1">Admin</option>
                                                        <option value="2">POS</option>
                                                    </select>
                                                </div>
                                                <div class="selected-panel">
                                                    <label>Taxable Accot #</label> 
                                                    <select class="form-control">
                                                        <option>--All--</option> 
                                                        <option value="1">Admin</option>
                                                        <option value="2">POS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-md-12"><input type="checkbox"> Allow Trade-in</label>
                            <input v-model="form_data.next_trade_number" type="text" name="quantity" style="height: 26px;margin-left: 12px;">
                            <label class="col-md-12">Next Trade In Item #</label>
                        </div>
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
          this.getModalData();  
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
            getModalData(){
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