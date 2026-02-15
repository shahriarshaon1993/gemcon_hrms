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
                      <div
                        class="col-12 col-sm-6 col-md-12"
                        style="padding: 5px 10px"
                      >
                        <h3 class="card-title d-none d-md-block">
                          OT Adjustment
                        </h3>
                      </div>
                    </div>
                  </div>
                  <div class="card-body col-md-12">
                    <div class="row report-box">
                      <div class="form-group col-md-2" style="max-width: 24%">
                        <label class="col-md-12 control-label"
                          >SBU <sup style="color: red; top: -2px">*</sup></label
                        >
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <vue-select
                              v-model="sbu_name_value"
                              :options="option_data.company_sbu_data"
                              @select="employeesSbu"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2" style="max-width: 24%">
                        <label class="col-md-12 control-label">Unit</label>
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <vue-select
                              v-model="unit_value"
                              :options="option_data.unit_data"
                              @select="employeesUnit"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2" style="max-width: 24%">
                        <label class="col-md-12 control-label">Sub Unit</label>
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <vue-select
                              v-model="sub_unit_value"
                              :options="option_data.sub_unit_data"
                              @select="employeesSubUnit"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2" style="max-width: 24%">
                        <label class="col-md-12 control-label"
                          >Department</label
                        >
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <vue-select
                              v-model="department_name_value"
                              :options="option_data.department_data"
                              @select="onSelectDepartment"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2" style="max-width: 24%">
                        <label class="col-md-12 control-label">Section</label>
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <vue-select
                              v-model="section_value"
                              :options="option_data.section_data"
                              @select="employeesSection"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2" style="max-width: 24%">
                        <label class="col-md-12 control-label"
                          >Sub Section</label
                        >
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-home"></i
                            ></span>
                            <vue-select
                              v-model="sub_section_value"
                              :options="option_data.sub_section_data"
                              @select="employeesSubSection"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-2" style="max-width: 24%">
                        <label class="col-md-12 control-label">Work Loc.</label>
                        <div
                          class="col-md-12 inputGroupContainer"
                          style="padding: 0px"
                        >
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-envelope"></i
                            ></span>
                            <vue-select
                              v-model="work_location_value"
                              :options="option_data.work_location_data"
                              @select="employeesWorkLocation"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div
                        class="form-group col-md-2"
                        id="employee_wise_show"
                        style="max-width: 24%"
                      >
                        <label class="col-md-6 control-label">Employee</label>
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-earphone"></i
                            ></span>
                            <vue-select
                              v-model="employee_name_value"
                              :options="option_data.employee_data"
                              @select="onSelectEmployee"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div
                        class="form-group col-md-2"
                        id="employee_wise_show"
                        style="max-width: 24%"
                      >
                        <label class="col-md-6 control-label">Shift</label>
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-earphone"></i
                            ></span>
                            <vue-select
                              v-model="officeTimedata"
                              :options="option_data.officeTime"
                              placeholder="Select one"
                              label="text"
                              track-by="text"
                            ></vue-select>
                          </div>
                        </div>
                      </div>
                      <div
                        class="form-group col-md-2"
                        id="employee_wise_show"
                        style="max-width: 24%"
                      >
                        <label class="col-md-6 control-label"
                          >Start date
                          <sup style="color: red; top: -2px">*</sup></label
                        >
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-earphone"></i
                            ></span>

                            <datepicker
                              placeholder="Select Date"
                              style="width: 131% !important"
                              v-model="start_date"
                              class="form-control"
                              required
                            ></datepicker>
                          </div>
                        </div>
                      </div>
                      <div
                        class="form-group col-md-2"
                        id="employee_wise_show"
                        style="max-width: 24%"
                      >
                        <label class="col-md-6 control-label"
                          >End date
                          <sup style="color: red; top: -2px">*</sup></label
                        >
                        <div class="col-md-12 inputGroupContainer">
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="glyphicon glyphicon-earphone"></i
                            ></span>
                            <datepicker
                              placeholder="Select Date"
                              style="width: 131% !important"
                              v-model="end_date"
                              class="form-control"
                              required
                            ></datepicker>
                          </div>
                        </div>
                      </div>
                      <div
                        class="col-md-1 float-right"
                        style="max-width: 4%; padding: 15px 0px"
                      >
                        <span>
                          <a
                            @click="onSearchAllData($event)"
                            class="btn btn-xs"
                            style="
                              color: #212529 !important;
                              background-color: #fac23c;
                              border-color: #fac23c;
                              width: 50px;
                              height: 30px;
                            "
                            ><i
                              class="fa fa-search"
                              style="
                                color: #212529 !important;
                                background-color: #fac23c;
                                border-color: #fac23c;
                                margin-top: 5px;
                              "
                            ></i
                          ></a>
                        </span>
                      </div>
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

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <!-- {{ "Total Employee :" }} -->
                    <!-- {{ form_data.employee_data_approvaldat.length }} -->
                  </div>

                  <div class="card-body col-md-12" v-if="page_loading">
                    <div class="row col-md-12">
                      <form
                        @submit.prevent="OT_add({ add: 'add/ot_setup' })"
                        id="validate-1"
                      >
                        <input
                          type="submit"
                          style="width: 130px; margin-bottom: 9px"
                          tabindex="4"
                          value="Save"
                          class="btn btn-sm btn-info col-md-2"
                        />

                        <table
                          id="employeeTable_ids"
                          class="
                            table table-bordered table-striped
                            employeeTable
                          "
                        >
                          <thead>
                            <tr style="text-align: center;">
                              <th> Sl.No </th>
                               <th>Employee ID</th>
                              <th>Employee Name</th>
                              <th>Employee designation</th>
                              <!-- <th>Shift Name </th> -->
                              <th>OT Date</th>
                              <th>OT Time(Hour)</th>
                              <th>Assignment OT (Hour) </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(
                                form_data_s, index
                              ) in form_data.employee_data_approvaldat"
                              v-bind:key="index"
                            >
                            <td style="text-align: center;"> {{ index + 1 }}</td>
                              <!-- headcol -->
                              <td style="text-align: center;">
                                {{ form_data_s.employee_id_no }} 
                              </td>
                              <td> {{ form_data_s.employee_fullname }} </td>

                              <td>{{ form_data_s.designation_name }}</td>
                              <!-- <td>{{ form_data_s.designation_name }}</td> -->
                              <td style="text-align: center;">{{ form_data_s.pdate }}</td>
                              <td style="text-align: center;">{{ form_data_s.ot_time }}</td>
                              <td style="text-align: center;">
                                <input type="number" class="form-control" style="text-align: center;"  placeholder="0.0" v-model="form_data_s.ot_entry" >
                                <!-- select hours -->
                                <!-- <div class="form-group">
                                  <div class="col-md-12 inputGroupContainer">
                                    <div class="input-group">
                                      <span class="input-group-addon"
                                        ><i class="glyphicon glyphicon-time"></i
                                      ></span>
                                      <select
                                        class="form-control"
                                        v-model="form_data_s.ot_entry"
                                        name="ot_time"
                                        id="ot_time"
                                        style="width: 100%"
                                      >
                                        <option>Select</option>
                                        <option value="1">1 hour</option>
                                        <option value="1.5">1.5 hours</option>
                                        <option value="2">2 hours</option>
                                        <option value="2.5">2.5 hours</option>
                                        <option value="3">3 hours</option>
                                        <option value="3.5">3.5 hours</option>
                                        <option value="4">4 hours</option>
                                        <option value="4.5">4.5 hours</option>
                                        <option value="5">5 hours</option>
                                        <option value="5.5">5.5 hours</option>
                                        <option value="6">6 hours</option>
                                        <option value="6.5">6.5 hours</option>
                                        <option value="7">7 hours</option>
                                        <option value="7.5">7.5 hours</option>
                                        <option value="8">8 hours</option>
                                        <option value="8.5">8.5 hours</option>
                                        <option value="9">9 hours</option>
                                        <option value="9.5">9.5 hours</option>
                                        <option value="10">10 hours</option>
                                        <option value="10.5">10.5 hours</option>
                                        <option value="11">11 hours</option>
                                        <option value="11.5">11.5 hours</option>
                                      </select>
                                    </div>
                                  </div>
                                </div> -->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </form>
                    </div>
                  </div>
                  <div v-if="!page_loading">
                    <pageLoading></pageLoading>
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
import Loading from "../Loading.vue";
import $ from "jquery";
import VueTimepicker from "vue2-timepicker";
import "vue2-timepicker/dist/VueTimepicker.css";
export default {
  data() {
    return {
      sbu_name_value: "",
      start_date: "",
      end_date: "",
      section_value: "",
      sub_section_value: "",
      employee_group_value: "",
      unit_value: "",
      make_user: 0,
      employeesName: "",
      employees_ids: "",
      employee_data_approvaldat: "",
      url: null,
      sub_unit_value: "",
      work_location_value: "",
      department_name_value: "",
      designation_name_value: "",
      jobgrade_name_value: "",
      employee_name_value: "",
      officeTimedata: "",
      office_time_id: "",
      sub_unit_value: "",
      work_location_value: "",
      personal_email_id: "",
      noticeToType: 0,
      noticeToTypeName: "",
      monthly_id: "",
      week_id: "",
      roaster_type: "",
      permission_id: "",
      formDataAll: "",
      weekly_id: 0,
      weeks_id: 0,
      weekly_data: "",
      months_id: 0,
      permission_id_name: "",
      employees_list: [],
    };
  },
  created() {
    this.getResults(1);
    this.modal_loading = true;
  },
  components: {
    pageLoading: Loading,
    VueTimepicker,
  },
  computed: {
    options: () => countries,
  },
  methods: {
    OT_add(addUrl, callback) {
      this.page_loading = false;
      axios
        .post(URL.baseUrl(addUrl.add), this.form_data)
        .then((res) => {
          if (res.data.status == 1) {
          }

          this.page_loading = true;
          this.showToster({
            status: res.data.status,
            message: res.data.message,
          });
        })
        .catch((error) => {
          this.page_loading = true;
          // this.hideModal();
          var msg = "opps! something went wrong";
          this.showToster({ status: 0, message: msg });
        });
    },
    onSearchAllData() {
      if(this.end_date == "" || this.start_date == ""){
        this.showToster({ status: 0, message: "Please select start date and end date" });
        return false;
      }
      if(this.sbu_id == "" ){
        this.showToster({ status: 0, message: "Please select SBU" });
        return false;
      }
      this.modal_loading = false;
      this.page_loading = false;
      // alert('ss');
      console.log(this.form_data.employee_id);
      let uri = URL.baseUrl("ot_time/find");
      axios
        .post(uri, {
          sbu_id: this.sbu_id,
          section_id: this.section_id,
          subsection_id: this.subsection_id,
          employee_group: this.employee_group,
          subunit_id: this.subunit_id,
          unit_id: this.unit_id,
          employee_work_location: this.employee_work_location,
          employee_designation: this.employee_designation,
          department_id: this.department_id,
          roaster_id: this.weekly_id,
          week_id: this.weeks_id,
          months_id: this.months_id,
          employeeId: this.employees_ids,
          start_date: this.start_date,
          end_date: this.end_date,
          shift: this.officeTimedata,
        })
        .then((res) => {
          console.log(res);
          this.form_data.employee_data_approvaldat=res.data.employee_data_approvaldat;
          // this.form_data = res.data;
          this.modal_loading = true;
          this.page_loading = true;
          // this.resetModal();
        })
        .catch((error) => {
          this.modal_loading = true;
          this.page_loading = true;
        });
    },
    onSelectJobGrade(option) {
      console.log(option);
      this.form_data.employee_job_grade = option.id;
      this.permission_id = option.id;
      this.permission_id_name = option.text;
      console.log(this.form_data.employee_job_grade);
    },
    onSelectofficeTime(option) {
      console.log(option);
      this.office_time_id = option.id;
    },
    onSelectEmployee(option) {
      console.log(option);
      this.form_data.employee_id = option.id;
      this.employees_ids = option.id;
      this.permission_id = option.id;
      this.permission_id_name = option.text;
      console.log(this.form_data.employee_id);
    },
    setModalData() {
      this.sbu_name_value = this.form_data.sbu_name_value;
      this.section_value = this.form_data.section_value;
      this.sub_section_value = this.form_data.sub_section_value;
      this.employee_group_value = this.form_data.employee_group_value;
      this.department_name_value = this.form_data.department_name_value;
      this.designation_name_value = this.form_data.designation_name_value;
      this.jobgrade_name_value = this.form_data.jobgrade_name_value;
      this.sub_unit_value = this.form_data.sub_unit_value;
      this.employee_name_value = this.form_data.employee_name_value;
      this.work_location_value = this.form_data.work_location_value;
      this.general_data_temp = this.form_data.general_info_temp;
    },
  },
};
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
  content: "";
}
.select_id > .multiselect > .multiselect__tags {
  min-height: 41px !important;
}

.employeeOption > .multiselect__content-wrapper {
  right: -76px !important;
}
</style>