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
                               <h3 class="card-title d-none d-md-block">Pay Slip Details</h3>
                               <span class="float-sm-right" style="float: right;">
                                 <button id="btnExport"  @click="tableToExcel" class="btn-success" style="margin-left:10px;"> <i class="fa fa-file-excel"></i> Export</button>
                                 <button @click="printDiv()"  class="btn-info"> <i class="fa fa-print"></i> Print</button>
                                  <a class="btn btn-default" @click="$router.go(-1)"><i class="fa fa-arrow-left"></i> Back</a>
                               </span>
                           </div>
                       </div>
                    </div>
                    <div class="card-body col-md-12">
                    	<div id="printable">
                    		<div class="row">
                    			<div id="page-header" class="col-lg-12" style="display: none;">
                    				<h3 class="page-header text-center">Pay Slip Details <small> </small>        
                    	    	                </h3>
                    			</div>
                    			<div class="col-md-12">
                                        <span >
                                            <table width="100%">
                                                <tr>
                                                    <td  style="width: 20%;text-align: right;">
                                                        <div class="row">
                                                            <div class="col-md-12 text-right">
                                                                <p><i>Printing Date: {{lists.print_date}}</i></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                                
                                            <table width="100%">
                                                <tr>
                                                 <div class="row" style="padding-bottom:15px;">
                                                    <td style="width: 20%">
                                                        <div class="col-md-12">
                                                           <img :src="`company_logo/${lists.sbu_logo}`" class="card-img-top  rounded" style="margin-top: 2px; width: 100px;  border-radius: 50px;" alt="Company Logo">
                                                        </div>
                                                    </td>
                                                    <td style="width: 60%; text-align: center;" >
                                                        <div class="col-md-12 text-center">
                                                            <h3>Pay Slip</h3>
                                                            <h4>Month of {{lists.salary_date}}</h4>
                                                        </div>
                                                    </td>
                                                    <td style="width: 20%">
                                                        <div class="col-md-12 text-right">
                                                            <p>(Office Copy)</p>
                                                        </div>
                                                    </td>
                                                  </div>
                                               </tr>
                                            </table>
                                            <table width="100%" class="table table-hover tablesorter " id="gridtable">
                                                <tbody>
                                                    <tr>
                                                        <td align="left"><h4>{{lists.paySlipDetails.employee_fullname}}</h4></td>
                                                        <td align="right">Employee ID</td>
                                                        <td align="center">:</td>
                                                        <td align="left">{{lists.paySlipDetails.employee_id_no}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">{{lists.paySlipDetails.designation_name}}</td>
                                                        <td align="right">Location</td>
                                                        <td align="center">:</td>
                                                        <td align="left">{{lists.paySlipDetails.work_location_name}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table width="100%" class="text-center table table-hover tablesorter" style="margin-bottom: 0px;">
                                                <thead>
                                                    <tr>
                                                        <th class="ths" align="center"><h6>Bank Payment</h6></th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <table width="100%">
                                                <tr>
                                                    <td style="width: 50%">
                                                        <table width="95%" class="table table-hover tablesorter table-bordered" id="gridtable">
                                                            <thead>
                                                                <tr>
                                                                    <th class="header ths  text-center">Gross Salary </th>
                                                                    <th class="header ths text-center">:</th>
                                                                    <th class="header ths text-center">Tk. {{lists.paySlipDetails.gross_salary |number('0,0.00') }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="header ths text-center" colspan="3">Earnings</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="ths" align="left">Basic Salary</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.basic |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">House Rent</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.houserent |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Medical Allowance</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.medical |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Conveyence</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.transport |number('0,0.00') }}</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td class="ths" align="left">Arrears</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.arear |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Mobile</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.additional_mobile |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Other</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.allowance |number('0,0.00') }}</td>
                                                                </tr>
                                                               
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th class="ths" >Gross Payable</th>
                                                                    <th  class="ths" style="text-align: center;">:</th>
                                                                    <th  class="ths" style="text-align: right;">{{(lists.paySlipDetails.gross_salary+lists.paySlipDetails.arear+lists.paySlipDetails.additional_mobile+lists.paySlipDetails.allowance) |number('0,0.00') }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </td>
                                                    <td style="width: 50%">
                                                        <table width="100%" class="table table-hover tablesorter table-bordered" id="gridtable">
                                                        <thead>
                                                            <tr>
                                                                <th class="header ths text-center">Net payable Salary</th>
                                                                <th class="header ths text-center">:</th>
                                                                <th class="header ths text-center">Tk. {{lists.paySlipDetails.netpay |number('0,0.00') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="header ths text-center" colspan="3">Deduction</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="ths" align="left">Provident Fund</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_pfbasic |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Income Tax at Source</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_tax |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Loan Installment 4/6</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_loan |number('0,0.00')}}</td>
                                                            </tr>
                                                             <tr>
                                                                <td class="ths" align="left">Mobile </td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_mobilebill |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Uniform </td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_uniform |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Deposit</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_deposit |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Other</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_others |number('0,0.00')}}</td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th class="ths">Total Deduction</th>
                                                                <th class="ths" style="text-align: center;">:</th>
                                                                <th class="ths" style="text-align: right;">
                                                                {{((lists.paySlipDetails.gross_salary+lists.paySlipDetails.arear+lists.paySlipDetails.additional_mobile+lists.paySlipDetails.allowance)- lists.paySlipDetails.netpay)|number('0,0.00') }}</th>
                                                            </tr>
                                                        </tfoot>
                                                       </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </span>
                                    
<!-- ------------------------------------------------------------------------------------------------- -->
                                        <span v-if="lists.salary_type === 1">
                                            <table width="100%" class="text-center table table-hover tablesorter" style="margin-bottom: 0px;">
                                                <thead>
                                                    <tr>
                                                        <th class="ths" align="center"><h6>Cash Payment</h6></th>
                                                    </tr>
                                                </thead>
                                              </table>
                                            <table width="100%">
                                                <tr>
                                                    <td style="width: 50%">
                                                        <table width="95%" class="table table-hover tablesorter table-bordered" id="gridtable">
                                                            <thead>
                                                                <tr>
                                                                    <th class="header ths  text-center">Gross Salary </th>
                                                                    <th class="header ths text-center">:</th>
                                                                    <th class="header ths text-center">Tk. {{lists.paySlipCash.gross_salary |number('0,0.00') }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="header ths text-center" colspan="3">Earnings</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="ths" align="left">Basic Salary</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipCash.basic |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">House Rent</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipCash.houserent |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Medical Allowance</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipCash.medical |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Conveyence</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipCash.transport |number('0,0.00') }}</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td class="ths" align="left">Arrears</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipCash.arear |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Mobile</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipCash.additional_mobile |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Other</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipCash.allowance |number('0,0.00') }}</td>
                                                                </tr>
                                                               
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th class="ths" >Gross Payable</th>
                                                                    <th  class="ths" style="text-align: center;">:</th>
                                                                    <th  class="ths" style="text-align: right;">{{(lists.paySlipCash.gross_salary+lists.paySlipCash.arear+lists.paySlipCash.additional_mobile+lists.paySlipCash.allowance) |number('0,0.00') }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </td>
                                                    <td style="width: 50%">
                                                        <table width="100%" class="table table-hover tablesorter table-bordered" id="gridtable">
                                                        <thead>
                                                            <tr>
                                                                <th class="header ths text-center">Net payable Salary</th>
                                                                <th class="header ths text-center">:</th>
                                                                <th class="header ths text-center">Tk. {{lists.paySlipCash.netpay |number('0,0.00') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="header ths text-center" colspan="3">Deduction</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="ths" align="left">Provident Fund</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipCash.deduction_pfbasic |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Income Tax at Source</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipCash.deduction_tax |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Loan Installment 4/6</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipCash.deduction_loan |number('0,0.00')}}</td>
                                                            </tr>
                                                             <tr>
                                                                <td class="ths" align="left">Mobile </td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipCash.deduction_mobilebill |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Uniform </td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipCash.deduction_uniform |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Deposit</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipCash.deduction_deposit |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Other</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipCash.deduction_others |number('0,0.00')}}</td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th class="ths">Total Deduction</th>
                                                                <th class="ths" style="text-align: center;">:</th>
                                                                <th class="ths" style="text-align: right;">
                                                                {{((lists.paySlipCash.gross_salary+lists.paySlipCash.arear+lists.paySlipCash.additional_mobile+lists.paySlipCash.allowance)- lists.paySlipCash.netpay)|number('0,0.00') }}</th>
                                                            </tr>
                                                        </tfoot>
                                                       </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </span>    
                                			</div>

                                             <div class="col-md-12" v-if="lists.salary_type !== 1">
                                                <p style="border-bottom: dashed 1px #000;"></p>
                                            </div>
                                             

<!-- --- ---------------------------------------------2nd------------------------------------------------>
                                            <div class="col-md-12">
                                       <span>

                                                <table width="100%">
                                                    <tr>
                                                        <td  style="width: 20%;text-align: right;">
                                                            <div class="row">
                                                                <div class="col-md-12 text-right">
                                                                    <p><i>Printing Date: {{lists.print_date}}</i></p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                    
                                                <table width="100%">
                                                    <tr>
                                                     <div class="row" style="padding-bottom:15px;">
                                                        <td style="width: 20%">
                                                            <div class="col-md-12">
                                                               <img :src="`company_logo/${lists.sbu_logo}`" class="card-img-top  rounded" style="margin-top: 2px; width: 100px;  border-radius: 50px;" alt="Company Logo">
                                                            </div>
                                                        </td>
                                                        <td style="width: 60%; text-align: center;" >
                                                            <div class="col-md-12 text-center">
                                                                <h3>Pay Slip</h3>
                                                                <h4>Month of {{lists.salary_date}}</h4>
                                                            </div>
                                                        </td>
                                                        <td style="width: 20%">
                                                            <div class="col-md-12 text-right">
                                                                <p>(Employee Copy)</p>
                                                            </div>
                                                        </td>
                                                      </div>
                                                   </tr>
                                                </table>
                                                <table width="100%" class="table table-hover tablesorter " id="gridtable">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left"><h4>{{lists.paySlipDetails.employee_fullname}}</h4></td>
                                                            <td align="right">Employee ID</td>
                                                            <td align="center">:</td>
                                                            <td align="left">{{lists.paySlipDetails.employee_id_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left">{{lists.paySlipDetails.designation_name}}</td>
                                                            <td align="right">Location</td>
                                                            <td align="center">:</td>
                                                            <td align="left">{{lists.paySlipDetails.work_location_name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </span>
                                            <table width="100%" class="text-center table table-hover tablesorter" style="margin-bottom: 0px;">
                                                <thead>
                                                    <tr>
                                                        <th class="ths" align="center"><h6>Bank Payment</h6></th>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <table width="100%">
                                                <tr>
                                                    <td style="width: 50%">
                                                        <table width="95%" class="table table-hover tablesorter table-bordered" id="gridtable">
                                                            <thead>
                                                                <tr>
                                                                    <th class="header ths  text-center">Gross Salary </th>
                                                                    <th class="header ths text-center">:</th>
                                                                    <th class="header ths text-center">Tk. {{lists.paySlipDetails.gross_salary |number('0,0.00') }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="header ths text-center" colspan="3">Earnings</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="ths" align="left">Basic Salary</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.basic |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">House Rent</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.houserent |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Medical Allowance</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.medical |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Conveyence</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.transport |number('0,0.00') }}</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td class="ths" align="left">Arrears</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.arear |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Mobile</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.additional_mobile |number('0,0.00') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="ths" align="left">Other</td>
                                                                    <td class="ths" align="center">:</td>
                                                                    <td class="ths" align="right">{{lists.paySlipDetails.allowance |number('0,0.00') }}</td>
                                                                </tr>
                                                               
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th class="ths" >Gross Payable</th>
                                                                    <th  class="ths" style="text-align: center;">:</th>
                                                                    <th  class="ths" style="text-align: right;">{{(lists.paySlipDetails.gross_salary+lists.paySlipDetails.arear+lists.paySlipDetails.additional_mobile+lists.paySlipDetails.allowance) |number('0,0.00') }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </td>
                                                    <td style="width: 50%">
                                                        <table width="100%" class="table table-hover tablesorter table-bordered" id="gridtable">
                                                        <thead>
                                                            <tr>
                                                                <th class="header ths text-center">Net payable Salary</th>
                                                                <th class="header ths text-center">:</th>
                                                                <th class="header ths text-center">Tk. {{lists.paySlipDetails.netpay |number('0,0.00') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="header ths text-center" colspan="3">Deduction</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="ths" align="left">Provident Fund</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_pfbasic |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Income Tax at Source</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_tax |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Loan Installment 4/6</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_loan |number('0,0.00')}}</td>
                                                            </tr>
                                                             <tr>
                                                                <td class="ths" align="left">Mobile </td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_mobilebill |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Uniform </td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_uniform |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Deposit</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_deposit |number('0,0.00')}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Other</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.deduction_others |number('0,0.00')}}</td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th class="ths">Total Deduction</th>
                                                                <th class="ths" style="text-align: center;">:</th>
                                                                <th class="ths" style="text-align: right;">
                                                                {{((lists.paySlipDetails.gross_salary+lists.paySlipDetails.arear+lists.paySlipDetails.additional_mobile+lists.paySlipDetails.allowance)- lists.paySlipDetails.netpay)|number('0,0.00') }}</th>
                                                            </tr>
                                                        </tfoot>
                                                       </table>
                                                    </td>
                                                </tr>
                                            </table>
                                    <!-- </span> -->

<!-- ------------------------------------------------------------------------------------------------- -->
                                    <span v-if="lists.salary_type ===1">
                                        <table width="100%" class="text-center table table-hover tablesorter" style="margin-bottom: 0px;">
                                            <thead>
                                                <tr>
                                                    <th class="ths" align="center"><h6>Cash Payment</h6></th>
                                                </tr>
                                            </thead>
                                        </table>

                                        <table width="100%">
                                            <tr>
                                                <td style="width: 50%">
                                                    <table width="95%" class="table table-hover tablesorter table-bordered" id="gridtable">
                                                        <thead>
                                                            <tr>
                                                                <th class="header ths  text-center">Gross Salary </th>
                                                                <th class="header ths text-center">:</th>
                                                                <th class="header ths text-center">Tk. {{lists.paySlipDetails.gross_salary |number('0,0.00') }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="header ths text-center" colspan="3">Earnings</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="ths" align="left">Basic Salary</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.basic |number('0,0.00') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">House Rent</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.houserent |number('0,0.00') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Medical Allowance</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.medical |number('0,0.00') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Conveyence</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.transport |number('0,0.00') }}</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td class="ths" align="left">Arrears</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.arear |number('0,0.00') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Mobile</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.additional_mobile |number('0,0.00') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="ths" align="left">Other</td>
                                                                <td class="ths" align="center">:</td>
                                                                <td class="ths" align="right">{{lists.paySlipDetails.allowance |number('0,0.00') }}</td>
                                                            </tr>
                                                           
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th class="ths" >Gross Payable</th>
                                                                <th  class="ths" style="text-align: center;">:</th>
                                                                <th  class="ths" style="text-align: right;">{{(lists.paySlipDetails.gross_salary+lists.paySlipDetails.arear+lists.paySlipDetails.additional_mobile+lists.paySlipDetails.allowance) |number('0,0.00') }}</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </td>
                                                <td style="width: 50%">
                                                    <table width="100%" class="table table-hover tablesorter table-bordered" id="gridtable">
                                                    <thead>
                                                        <tr>
                                                            <th class="header ths text-center">Net payable Salary</th>
                                                            <th class="header ths text-center">:</th>
                                                            <th class="header ths text-center">Tk. {{lists.paySlipDetails.netpay |number('0,0.00') }}</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="header ths text-center" colspan="3">Deduction</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="ths" align="left">Provident Fund</td>
                                                            <td class="ths" align="center">:</td>
                                                            <td class="ths" align="right">{{lists.paySlipDetails.deduction_pfbasic |number('0,0.00')}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ths" align="left">Income Tax at Source</td>
                                                            <td class="ths" align="center">:</td>
                                                            <td class="ths" align="right">{{lists.paySlipDetails.deduction_tax |number('0,0.00')}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ths" align="left">Loan Installment 4/6</td>
                                                            <td class="ths" align="center">:</td>
                                                            <td class="ths" align="right">{{lists.paySlipDetails.deduction_loan |number('0,0.00')}}</td>
                                                        </tr>
                                                         <tr>
                                                            <td class="ths" align="left">Mobile </td>
                                                            <td class="ths" align="center">:</td>
                                                            <td class="ths" align="right">{{lists.paySlipDetails.deduction_mobilebill |number('0,0.00')}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ths" align="left">Uniform </td>
                                                            <td class="ths" align="center">:</td>
                                                            <td class="ths" align="right">{{lists.paySlipDetails.deduction_uniform |number('0,0.00')}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ths" align="left">Deposit</td>
                                                            <td class="ths" align="center">:</td>
                                                            <td class="ths" align="right">{{lists.paySlipDetails.deduction_deposit |number('0,0.00')}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ths" align="left">Other</td>
                                                            <td class="ths" align="center">:</td>
                                                            <td class="ths" align="right">{{lists.paySlipDetails.deduction_others |number('0,0.00')}}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="ths">Total Deduction</th>
                                                            <th class="ths" style="text-align: center;">:</th>
                                                            <th class="ths" style="text-align: right;">
                                                            {{((lists.paySlipDetails.gross_salary+lists.paySlipDetails.arear+lists.paySlipDetails.additional_mobile+lists.paySlipDetails.allowance)- lists.paySlipDetails.netpay)|number('0,0.00') }}</th>
                                                        </tr>
                                                    </tfoot>
                                                   </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </span>
                                    <hr style="margin-top: 1rem;margin-bottom: 1rem;border-top: 1.6px solid rgb(52 58 65);">
                                    <div class="row text-center">
                                        <p class="text-center"> <i>This is computer generated copy and does not required any signature.</i></p>
                                    </div>
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
           total_gross_salary:'',
           total_basic_salary:'',
           total_housing_allowance:'',
           total_medical_allowance:'',
           total_conveyance_allowance:'',
           total_others_allowance:'',
           employee_image:'',
           total_pf_employee_amount:'',
           total_pf_company_amount:'',
           total_pf_amount:'',
         }
       },

        created(){
            this.getResults(1,this.$route.params.id);
        },
        components:{
            pageLoading:Loading
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
               $('.page-break').each(function() {
                  this.style.setProperty('page-break-after', 'always', 'important');
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