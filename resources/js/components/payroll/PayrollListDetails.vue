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
                              <!-- {{lists.final_settlement}} -->
                                <h5 style=" margin-top: -5px;">{{lists.company_info}}</h5>
                                <!-- <h6 style=" margin-top: -4px;">Dhanmondi 27, Dhaka 1212, Bangladesh</h6> -->
                                <h6 style=" margin-top: -6px;"> 
                                  <!-- {{this.$route.params.id}}  -->
                                  For the Month of {{ lists.month_name}} <span style=" font-size: 12px;">({{ lists.report_date }})</span></h6>
                            </div>
                            <div class="col-md-12 payroll-process">
                              <div class=" " style="min-height: 56px;" v-if="modal_loading">
                              <table id='tblCustomers' class="table table-bordered  table-striped employeeTable" style="table-layout:fixed;width: 100% !important">
                                <thead>
                                  <tr style="text-align: center;">
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px" v-if="lists.final_settlement==1">Action</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 50px;" >Sl.</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Employee ID</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Employee Name</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Designation</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Department</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 200px;" >Work Location</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >SBU</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 60px;" >Grade</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 95px;"  >Joining Date</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >A/C No</th>
                                    <th class="ths" colspan="6" style="vertical-align: middle;width: 400px;" >Attendance</th>
                                    <th v-if="form_data.company_id == 26" class="ths" rowspan="2" style="vertical-align: middle;width: 85px;" >T. Off Days Worked</th>
                                    <!-- <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Salary</th> -->
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Salary</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Absent</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 100px;" >Gross Payable</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >Basic Salary</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >House Rent</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 90px;" >Med. Allow</th>
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 81px;" >Conv. Allow</th>
                                    <th v-if="form_data.company_id == 26"  class="ths" rowspan="2" style="vertical-align: middle;width: 82px;" >Day off allow.</th>
                                    <th class="ths" colspan="6" style="vertical-align: middle;width: 450px;" >Addition</th>
                                     <!-- <th class="ths" colspan="3" style="vertical-align: middle;width: 250px;" > Provident Fund </th> -->
                                    <th class="ths" colspan="8" style="vertical-align: middle;width: 600px;" >Deduction</th>
                                    <!-- <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >L & A Deduct.</th> -->
                                    <th class="ths" rowspan="2" style="vertical-align: middle;width: 120px;" >Net Payable</th>
                                    <th class="ths" rowspan="2" style="text-align: center;width: 120px; " >Remarks</th>
                                  </tr>
                                  <tr>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Present Day"> P</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Late Day"> L</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Weekend/Holiday"> W/H</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Absent Day"> A</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Deduction Day"> D. Day</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title=""> Pay Day</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title=""> Arrear</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title=""> Mobile</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center"> Car</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center"> Incentive</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center"> Allowance</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center"> Other</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Provident Fund"> PF</th>
                                    <!-- <th class="ths" style="vertical-align: middle;text-align: center" title="Comapany Provident Fund"> CPF</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Total Provident Fund"> TPF</th> -->
                                    <th class="ths" style="vertical-align: middle;text-align: center" title="Advance"> Adv./Loan</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Uniform</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Deposit</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > TAX</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Mobile</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Late</th>
                                    <th class="ths" style="vertical-align: middle;text-align: center" > Other</th>
                                    <!-- <th class="ths" style="vertical-align: middle;text-align: center" title="Late & Abasent Deduction"> L & A Deduct.</th> -->
                                  </tr>
                                </thead>
                                 <tbody>
                                  <tr v-for="(form_data, index) in lists.employee_data" v-bind:key="form_data.id" >
                                    <td class="text-center" v-if="lists.final_settlement==1">
                                      <button v-if="lists.edit=='edit'" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" class="btn btn-info btn-xs" title="Edit" data-toggle="modal" data-target="#addNewJobGrade" > <i class="fa fa-edit"> </i> 
                                      <!-- Edit  -->
                                      </button>
                                      <button v-if="lists.delete=='delete'" @click="deleteItem({delUrl:'softdelete/employee_salary/'+form_data.procsid+'/'+form_data.empid})" title="Delete" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i> 
                                      <!-- Delete -->
                                      </button>
                                    </td>
                                    <td class="ths" style="text-align: center"  @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)">{{index+1}}</td>
                                    <td class="ths" style="text-align: center"  @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"> {{form_data.employee_id_no}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)">{{form_data.employee_fullname}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)">{{form_data.designation_name}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)">{{form_data.department_name}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" >{{form_data.work_location_name}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" >{{form_data.sbu_short_name}}</td>
                                    <td class="ths" style="text-align: center" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" >{{form_data.jobgrade_name}}</td>
                                    <td class="ths" style="text-align: center" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" >{{form_data.employee_joining_date}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" >{{form_data.ebc_account_number}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" style="vertical-align: middle;text-align: center">{{form_data.prtot}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" style="vertical-align: middle;text-align: center">{{form_data.lttot}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" style="vertical-align: middle;text-align: center">{{form_data.whtot}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" style="vertical-align: middle;text-align: center">{{form_data.abtot}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" style="vertical-align: middle;text-align: center">{{form_data.total_deduction_day}}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" style="vertical-align: middle;text-align: center">{{form_data.pay_day}}</td>

                                    <td v-if="form_data.companysbu_id == 26" class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)" style="vertical-align: middle;text-align: center">{{form_data.total_day_off_worked}}</td>

                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.g_salary |number('0,0.00') }}</td>

                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.absent_deduction |number('0,0.00') }}</td>

                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.g_payble |number('0,0.00') }}</td>

                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.basic |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.houserent |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.medical |number('0,0.00') }}</td>

                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.transport |number('0,0.00') }}</td>

                                    <td v-if="form_data.companysbu_id == 26" class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.day_off_allowance |number('0,0.00') }}</td>
                                    
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.arear |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.additional_mobile |number('0,0.00') }}</td>
  
  
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.car_allowance |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.incentive |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.allowance |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.other_allownce |number('0,0.00') }}</td>
  
  
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_pfbasic |number('0,0.00') }}</td>
                                    <!-- <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_pfbasic |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{(form_data.deduction_pfbasic+form_data.deduction_pfbasic) |number('0,0.00') }}</td> -->
  
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_loan |number('0,0.00') }}</td> 
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_uniform |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_deposit |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_tax |number('0,0.00') }}</td> 
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_mobilebill |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.late_deduction |number('0,0.00') }}</td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.deduction_others |number('0,0.00') }}</td>
                                    <!-- <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 81px;vertical-align: middle; text-align: right;">{{form_data.late_abset_deduction |number('0,0.00') }}</td> -->
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 180px;vertical-align: middle; text-align: right;">
                                      {{(form_data.netpay) |number('0,0.00') }}
                                    </td>
                                    <td class="ths" @click="getModalData($event,{dataUrl:'edit/employee_salary/'+form_data.procsid+'/'+form_data.empid},setModalData)"  style="width: 180px;text-align: left;">
                                      {{(form_data.remarks) | '' }}
                                    </td>
                                  </tr>


                                  <tr>
                                    <td class="ths" style="text-align: right"></td>
                                    <td class="ths" colspan="16" style="text-align: right;font-weight: bold">Total</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_gross_salary | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_absent_amount | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_gross_payable | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_basic | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_houserent | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_medical | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_transport | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_arear | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_additional_mobile | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_car_allowance | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_incentive | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_allowance | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_other_allownce | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_deduction_pfbasic | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_deduction_loan | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_deduction_uniform | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_deduction_deposit | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_deduction_tax | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_deduction_mobilebill | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_late_deduction | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_deduction_others | number('0,0.00') }}</td>
                                    <td class="ths" style="text-align: right; font-weight: bold">{{ lists.total_netpay | number('0,0.00') }}</td>
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
        <modal class="" name="myModal" height="auto" :clickToClose="false" width="800">
          <div v-if="modal_loading">
              <div class="widget-header modal-header" style="margin-bottom: 0px;">
                  <h4><i class="fa fa-bars"></i>
                    Employee Salary Update
                  </h4>
                  <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modify-wraper modal-body">
                  <form @submit.prevent="add_salary_update({add:'update/employee_salary'},resetModal)" class="form-horizontal  row-border" id="validate-1">
                    <div class="">
                      <div class="row">
                        <input type="hidden" v-model="form_data.employee_sbu">
                        <input type="hidden" v-model="form_data.companysbu_id">
                      </div>
                      <div class="col-md-12" style="padding:8px;">
                        <div class="form-group">
                            <div class="row">
                              <div
                              class="col-md-12"
                              style="
                                border: 1px solid #cfcfcf;
                                margin-left: 12px;
                                padding-right: 0px;
                                max-width: 97%;
                                margin-bottom: 15px;
                              "
                            >
                              <div
                                class="col-md-12 modify-wraper float-left"
                                style="padding: 0px"
                              >
                                <table 
                                  class="table table-hover table-responsive"
                                  style="margin: 5px;"
                                >
                                  <tbody>
                                    <tr>
                                      <td style="font-weight: bold; width: 10%">
                                        Name
                                      </td>
                                      <td style="font-weight: bold">:</td>
                                      <td
                                        style="
                                          width: 55%;
                                          padding-left: 0px;
                                          padding-right: 0px;
                                        "
                                      >
                                        {{
                                          form_data.employee_fullname
                                        }}
                                      </td>
                                      <td style="font-weight: bold; width: 5%">
                                        ID
                                      </td>
                                      <td style="font-weight: bold">:</td>
                                      <td
                                        style="
                                          width: 40%;
                                          padding-left: 0px;
                                          padding-right: 0px;
                                        "
                                      >
                                        <input
                                          type="hidden"
                                          v-model="form_data.employee_id"
                                          name=""
                                        />
                                        {{
                                          form_data.employee_id_no
                                        }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight: bold; width: 10%">
                                        Designation
                                      </td>
                                      <td style="font-weight: bold">:</td>
                                      <td
                                        style="
                                          width: 40%;
                                          padding-left: 0px;
                                          padding-right: 0px;
                                        "
                                      >
                                        {{
                                          form_data.designation_name
                                        }}
                                      </td>
                                      <td style="font-weight: bold">Contact</td>
                                      <td style="font-weight: bold">:</td>
                                      <td
                                        style="
                                          width: 25%;
                                          padding-left: 0px;
                                          padding-right: 0px;
                                        "
                                      >
                                        {{
                                          form_data.employee_mobile
                                        }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight: bold; width: 10%">
                                        Department
                                      </td>
                                      <td style="font-weight: bold">:</td>
                                      <td
                                        style="
                                          width: 40%;
                                          padding-left: 0px;
                                          padding-right: 0px;
                                        "
                                      >
                                        {{
                                          form_data.department_name
                                        }}
                                      </td>
                                      <td style="font-weight: bold">Joining</td>
                                      <td style="font-weight: bold">:</td>
                                      <td
                                        style="
                                          width: 25%;
                                          padding-left: 0px;
                                          padding-right: 0px;
                                        "
                                      >
                                        {{
                                          form_data.employee_joining_date
                                        }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="font-weight: bold">SBU</td>
                                      <td style="font-weight: bold">:</td>
                                      <td
                                        style="
                                          width: 33%;
                                          padding-left: 0px;
                                          padding-right: 0px;
                                        "
                                      >
                                        {{
                                          form_data.sbu_name
                                        }}
                                      </td>
                                      <td style="font-weight: bold">Location</td>
                                      <td style="font-weight: bold">:</td>
                                      <td
                                        style="
                                          width: 33%;
                                          padding-left: 0px;
                                          padding-right: 0px;
                                        "
                                      >
                                        {{
                                          form_data.work_location_name
                                        }},
  
                                        <span><strong>Payable Salary :</strong> <u>{{form_data.gross_salary}}</u></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <!-- <div
                                class="col-md-2 float-left"
                                style="padding: 0px; text-align: right !important"
                              >
                                <span
                                  v-if="form_data.employee_image"
                                >
                                  <img
                                    :src="`images/${form_data.employee_image}`"
                                    class="card-img-top border rounded"
                                    style="
                                      margin-top: 1px;
                                      width: 119px;
                                      height: 132px;
                                      margin-left: -9px;
                                      margin-right: 1px;
                                    "
                                  />
                                </span>
                                <span v-else>
                                  <img
                                    v-if="form_data.employee_image !== ''"
                                    :src="`images/default.png`"
                                    class="card-img-top border rounded"
                                    style="
                                      margin-top: 1px;
                                      width: 119px;
                                      height: 132px;
                                      margin-left: -9px;
                                      margin-right: 1px;
                                    "
                                  />
                                </span>
                              </div> -->
                            </div>
                            <hr />
                              <!-- <div class="col-md-4">
                                  <label class="col-md-12 control-label">Gross Salary</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="gross_salary" v-model="form_data.gross_salary" name="gross_salary"  class="form-control" type="text"></div>
                                  </div>
                              </div> -->
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Basic Salary</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="basic" v-model="form_data.basic" name="basic" class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">House Rent</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="houserent" v-model="form_data.houserent" name="houserent" class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Medical Allowance</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="medical" v-model="form_data.medical" name="medical" class="form-control" type="text"></div>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Conveyance Allowance</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="transport" v-model="form_data.transport" name="transport"  class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Arrear</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="arear" v-model="form_data.arear" name="arear" class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Mobile Allowance</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="additional_mobile" v-model="form_data.additional_mobile" name="additional_mobile" class="form-control" type="text"></div>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Car Allowance</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="car_allowance" v-model="form_data.car_allowance" name="car_allowance"  class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Others Allowance</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="allowance" v-model="form_data.allowance" name="allowance" class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Provident Fund</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="deduction_pfbasic" v-model="form_data.deduction_pfbasic" name="deduction_pfbasic" class="form-control" type="text"></div>
                                  </div>
                              </div>
                            </div>
                        </div>
  
                        <div class="form-group">
                            <div class="row">
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Advance/Loan</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="deduction_loan" v-model="form_data.deduction_loan" name="deduction_loan" class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Uniform</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="deduction_uniform" v-model="form_data.deduction_uniform" name="deduction_uniform"  class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Deposit</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="deduction_deposit" v-model="form_data.deduction_deposit" name="deduction_deposit" class="form-control" type="text"></div>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">TAX</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="deduction_tax" v-model="form_data.deduction_tax" name="deduction_tax" class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Mobile</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="deduction_mobilebill" v-model="form_data.deduction_mobilebill" name="deduction_mobilebill"  class="form-control" type="text"></div>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <label class="col-md-12 control-label">Other Deduction</label>
                                  <div class="col-md-12 inputGroupContainer">
                                      <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                      <input id="deduction_others" v-model="form_data.deduction_others" name="deduction_others" class="form-control" type="text"></div>
                                  </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions col-md-12">
                        <input type="submit"   tabindex="4" value="Update" class="btn btn-sm btn-info float-right col-md-2" >
                        <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6" style="margin-right: 10px;">Close</button>
                    </div>
                </form>
              </div>
          </div>
          <div v-if="!modal_loading">
              <pageLoading></pageLoading>
          </div>
        </modal>
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
             company_id:''
           }
         },
  
          created(){
            this.page_loading= true;
            this.getResults(1,this.$route.params.id);
              // this.getResults(1);
          },
          components:{
              pageLoading:Loading,
              VueTimepicker 
          },
          computed: {
      options: () => countries,
    },
        methods:{
            add_salary_update(addUrl, callback) {
                this.modal_loading = false;
                this.page_loading = false;
                axios.post(URL.baseUrl(addUrl.add), this.form_data)
                    .then(res => {
                        if (res.data.status == 1) {
                            this.showToster(res.data);
                            this.getResults(1,this.$route.params.id);
                            if (!this.form_data.id) {
                                if (this.$route.params.folderId) {
                                    this.getResults(1,this.$route.params.id);
                                } else {
                                    this.getResults(1,this.$route.params.id);
                                }
                                this.hideModal();
                                this.emphideModal();
                                if(typeof emphideModal == 'function'){
                                this.emphideModal();
                                }
                                this.page_loading = true;
                                this.modal_loading=true;
                            } else {
                                this.modal_loading = true;
                                this.page_loading = true;
                                this.hideModal();
                                this.emphideModal();
                                if(typeof emphideModal == 'function'){
                                    this.emphideModal();
                                    }
                                if (this.$route.params.folderId) {
                                    this.getResults(1,this.$route.params.id);
                                } else {
                                    this.getResults(this.current_page_no,this.$route.params.id);
                                }
                            }
                            this.page_loading = true;
                            this.modal_loading=true;
                        }
                        this.showToster(res.data);
                        this.modal_loading = true;
                        this.errors = null;
                        this.getResults(1,this.$route.params.id);
                        if (callback) {
                            callback();
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                        this.page_loading = true;
                        this.modal_loading=true;
                        var msg = 'opps! something went wrong';
                        this.showToster({ status: 0, message: msg });
                    });
            },
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
  .payroll-process{
    font-size: 12px !important;
  }

  .payroll-process table thead th{
    background: #ddd !important;
    padding: 5px !important;
    font-size: 12px !important;
  }
  .payroll-process table tbody td{
    font-size: 12px !important;
  }
  .payroll-process table td{
    padding: 0px !important;
  }
  </style>
  