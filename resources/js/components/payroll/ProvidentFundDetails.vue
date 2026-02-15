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
                               <h3 class="card-title d-none d-md-block">Provident Fund Details</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <!-- <button id="btnExport"  @click="tableToExcel" class="btn-success" style="margin-left:10px;"> <i class="fa fa-file-excel"></i> Export</button> -->

                                 <!-- <button v-print="'#printMe'" class="btn-info float-right">Print</button> -->
                                 <!-- <button @click="printDiv()" class="btn-info">Print</button> -->
                                 <!-- <button @click="printDiv()"  class="btn-info"> <i class="fa fa-print"></i> Print</button> -->
                                  <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                        <div id="printable">
                            <div class="row">
                                <div id="page-header" class="col-lg-12" style="display: none;">
                                    <h3 class="page-header text-center">Provident Fund Details <small> </small>        
                                                </h3>
                                </div>

                                <!-- <div class="row"> -->
                                <div class="col-md-12">
                                    <div class="col-md-12" style="border: 1px solid #cfcfcf;">
                                      <div class="row">
                                          <div class="col-md-10 modify-wraper float-left" style="">
                                            <table v-if="form_data.user_employee_data?form_data.user_employee_data.employee_id_no:''" class="table table-hover table-responsive">
                                              <tbody>
                                                <tr>
                                                    <td style="font-weight:bold;width:10%">Name </td>
                                                    <td style="font-weight:bold;">:</td>
                                                    <td style="width:55%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.employee_fullname}}</td>
                                                    <td style="font-weight:bold;width:5%"> ID </td>
                                                    <td style="font-weight:bold">:</td>
                                                    <td style="width:40%; padding-left:0px; padding-right:0px; ">
                                                      <input type="hidden" v-model="form_data.employee_id" name="">
                                                    {{form_data.company_sbu_id}}                                   {{form_data.user_employee_data.employee_id_no}}
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                  <td style="font-weight:bold;width:10%" >Designation </td>
                                                  <td style="font-weight:bold" >:</td>
                                                  <td style="width:40%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.designation_name}}</td>
                                                  <td style="font-weight:bold">Contact</td>
                                                  <td style="font-weight:bold">:</td>
                                                  <td style="width:25%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.employee_mobile}}</td>
                                                </tr>
                                                <tr>
                                                  <td style="font-weight:bold;width:10%" >Department</td>
                                                  <td style="font-weight:bold" >:</td>
                                                  <td style="width:40%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.department_name}}</td>
                                                  <td style="font-weight:bold" >Joining</td>
                                                  <td style="font-weight:bold">:</td>
                                                  <td style="width:25%; padding-left:0px; padding-right:0px; ">{{form_data.user_employee_data.employee_joining_date}}</td>
                                                </tr>
                                                <tr>
                                                  <td style="font-weight:bold">SBU</td>
                                                  <td style="font-weight:bold">:</td>
                                                  <td style="width:33%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.sbu_name}}</td>
                                                  <td style="font-weight:bold" >Location</td>
                                                  <td style="font-weight:bold">:</td>
                                                  <td style="width:33%; padding-left:0px; padding-right:0px;">{{form_data.user_employee_data.work_location_name}}</td>

                                                </tr>
                                                
                                              </tbody>
                                            </table>
                                          </div>
                                           <div class="col-md-2 float-left" style="text-align: right !important;">
                                             <span v-if="form_data.user_employee_data.employee_image">
                                               <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top: 1px;width: 119px;height: 132px;margin-left: -9px;margin-right: 1px;">
                                             </span>
                                             <span v-else>
                                               <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="    margin-top: 1px;width: 119px;height: 132px;margin-left: -9px;margin-right: 1px;">
                                             </span>
                                           </div>
                                      </div>
                                    </div>
                                </div>
                                       
                                <!-- </div> -->
                                <!-- <div class="col-md-4">
                                    <h4>Employee Info</h4>
                                    <div class="row">
                                        <div class="col-md-3">Name:</div>
                                        <div class="col-md-8" style="text-align: left;">{{form_data.user_employee_data.employee_fullname}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Employee ID:</div>
                                        <div class="col-md-8" style="text-align: left;">{{form_data.user_employee_data.employee_id_no}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Designation:</div>
                                        <div class="col-md-8" style="text-align: left;">{{form_data.user_employee_data.designation_name}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Contact No.:</div>
                                        <div class="col-md-8" style="text-align: left;">{{form_data.user_employee_data.employee_mobile}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Department:</div>
                                        <div class="col-md-8" style="text-align: left;">{{form_data.user_employee_data.department_name}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Joining Date:</div>
                                        <div class="col-md-8" style="text-align: left;">{{form_data.user_employee_data.employee_joining_date}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Confirmation:</div>
                                        <div class="col-md-8" style="text-align: left;">{{form_data.user_employee_data.confirmation_date}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">Company:</div>
                                        <div class="col-md-8" style="text-align: left;">{{form_data.user_employee_data.sbu_name}}</div>
                                    </div>
                                </div> -->
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="row">
                                        <h4 class="col-md-6">Salary History</h4>
                                        <h4 class="col-md-6 text-right">
                                            <span>Gross Salary:</span> 
                                            <span  style="color: green;">{{total_gross_salary.toFixed(2)}}</span>
                                        </h4>
                                    </div>
                                    <table class="table table-hover tablesorter table-bordered" id="gridtable">
                                        <thead>
                                            <tr>
                                                <th class="header text-center">Date</th>
                                                <th class="header text-center">Basic</th>
                                                <th class="header text-center">Housing</th>
                                                <th class="header text-center">Medical</th>
                                                <th class="header text-center">Transport</th>
                                                <th class="header text-center">Others</th>
                                                <th class="header text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- {{lists.emp_salary}} -->
                                            <tr v-for="salary in lists.emp_salary">
                                                <td align="center">{{salary.confirmation_date}}</td>
                                                <td align="right">{{salary.basic_salary}}</td>
                                                <td align="right">{{salary.housing_allowance}}</td>
                                                <td align="right">{{salary.medical_allowance}}</td>
                                                <td align="right">{{salary.conveyance_allowance}}</td>
                                                <td align="right">{{salary.others_allowance}}</td>
                                                <td align="right"><b>{{salary. gross_salary }}</b>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td><b>Current Salary</b>
                                                </td>
                                                <td align="right"><b>{{total_basic_salary}}</b>
                                                </td>
                                                <td align="right"><b>{{total_housing_allowance}}</b>
                                                </td>
                                                <td align="right"><b>{{total_medical_allowance}}</b>
                                                </td>
                                                <td align="right"><b>{{total_conveyance_allowance}}</b>
                                                </td>
                                                <td align="right"><b>{{total_others_allowance}}</b>
                                                </td>
                                                <td align="right"><b>{{total_gross_salary}}</b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                          <!-- <div class="col-md-2 float-left text-right">
                            <span v-if="form_data.user_employee_data.employee_image">
                              <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top:2px; width: 170px; height: 190px;">
                            </span>
                            <span v-else>
                              <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="margin-top: 2px; width: 170px; height: 190px;">
                            </span>
                          </div> -->
                            </div>
                            <div class="row">
                                <div class="col-lg-12" style=" margin-top: 15px;">
                                    <h4>PF History</h4>
                                    <table class="table table-hover tablesorter table-bordered" id="gridtable">
                                        <thead>
                                            <tr>
                                                <th class="header text-center">Sl No.</th>
                                                <th class="header text-center">Date</th>
                                                <th class="header text-center">Employee Contribution</th>
                                                <th class="header text-center">Company Contribution</th>
                                                <!-- <th class="header text-center">Profit / Interest</th> -->
                                                <th class="header text-center"> Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(pf, index) in lists.emp_provident_fund">
                                                <td class="text-center">{{index+1}}</td>
                                                <td class="text-center">{{pf.pf_date }}</td>
                                                <td class="text-right">{{ parseFloat(pf.pf_employee_amount).toFixed(2)  }}</td>
                                                <td class="text-right">{{ parseFloat(pf.pf_company_amount ).toFixed(2) }}</td>
                                                <td class="text-right">{{parseFloat(pf.pf_employee_amount+pf.pf_company_amount).toFixed(2)}}</td>
                                             </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-center" colspan="2"><b>Total</b></td>
                                                <td align="right"><b>{{total_pf_employee_amount.toFixed(2)}}</b></td>
                                                <td align="right"><b>{{total_pf_company_amount.toFixed(2)}}</b></td>
                                                <td align="right"><b>{{total_pf_amount.toFixed(2)}}</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <!-- <div class="row" style=" margin-top: 100px;">
                                <div class="col-md-3 text-center">
                                    <hr style="border-color: #000;">Prepared By
                                    <br>HRD</div>
                                <div class="col-md-3 text-center">
                                    <hr style="border-color: #000;">Checked By
                                    <br>Accounts</div>
                                <div class="col-md-3 text-center">
                                    <hr style="border-color: #000;">Checked By
                                    <br>Audit</div>
                                <div class="col-md-3 text-center">
                                    <hr style="border-color: #000;">Verified By
                                    <br>GM (A&amp;F)</div>
                            </div>
                            <div class="row" style=" margin-top: 100px;">
                                <div class="col-md-4 text-center">
                                    <hr style="border-color: #000;">Recommended By
                                    <br>Director</div>
                                <div class="col-md-4 text-center">
                                    <hr style="border-color: #000;">Recommended By
                                    <br>Deputy Managing Director</div>
                                <div class="col-md-4 text-center">
                                    <hr style="border-color: #000;">Approved By
                                    <br>Managing Director / Chairman</div>
                            </div> -->
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
           gross_salary_entry:'',
           basic_salary_entry:'',
           housing_allowance_entry:'',
           medical_allowance_entry:'',
           conveyance_allowance_entry:'',
           overtime_work_compensation_entry:'',
           profile_open:'',
           car_allowance_field:'',
           others_allowance_entry:'',
         }
       },

        created(){
            this.getResults(1,this.$route.params.employeeId);
        },
        components:{
            pageLoading:Loading
        },
        computed: {
            total_basic_salary: function(){
                const equities = this.lists.emp_salary;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.basic_salary;
                }, 0)
                return total;
            },
            total_housing_allowance: function(){
                const equities = this.lists.emp_salary;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.housing_allowance;
                }, 0)
                return total;
            },
            total_medical_allowance: function(){
                const equities = this.lists.emp_salary;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.medical_allowance;
                }, 0)
                return total;
            },
            total_conveyance_allowance: function(){
                const equities = this.lists.emp_salary;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.conveyance_allowance;
                }, 0)
                return total;
            },
            total_others_allowance: function(){
                const equities = this.lists.emp_salary;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.others_allowance;
                }, 0)
                return total;
            },
            total_gross_salary: function(){
                const equities = this.lists.emp_salary;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.gross_salary;
                }, 0)
                return total;
            },

            /* Employee PF + Company PF total Calculation */
            total_pf_employee_amount: function(){
                const equities = this.lists.emp_provident_fund;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.pf_employee_amount;
                }, 0)
                return total;
            },
            total_pf_company_amount: function(){
                const equities = this.lists.emp_provident_fund;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.pf_company_amount;
                }, 0)
                return total;
            },
            total_pf_profit_interest: function(){
                const equities = this.lists.emp_provident_fund;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.pf_profit_interest;
                }, 0)
                return total;
            },
            total_pf_amount: function(){
                const equities = this.lists.emp_provident_fund;
                const total = equities.reduce((sum, equity) => {
                  return sum + equity.pf_employee_amount + equity.pf_company_amount + equity.pf_profit_interest;
                }, 0)
                return total;
            },
        },
        watch: {                       
         },
         methods:{
             printDiv() {
               $('h3').each(function() {
                 this.style.setProperty('margin', '0px', 'important');
                 this.style.setProperty('font-size', '1.75rem', 'important');
               });
                $('h4').each(function() {
                 this.style.setProperty('margin', '0px', 'important');
                 this.style.setProperty('font-size', '1.5rem', 'important');
               });
                 $('h5').each(function() {
                 this.style.setProperty('margin', '0px', 'important');
                 this.style.setProperty('font-size', '1.25rem', 'important');
               });
               $('h6').each(function() {
                 this.style.setProperty('margin', '0px', 'important');
                 this.style.setProperty('font-size', '1rem', 'important');
               });
                $('.table-bordered').each(function() {
                 this.style.setProperty('border', '1px solid #dee2e6', 'important');
                 this.style.setProperty('padding', '5px .75rem', 'important');
                 this.style.setProperty('border-collapse', 'collapse', 'important');
               });
               $('.ths').each(function() {
                  this.style.setProperty('border', '1px solid #dee2e6', 'important');
                 this.style.setProperty('padding', '5px 5px', 'important');
                 this.style.setProperty('border-collapse', 'collapse', 'important');
               });
              let contents = document.getElementById("printable").innerHTML
                let frame1 = document.createElement('iframe');
                frame1.name = "frame1";
                frame1.style.position = "absolute";
                frame1.style.top = "-1000000px";
                document.body.appendChild(frame1);
                let frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
                frameDoc.document.open();
                frameDoc.document.write('<html lang="en"><head><title>Gemcon Group</title>');
                frameDoc.document.write('<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>');
                frameDoc.document.write('</head><body>');
                frameDoc.document.write(contents);
                frameDoc.document.write('</body></html>');
                frameDoc.document.close();
                setTimeout(function () {
                    window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    document.body.removeChild(frame1);
                }, 500);
                return false;
            },
            tableToExcel(){
            var uri = 'data:application/vnd.ms-excel;base64,',
              template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
                base64 = function(s) {
                  return window.btoa(unescape(encodeURIComponent(s)))
                },
                format = function(s, c) {
                  return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                  })
                }
              var toExcel = document.getElementById("printable").innerHTML;
              var ctx = {
                worksheet: name || '',
                table: toExcel
              };
              var link = document.createElement("a");
              link.download = "export.xls";
              link.href = uri + base64(format(template, ctx))
              link.click();
            
            },
           onSelectEmployee(option){
             console.log(option);
             this.form_data.employee_id= option.id;
             console.log(this.form_data.employee_id);
           },
           onSelectEmployeeSearch(option){
             this.profile_open = 1;
             this.getModalDataOther(option.id);
             this.form_data.employee_id= option.id;
             this.form_data.employee_id=this.form_data.employee_id;
             console.log(this.form_data.employee_id);
             console.log(option);
             let allData =this.form_data.user_employee_data_all[option.id];
             this.form_data.employee_id= allData['id']; 
           },
           getModalDataOther(id){
             // console.log('aaaaaa');
             let uri = URL.baseUrl('other_create/increment/'+id);
             console.log(uri);
             axios.get(uri)
             .then(res => {
               console.log(res.data);
               this.form_data = res.data;
               this.form_data.employee_id=id;
               this.form_data.car_allowance_status=2;
               this.form_data.provident_fund=1;
               this.form_data.gratuity_fund=1;
               this.errors =null;
               if(callback){
                 callback();
               }
             })
             .catch(error => {
               this.modal_page_loading= true;
             })
           },
           car_allowance(e){
              var val = e.target.value
            // console.log(e.target.value);
              if (val==1) {
                this.car_allowance_field=1;
              }else{
                this.car_allowance_field=2;
              }
           },
           
           setModalData(){
             this.profile_open=1;
             this.employee_name_value=this.form_data.employee_name_value;
             this.gross_salary_entry=this.form_data.gross_salary;
             this.basic_salary_entry=this.form_data.basic_salary;
             this.housing_allowance_entry=this.form_data.housing_allowance;
             this.medical_allowance_entry=this.form_data.medical_allowance;
             this.conveyance_allowance_entry=this.form_data.conveyance_allowance;
             this.overtime_work_compensation_entry=this.form_data.overtime_work_compensation;
           },
           resetModal(){
             this.gross_salary_entry='';
             this.basic_salary_entry='';
             this.housing_allowance_entry='';
             this.medical_allowance_entry='';
             this.conveyance_allowance_entry='';
             this.overtime_work_compensation_entry='';
             this.employee_name_value='';
             this.profile_open='';
             this.form_data.car_allowance_status=2;
             this.form_data.provident_fund=1;
             this.form_data.gratuity_fund=1;
             this.car_allowance_field='';
             this.others_allowance_entry='';
           },
         }
    }



</script>
<style type="text/css">
  #gridtable {
      font-size: 12px;
      border: 1px solid #CCCCCC;
      padding: 15px;
      -moz-box-shadow: 0px 3px 2px #CCCCCC;
      -webkit-box-shadow: 0px 3px 2px #CCCCCC;
      box-shadow: 0px 3px 2px #CCCCCC;
  }
</style>