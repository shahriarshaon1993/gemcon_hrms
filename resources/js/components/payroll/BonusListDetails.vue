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
                               <h3 class="card-title d-none d-md-block">Payroll Report</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <button id="btnExport"  @click="tableToExcel" class="btn-success" style="margin-left:10px;"> <i class="fa fa-file-excel"></i> Export</button>
                                 <button @click="printDiv()"  class="btn-info"> <i class="fa fa-print"></i> Print</button>
                                  <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                      <div class="row col-md-12">
                       </div> 
                    </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>

         <section class="content" id="printable">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                       
                    </div>
                    <div class="card-body col-md-12">
                      <div class="row col-md-12">
                          <div class="col-lg-12 text-center">
                              <h3 style=" margin-top: -5px;">Gemcon Group</h3>
                              <h6 style=" margin-top: -4px;">Dhanmondi 27, Dhaka 1212, Bangladesh</h6>
                              <h6 style=" margin-top: -4px;"><strong>Approval of Bonus for {{form_data.bonus_for_eid}}'{{form_data.processing_year}}</strong></h6>
                              <!-- <h5 style=" margin-top: -6px;">For the Month of {{ lists.month_name}}            <span style=" font-size: 12px;">({{ lists.report_date }}) </span></h5> -->
                              <h6 style=" margin-top: -4px;">Processing Date: {{form_data.processing_date}}</h6>
                          </div>
                          <div class="col-md-12">
                            <div class=" " style="min-height: 56px;" v-if="modal_loading">
                            <table id='tblCustomers' class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                              <thead>
                                <tr style="text-align: center;">
                                  <th rowspan="2" style="vertical-align: middle;width: 50px" >SL</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 120px;" >Employee ID</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 200px;" >Employee Name</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 200px;" >Designation</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 100px;" >Grade</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 95px;"  >Joining Date</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 100px;" >A/C No</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Salary</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 90px;" >Basic Salary</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 90px;" >Bonus Per.</th>
                                  <th rowspan="2" style="vertical-align: middle;width: 90px;" >Bonus Amount</th>
                                  <!-- <th rowspan="2" style="vertical-align: middle;width: 120px;" >Net Payable</th> -->
                                </tr>
                              </thead>
                               <tbody>
                                <tr v-for="(form_data, index) in form_data.employee_data" v-bind:key="form_data.id" >
                                  <td class="text-center">{{index+1}}</td>
                                  <td > {{form_data.employee_id_no}}</td>
                                  <td>{{form_data.employee_fullname}}</td>
                                  <td>{{form_data.designation_name}}</td>
                                  <td>{{form_data.jobgrade_name}}</td>
                                  <td>{{form_data.employee_joining_date}}</td>
                                  <td>{{form_data.ebc_account_number}}</td>
                                  <td class="text-right" style="width: 81px;vertical-align: middle;">{{form_data.g_salary |number('0,0.00') }}</td>
                                  <td class="text-right" style="width: 81px;vertical-align: middle;">{{form_data.b_salary |number('0,0.00') }}</td>
                                  <td class="text-center" style="width: 81px;vertical-align: middle;">{{form_data.bonus_percentage }}</td>
                                  <td class="text-right" style="width: 81px;vertical-align: middle;">{{form_data.bonus_amount |number('0,0.00') }}</td>
                                  <!-- <td class="text-right" style="width: 180px;vertical-align: middle;">{{form_data.bonus_amount |number('0,0.00') }}</td> -->
                                </tr>
                              </tbody>
                            </table>
                           <!-- </div>  -->
                          </div>
                         <div v-if="!modal_loading">
                   <pageLoading></pageLoading>
               </div>
                          </div>
