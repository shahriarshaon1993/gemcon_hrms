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
                               <h3 class="card-title d-none d-md-block">Employee Production Entry</h3>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <div class="col-md-12">
                        <!-- resetModal -->
                          <form @submit.prevent="add({add:'add/daily_production_entry'})" class="form-horizontal  row-border" id="validate-1">
                            <div class="row">
                              <div class="col-md-12" style="border: 1px solid #ddd; padding:15px;">
                                <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group row" style="margin-bottom:0px;">
                                          <div class="col-md-2">
                                            <label class="control-label" style="margin-bottom: 5px;">
                                            Company <sup
                                                  style="color: red; top: -2px">*</sup>
                                            </label>
                                            <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                <vue-select v-model="form_data.sbu_name_value" :options="option_data.company_sbu_data" @select="employeesSbuId" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                <input type="hidden" v-model="form_data.sbu_id">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-2" style="width: 80% !important;">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                Production Date <sup
                                                  style="color: red; top: -2px">*</sup>
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <datepicker :format="customDateFormatter" placeholder="Select Date" style="width: 100% !important;" v-model="form_data.production_date"   class="form-control" ></datepicker>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                Shift  <sup
                                                  style="color: red; top: -2px">*</sup>
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <vue-select v-model="employee_shift_value" :options="option_data.employeeShift" @select="onSelectEmployeeShift" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                Product <sup
                                                  style="color: red; top: -2px">*</sup>
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <vue-select v-model="product_data_value" :options="option_data.product_array" @select="onSelectProduct" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                Bundle
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <vue-select v-model="bundle_data_value" :options="option_data.bundle_array" @select="onSelectBundle" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                Product Grade <sup
                                                  style="color: red; top: -2px">*</sup>
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <vue-select v-model="product_grade_value" :options="option_data.product_grade_array" @select="onSelectProductGrade" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-1 float-right" style="margin-bottom: 5px; margin-top: 8px;">
                                              <a id="addCF" class="btn btn-xs btn-success" style="margin-top:8px; padding:10px 6px;"><i class="fa fa-search" style="color:#fff;" @click="productionEmployeeSearch($event)"> Search</i></a>
                                            </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12" style="border: 1px solid #ddd; padding:15px;">
                                <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group row" style="margin-bottom:0px;">
                                          <div class="col-md-3">
                                            <label class="control-label" style="margin-bottom: 5px;">
                                            Employee <sup
                                                  style="color: red; top: -2px">*</sup>
                                            </label>
                                            <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                <vue-select v-model="approvalnamevalue1" :options="option_data.employee_data_approval" @select="onSelectEmployeeApproval" placeholder="Select one" label="text" track-by="text"></vue-select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-2">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                Quantity <sup
                                                  style="color: red; top: -2px">*</sup>
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <input type="number" name="production_date" v-model="form_data.product_quantity" class="form-control" placeholder="Quantity" id="production_date">
                                                </div>
                                              </div>
                                          </div>

                                          <div class="col-md-2">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                OT Quantity
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <input type="number" name="production_date" v-model="form_data.product_qt_quantity" class="form-control" placeholder="QT Quantity" id="production_date">
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                Machine
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <vue-select v-model="machine_data_value" :options="option_data.machine_array" @select="onSelectMachine" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <label class="control-label" style="margin-bottom: 5px;">
                                                Line
                                              </label>
                                              <div class="inputGroupContainer" style="margin-bottom: 5px;">
                                                <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                  <vue-select v-model="line_data_value" :options="option_data.line_array" @select="onSelectLine" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="col-md-1 float-right" style="margin-bottom: 5px; text-align:center; margin-top:8px;">
                                              <a @click="addRow($event,form_data.employee_production_infos,form_data.employee_id,employees_ids,employeesName,form_data.production_date,shift_name,shift_id,product_name,product_id,bundle_name,bundle_id,grade_name,grade_id,form_data.product_quantity,form_data.product_qt_quantity,product_rate,line_name,line_id,machine_name,machine_id)" id="addCF" class="btn btn-xs btn-success" style="margin-top:8px; padding:10px 6px;"><i class="fa fa-plus" style="color:#fff;"> Add New</i></a>
                                            </div>
                                      </div>
                                      <div class="form-actions col-md-12">
                                          <br>
                                          <input type="submit"   tabindex="4" value="Save" class="btn btn-sm btn-info float-left col-md-1">
                                      </div>
                                      <div class="col-md-12" style="padding:0px;">
                                            <table style="width: 100%; border:1px solid #ddd;" border="1">
                                              <tr class="text-center" style="border-bottom: 1px solid #cfcfcf;background: rgb(207, 207, 207);">
                                                <th>SL</th>
                                                <th>ID No.</th>
                                                <th style="width:15%;">Name</th>
                                                <th style="width:95px;">Date</th>
                                                <th>Shift </th>
                                                <th>Product </th>
                                                <th>Bundle </th>
                                                <th>Grade </th>
                                                <th>Machine</th>
                                                <th>Line</th>
                                                <th>Quantity </th>
                                                <th>OT Qty </th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                                <th class="text-center">Action</th>
                                              </tr>
                                              <tr style="border: 1px solid #cfcfcf;" v-for="(formData, index) in form_data.employee_production_infos" v-bind:key="formData.id" v-if="formData.employees_ids != ''"> 
                                                  <td style="text-align: center;"> {{index}} </td>
                                                  <td style="text-align: center;">{{formData.employees_ids}}  </td>
                                                  <td style="text-align: left;"> {{formData.employeesName}}</td>
                                                  <td style="text-align: center;" class="production_date">
                                                     <datepicker :format="customDateFormatter" placeholder="Select Date" style="width: 100% !important;" v-model="formData.production_date"   class="form-control" ></datepicker>
                                                  </td>
                                                  <td style="text-align: center;"> 
                                                    <!-- <input type="text" v-model="formData.shift_name" class="form-control" placeholder="Shift" required> -->
                                                    <vue-select v-model="formData.shiftData" :options="option_data.employeeShift" @select="onSelectEmployeeShift" placeholder="Select one" label="text" track-by="text" :value="index + 1 + formData.employee_id"></vue-select>
                                                  </td>
                                                  <td style="text-align: center;">
                                                    <!-- formData.productData
                                                    ormData.bundleData -->
                                                    <!-- <input type="text" v-model="formData.product_name" class="form-control" placeholder="Product" required> -->
                                                    <vue-select v-model="formData.productData" :options="option_data.product_array" @select="onSelectProduct" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                  </td>
                                                  
                                                  <td style="text-align: center;">
                                                    <!-- <input type="text" v-model="formData.bundle_name" class="form-control" placeholder="Bundle" required> -->
                                                    <vue-select v-model="formData.bundleData" :options="option_data.bundle_array" @select="onSelectBundle" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                  </td>
                                                  <td style="text-align: center;">
                                                    <!-- <input type="text" v-model="formData.grade_name" class="form-control" placeholder="Grade" required> -->
                                                    <vue-select v-model="formData.gradeData" :options="option_data.product_grade_array"  @change="onSelectProductGrade1('',$event,formData)" @select="onSelectProductGrade1('',$event,formData)" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                  </td>
                                                  <td style="text-align: center;">
                                                    <!-- <input type="text" v-model="formData.machine_name" class="form-control" placeholder="Machine" required> -->
                                                    <vue-select v-model="formData.machineData" :options="option_data.machine_array" @select="onSelectMachine" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                  </td>
                                                  <td style="text-align: center;">
                                                    <!-- <input type="text" v-model="formData.line_name" class="form-control" placeholder="Line" required> -->
                                                    <vue-select v-model="formData.lineData" :options="option_data.line_array" @select="onSelectLine" placeholder="Select one" label="text" track-by="text"></vue-select>
                                                  </td>
                                                  <td style="text-align: center;">
                                                    <input @keyup="TotalAmount($event,formData,index)" :id="index+1+formData.employee_id"  :class="index+1+'qty'"  type="text" v-model="formData.product_quantity" class="form-control" placeholder="Quantity" required>
                                                  </td>
                                                  <td style="text-align: center;">
                                                    <input  @keyup="TotalAmount($event,formData,index)" :id="index+1+formData.employee_id"  :class="index+1+'qty'" type="text" v-model="formData.product_qt_quantity" class="form-control" placeholder="OT Quantity" required>
                                                  </td>
                                                  <td style="text-align: center;">
                                                    <input type="text" @keyup="TotalAmount($event,formData,index)" v-model="formData.product_rate" class="form-control" placeholder="Rate" required>
                                                    <!-- {{option.product_rate}} -->
                                                  </td>
                                                  <td style="text-align: right;">
                                                    <input type="text" v-model="formData.amount" readonly class="form-control" placeholder="Amount" required>
                                                  </td>
                                                  <td style="text-align: center;"> 
                                                      <a @click="deleteRow(index)" id="remCF" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                                                  </td>
                                              </tr>
                                            </table>
                                      </div>
                                  </div>
                                </div>
                              </div>
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
    import moment from 'moment';
    export default {
       data(){
         return{
           employee_name_value:'',
           product_data_value:'',
           approvalnamevalue1:'',
           employee_shift_value:'',
           bundle_data_value:'',
           product_grade_value:'',
           line_data_value:'',
           machine_data_value:'',
           shift_name:'',
           bundle_name:'',
           grade_name:'',
           line_name:'',
           machine_name:'',
           product_name:'',
           line_id:'',
           machine_id:'',
            form_data:{
                 production_quantity:0,
                 production_qt_quantity:0,
            },
           production_quantity:0,
           production_qt_quantity:0,
           sbu_name_value:'',
           product_rate:'',
           bundle_id:'',
              // theDate: moment(new Date()).format("DD/MM/YYYY"),
         }
       },
      created(){
          this.getResults(1);
      },
      components:{
          pageLoading:Loading
      },
      methods:{
        // buttonVisibile(){
        //     if(this.report_data.start_date && this.report_data.ending_date){
        //         this.visable = false;
        //     }
        // },
          customDateFormatter(date) {
              var d = new Date(date),
              month = '' + (d.getMonth() + 1),
              day = '' + d.getDate(),
              year = d.getFullYear();
              if (month.length < 2) month = '0' + month;
              if (day.length < 2) day = '0' + day;
              this.form_data.production_date= [year, month, day].join('-');
              // this.buttonVisibile();
              return moment(date).format('YYYY-MM-DD');
          },
          onSelectEmployee(option){
            // console.log(option);
            this.form_data.employee_id= option.id;
             console.log(this.form_data.employee_id);
          },
          resetModal(){

          },
          onSelectEmployeeApproval(option){
            console.log(option);
            this.form_data.approve_by= option.id;
            this.form_data.employee_id= option.id;
            this.employeesName=option.employee_name;
            this.employees_ids=option.employee_ids;
            this.form_data.approve_by_name= option.text;
            // console.log(this.form_data.approve_by);
          },
          onSelectEmployeeShift(option){
            // this.form_data.shift_id= option.id;
            this.shift_name = option.text;
            this.shift_id = option.id;
            console.log(option);
          },
          onSelectProduct(option){
            // this.form_data.product_id= option.id;
            this.product_name = option.text;
            this.product_id = option.id;
          },
          onSelectBundle(option){
            // this.form_data.bundle_id= option.id;
            this.bundle_name = option.text;
            this.bundle_id = option.id;
          },
          onSelectProductGrade(option){
            // this.form_data.grade_id= option.id;
            this.grade_name = option.text;
            this.grade_id = option.id;
            this.product_rate = option.product_rate;
             amount:(((+product_quantity)+(+ product_qt_quantity)) * (+product_rate)) || 0
            // console.log( this.product_rate);
          },
          onSelectProductGrade1(option,event,formData){
            // this.grade_name = option.text;
            // this.grade_id = option.id;
            // this.product_rate = option.product_rate;
            // console.log(option);
            formData.grade_id=formData.gradeData.id;
            formData.grade_name=formData.gradeData.text;
            formData.product_rate=formData.gradeData.product_rate;
            // console.log(formData.gradeData.product_rate);
            formData.product_rate=formData.gradeData.product_rate;
            formData.amount=(((+formData.product_quantity)+(+ formData.product_qt_quantity))*(+ formData.product_rate)) || 0;
            console.log(formData.amount);
          },
          onSelectLine(option){
            // this.form_data.line_id= option.id;
            this.line_name = option.text;
            this.line_id = option.id;

          },
          onSelectMachine(option){
            // this.form_data.machine_id= option.id;
            this.machine_name = option.text;
            this.machine_id = option.id;
          },
          employeesSbuId(option){
            this.form_data.sbu_id=option.id;
          },
          productionEmployeeSearch(event){
          this.page_loading= false;
          let uri = URL.baseUrl('daily_production_entry/find_employee');
          axios.post(uri,
              {
                sbu_id:this.form_data.sbu_id,
                shift_name:this.shift_name,
                shift_id:this.shift_id,
                production_date:this.form_data.production_date,
                product_id:this.product_id,
                product_name:this.product_name,
                bundle_id:this.bundle_id,
                bundle_name:this.bundle_name,
                grade_id:this.grade_id,
                grade_name:this.grade_name,
                product_rate:this.product_rate,
              }).then(res => {
                // console.log(res);
                this.form_data.employee_production_infos = res.data;
                this.form_data.employee_id=this.form_data.employee_id;
                this.page_loading= true;
              })
              .catch(error => {
                this.modal_loading= true;
             })
          },
          addRow(event,employee_production_infos,id,ids,name,production_date,shift_name,shift_id,product_name,product_id,bundle_name,bundle_id,grade_name,grade_id,product_quantity,product_qt_quantity,product_rate,line_name,line_id,machine_name,machine_id) {
            // let obj = employee_production_infos.find(data => data.employee_id==id);
            //  console.log(obj); 
            // if(obj){
            //     alert('Sorry, This employee already added!');
            //     return false;        
            // }
            var aaa= this.form_data.employee_production_infos.length;

            this.form_data.employee_production_infos.push({
                  approvalnamevalue1:'',
                  indexid:aaa,
                  employee_id:id,
                  employees_ids:ids,
                  employeesName:name,
                  production_date:production_date,
                  shift_name:shift_name,
                  shift_id:shift_id,
                  shiftData:{id: shift_id,text: shift_name},
                  product_name:product_name,
                  product_id:product_id,
                  productData:{id: product_id,text: product_name},
                  bundle_name:bundle_name,
                  bundle_id:bundle_id,
                  bundleData:{id: bundle_id,text: bundle_name},
                  grade_name:grade_name,
                  grade_id:grade_id,
                  gradeData:{id: grade_id,text: grade_name,product_rate:product_rate},
                  product_quantity:product_quantity,
                  product_qt_quantity:product_qt_quantity,
                  product_rate:product_rate,
                  line_name:line_name,
                  line_id:line_id,
                  lineData:{id: line_id,text: line_name},
                  machine_name:machine_name,
                  machine_id:machine_id,
                  machineData:{id: machine_id,text: machine_name},
                  amount:((((+product_quantity)+(+ product_qt_quantity)) * (+product_rate)) || 0).toFixed(2),
              })
            // this.form_data.employee_id= '';
            // this.employeesName='';
            // this.employees_ids='';
            this.approvalnamevalue1='';
            this.form_data.product_quantity=0;
            this.form_data.product_qt_quantity=0;
            this.form_data.production_date=this.form_data.production_date;
            
              console.log(this.form_data.employee_production_infos);
          },
          deleteRow(index) {
            this.form_data.employee_production_infos.splice(index,1);
          },
          TotalAmount(event,row,index){
            let total;
            console.log(row);
            this.price_amount= this.form_data.employee_production_infos.reduce(function(total, item){
                return total + (+item.product_rate * +item.product_quantity) || 0;
            },0);
            this.form_data.amount=this.price_amount;
            row.amount=((((+row.product_quantity)+(+ row.product_qt_quantity)) * (+row.product_rate)) || 0).toFixed(2);
            console.log(this.price_amount)
             console.log(this.form_data.amount)
          },
      }
    }
</script>
<style>
  /* .production_data.vdp-datepicker input {
      height: 32px !important;
  } */
</style>