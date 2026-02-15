<template>
    <div class="col-md-12" style="border: 1px solid #cfcfcf;margin-left: 12px;    padding-right: 0px;   max-width: 98%;">
  <div class="col-md-10 modify-wraper float-left" style="padding:0px;">
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
    <!-- <hr> -->
  </div>
   <div class="col-md-2 float-left" style="padding: 0px;text-align: right !important;">
     <span v-if="form_data.user_employee_data.employee_image">
       <img  :src="`images/${form_data.user_employee_data.employee_image}`" class="card-img-top border rounded" style="margin-top: 1px;width: 119px;height: 132px;margin-left: -9px;margin-right: 1px;">
     </span>
     <span v-else>
       <img v-if="url !== '' || form_data.user_employee_data.employee_image !==''" :src="`images/default.png`" class="card-img-top border rounded" style="    margin-top: 1px;width: 119px;height: 132px;margin-left: -9px;margin-right: 1px;">
     </span>
   </div>
</div>
</template>

<script>
import Vue from "vue";

export default {
    data: function() {
        return {
            cellSpacing: [5, 5],
            typsss:0,

        };
    },
     methods: {
     }
}
</script>