<!--                          </form>
 -->                      </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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
    import $ from 'jquery'
    import VueTimepicker from 'vue2-timepicker'
    // CSS
    import 'vue2-timepicker/dist/VueTimepicker.css'   

    export default {
       data(){
         return{
           sbu_name_value:'',
           section_value:'',
           sub_section_value:'',
           employee_group_value:'',
           unit_value:'',
           make_user:0,
           employeesName:'',
           employees_ids:'',
           employee_data_approvaldat:'',
           datesList:'',
           url: null,
           sub_unit_value:'',
           work_location_value:'',
           department_name_value:'',
           designation_name_value:'',
           jobgrade_name_value:'',
           employee_name_value:'',
           sub_unit_value:'',
           work_location_value:'',
           personal_email_id:'',
           noticeToType:0,
           noticeToTypeName:'',
           monthly_id:'',
           Salary_grade:'',
           Salary_type:'',
           week_id:'',
           roaster_type:'',
           permission_id:'',
           formDataAll:'',
           weekly_id:0,
           weeks_id:0,
           weekly_data:'',
           months_id:0,
           permission_id_name:'',
           employees_list:[],
         }
       },

        created(){
            // this.getResults(1);
            this.getResults(1,this.$route.params.id);
            this.modal_loading= true;
        },
        components:{
            pageLoading:Loading,
            VueTimepicker 
        },
        computed: {
    options: () => countries,
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
          updateCountry (form_data,shift) {
            form_data.shift =shift ;
          },
          addRow(event,approval_infos) {
              var aaa= this.form_data.approval_infos.length;
              this.form_data.approval_infos.push({
                  permission_id:this.permission_id,
                  permission_type:this.noticeToType,
                  permission_type_name:this.noticeToTypeName,
                  permission_id_name:this.permission_id_name,
              })
              console.log(this.form_data.approval_infos);
          },
          deleteRow(index) {
            this.form_data.approval_infos.splice(index,1);
          },


        monthlySelect(event){
          if(event.target.value==1){
            this.weekly_id=0;
          }else{
            this.weekly_id=1;
          }
        },
        weekSelect(event){
          this.weeks_id=event.target.value;
        },
        monthsSelectsId(event){
            this.months_id=event.target.value;
        }, 
        SalaryTypeId(event){
            this.salary_type_id=event.target.value;
        }, 
        SalaryGrade(event){
            this.salary_grade=event.target.value;
        },
        employeesSbu(option){
          this.modal_loading= false;
          let uri = URL.baseUrl('payrollprocess/fiends');
          axios.post(uri,
            {
                id:option.id,
                months_id:this.months_id,
                salary_type_id:this.salary_type_id,
                salary_grade:this.salary_grade,
            }).then(res => {
              console.log(res);
              this.form_data=res.data;
              this.modal_loading= true;
              // console.log('hell');
            })
            .catch(error => {
              this.modal_loading= true;
          })


        },
        onSelectJobGrade(option){
          console.log(option);
          this.form_data.employee_job_grade= option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
          console.log(this.form_data.employee_job_grade);
        },
        onSelectEmployee(option){
          console.log(option);
          this.form_data.employee_id = option.id;
          this.permission_id=option.id;
          this.permission_id_name=option.text;
        },  
       setModalData(){
         this.sbu_name_value=this.form_data.sbu_name_value;
         this.section_value=this.form_data.section_value;
         this.sub_section_value=this.form_data.sub_section_value;
         this.employee_group_value=this.form_data.employee_group_value;
         this.department_name_value=this.form_data.department_name_value;
         this.designation_name_value=this.form_data.designation_name_value;
         this.jobgrade_name_value=this.form_data.jobgrade_name_value;
         this.sub_unit_value=this.form_data.sub_unit_value;
         this.employee_name_value=this.form_data.employee_name_value;
         this.work_location_value=this.form_data.work_location_value;
         this.general_data_temp=this.form_data.general_info_temp;
       },
       resetModal(){
           this.sbu_name_value='';
           this.section_value='';
           this.sub_section_value='';
           this.employee_group_value='';
           this.department_name_value='';
           this.designation_name_value='';
           this.jobgrade_name_value='';
           this.unit_value='';
           this.sub_unit_value='';
           this.employee_name_value='';
           this.work_location_value='';
           this.form_data.employee_status='1';
           this.form_data.emplyee_category_mgt_non_mgt='2';
           this.form_data.employee_leave_group='1';
           this.form_data.employee_type='2';
           this.form_data.make_user='';
           this.form_data.user_type='0'
           this.form_data.ea_approve_by_name='';
           this.form_data.employee_mobile='';
           this.form_data.employee_id='';
           this.form_data.employee_number='';
           this.form_data.employee_fullname='';
           this.form_data.employee_joining_date='';
           this.form_data.employee_image='';
           this.form_data.make_user='';
           this.approvalnamevalue1="";
     },

     notice_to(event){
     	console.log(event.target.name);
     	if (event.target.value==1) {
     		this.noticeToType=1;
        this.noticeToTypeName='Company/SBU';
     	}else if(event.target.value==2){
     		this.noticeToType=2;
        this.noticeToTypeName='Department';
     	}else if(event.target.value==3){
     		this.noticeToType=3;
        this.noticeToTypeName='Unit';
     	}else if(event.target.value==4){
     		this.noticeToType=4;
        this.noticeToTypeName='Sub Unit';
     	}else if(event.target.value==5){
     		this.noticeToType=5;
        this.noticeToTypeName='Section';
     	}else if(event.target.value==6){
     		this.noticeToType=6;
        this.noticeToTypeName='Sub Section';
     	}else if(event.target.value==7){
     		this.noticeToType=7;
        this.noticeToTypeName='Employee';
     	}
     }
	}
}



</script>

<style type="text/css">
  .employeeTable_ids.table th {
        padding: 4px 5px !important;
}
.div_class {
  /*width: 500px;*/
  /*overflow-x: scroll;*/
  margin-left: 193px;
  overflow-y: visible;
  padding: 0;
}
.headcol {
  position: absolute;
  /*width: 5em;*/
  width: 200px;
  left: 0;
  top: auto;
  border-top-width: 1px;
  /*only relevant for first row*/
  margin-top: -1px;
  /*compensate for top border*/
}
.headcol:before {
  content: '';
}
.select_id > .multiselect > .multiselect__tags{
  min-height: 41px !important;
}

</style>
