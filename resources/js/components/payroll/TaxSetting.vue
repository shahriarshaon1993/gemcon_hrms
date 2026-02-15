<template>
<div>
    <div v-if="page_loading" class="widget box">
        <div class="widget-header">
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                       <div class="row">
                           <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                               <h3 class="card-title d-none d-md-block">Tax Setting</h3>
                               <!-- <span class="float-sm-right" style="float: right;">
                                 <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i> Back</a>
                               </span> -->
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <div class="col-md-6 offset-md-3" style="border: 1px solid #ddd; padding:15px;">
                          <form @submit.prevent="add({add:'add/tax_setting'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                            <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label class="col-md-12 control-label">Effective Date</label>
                                    <div class="col-md-12 inputGroupContainer">
                                       <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <datepicker placeholder="Select Date" style="width: 131% !important;" v-model="form_data.effective_date"  class="form-control" ></datepicker>
                                      </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                   <div class="col-md-3">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Taxable Income Male</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input v-model="form_data.taxable_income_male"  placeholder="" class="form-control" required="true"  type="number">
                                          </div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-3">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Tax. Income Female</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input v-model="form_data.taxable_income_female"  placeholder="" class="form-control" required="true"  type="number">
                                          </div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-3">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Tax. Income Age</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input v-model="form_data. taxable_income_age"  placeholder="" class="form-control" required="true"  type="number">
                                          </div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-3">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Maximum Age(Tax)</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input v-model="form_data.taxable_maximum_age"  placeholder="" class="form-control" required="true"  type="number">
                                          </div>
                                        </div>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="row">
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Taxable Slot-1</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot1" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Tax Percentage (%)</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot1_per" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="row">
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Taxable Slot-2</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot2" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Tax Percentage (%)</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot2_per" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="row">
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Taxable Slot-3</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot3" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Tax Percentage (%)</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot3_per" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="row">
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Taxable Slot-4</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot4" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Tax Percentage (%)</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot4_per" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                 </div>
                                 <div class="row">
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Taxable Slot-5</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot5" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                   <div class="col-md-6">
                                     <div class="form-group">
                                        <label class="col-md-12 control-label">Tax Percentage (%)</label>
                                        <div class="col-md-12 inputGroupContainer">
                                           <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <input id="department_name" v-model="form_data.taxable_slot5_per" name="department_name" placeholder="" class="form-control" required="true"  type="number"></div>
                                        </div>
                                     </div>
                                   </div>
                                 </div>
                              </div>
                            </div>
                            <div class="form-actions col-md-12">
                                <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2">
                                <!-- <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button> -->
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
    </div>
<div v-if="!page_loading">
    <pageLoading></pageLoading>
</div>
</div>
</template>
<script>
    import Loading from '../Loading.vue';
    import Datepicker from 'vuejs-datepicker';
    export default {
       data(){
         return{
           employee_name_value:'',
         }
       },
      created(){
          this.getResults(1);
      },
      components:{
          pageLoading:Loading
      },
      methods:{
          onSelectEmployee(option){
            console.log(option);
            this.form_data.employee_id= option.id;
            console.log(this.form_data.employee_id);
          },
          resetModal(){

          }
        }
    }
</script>