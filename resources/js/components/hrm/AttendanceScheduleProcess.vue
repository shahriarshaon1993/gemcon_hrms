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
                                                    Attendance Schedule Process
                                                </h3>
                                                <span class="float-sm-right" style="float: right">
                          <a class="btn btn-default" @click="$router.go(-1)"
                          ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <form @submit.prevent="add({ add: 'add/attendanceScheduleProcess' })"
                                          id="validate-1">

                                        <div class="card-body col-md-12">
                                            <div class="report-box">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <div v-if="errors" class="alert alert-danger" style="">
                                                            <div v-for="(error, index) in errors">
                                                                <span v-if="isObject(error)" v-for="err in error">{{
                                                                        err
                                                                    }}</span>
                                                                <span v-if="!isObject(error)">{{
                                                                        error
                                                                    }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4" style="max-width: 12%">
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
                                                    <div class="form-group col-md-2" style="max-width: 12%">
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
                                                    <div class="form-group col-md-2" style="max-width: 12%">
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
                                                    <div class="form-group col-md-2" style="max-width: 12%">
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
                                                    <div class="form-group col-md-2" style="max-width: 12%">
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
                                                    <div class="form-group col-md-2" style="max-width: 12%">
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
                                                    <div class="form-group col-md-2" style="max-width: 12%">
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
                                                </div>
                                                <div class="row">
                                                    <div
                                                        class="form-group col-md-2"
                                                        id="employee_wise_show"
                                                        style="max-width: 12%"
                                                    >
                                                        <label class="col-md-12 control-label">Employee</label>
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

                                                    <div class="form-group col-md-4" style="max-width: 12%">
                                                        <label class="col-md-12 control-label"
                                                        >From Date <sup style="color: red; top: -2px">*</sup> </label
                                                        >
                                                        <div
                                                            class="col-md-12 inputGroupContainer"
                                                            style="padding: 0px"
                                                        >
                                                            <div class="input-group">
                            <span class="input-group-addon"
                            ><i class="glyphicon glyphicon-home"></i
                            ></span>
                                                                <!-- <input  v-model="form_data.from_date"  placeholder="" class="form-control" type="date"> -->
                                                                <datepicker placeholder="Select Date"
                                                                            v-model="form_data.from_date"
                                                                            class="form-control"></datepicker>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-4" style="max-width: 12%">
                                                        <label class="col-md-12 control-label"
                                                        >To Date <sup style="color: red; top: -2px">*</sup> </label
                                                        >
                                                        <div
                                                            class="col-md-12 inputGroupContainer"
                                                            style="padding: 0px"
                                                        >
                                                            <div class="input-group">
                            <span class="input-group-addon"
                            ><i class="glyphicon glyphicon-home"></i
                            ></span>
                                                                <!-- <input  v-model="form_data.to_date"  placeholder="" class="form-control" type="date"> -->
                                                                <datepicker placeholder="Select Date"
                                                                            v-model="form_data.to_date"
                                                                            class="form-control"></datepicker>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12" style="max-width: 100%">
                                                        <div
                                                            class="col-md-12 inputGroupContainer"
                                                            style="max-width: 4%; padding: 15px 0px; float: right; margin-right: 20px;"
                                                        >
                                                            <div class="input-group">
                            <span class="input-group-addon"
                            ><i class="glyphicon glyphicon-home"></i
                            ></span>
                                                                <input
                                                                    type="submit"
                                                                    style="width: 130px; margin-bottom: 9px;color: rgb(33, 37, 41) !important; background-color: rgb(250, 194, 60); border-color: rgb(250, 194, 60); width: 60px; height: 30px;"
                                                                    tabindex="4"
                                                                    value="Submit"
                                                                    class="btn btn-sm btn-info"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
            section_value: "",
            sub_section_value: "",
            employee_group_value: "",
            unit_value: "",
            make_user: 0,
            employeesName: "",
            employees_ids: "",
            employee_data_approvaldat: "",
            datesList: "",
            url: null,
            sub_unit_value: "",
            work_location_value: "",
            department_name_value: "",
            designation_name_value: "",
            jobgrade_name_value: "",
            employee_name_value: "",
            sub_unit_value: "",
            work_location_value: "",
            personal_email_id: "",
            noticeToType: 0,
            noticeToTypeName: "",
            shift_value: '',
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
        roster_maping() {
            if (confirm("Do you really want to mapping next 7 days?")) {
                this.modal_loading = false;
                this.page_loading = false;
                let uri = URL.baseUrl("shift_time/roaster_maping");
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

                        sbu_name_value: this.sbu_name_value,
                        unit_value: this.unit_value,
                        sub_unit_value: this.sub_unit_value,
                        department_name_value: this.department_name_value,
                        section_value: this.section_value,
                        sub_section_value: this.sub_section_value,
                        work_location_value: this.work_location_value,
                        employee_name_value: this.employee_name_value,
                    })
                    .then((res) => {
                        this.modal_loading = true;
                        this.page_loading = true;
                        console.log(res);
                        if (res.data.status == 1) {
                            this.showToster({status: 1, message: res.data.message});
                        } else {
                            this.showToster({status: 0, message: res.data.message});
                        }
                    })
                    .catch((error) => {
                        this.showToster({
                            status: 0,
                            message: "opps! something went wrong",
                        });

                        console.log(error);
                        this.modal_loading = true;
                        this.page_loading = true;
                    });
            }
        },
        shiftChange(option) {
            this.form_data.shift_id = option.id;

        },
        updateCountry(form_data, shift) {
            form_data.shift = shift;
        },
        addRow(event, approval_infos) {
            var aaa = this.form_data.approval_infos.length;
            this.form_data.approval_infos.push({
                permission_id: this.permission_id,
                permission_type: this.noticeToType,
                permission_type_name: this.noticeToTypeName,
                permission_id_name: this.permission_id_name,
            });
            console.log(this.form_data.approval_infos);
        },
        deleteRow(index) {
            this.form_data.approval_infos.splice(index, 1);
        },
        monthlySelect(event) {
            if (event.target.value == 1) {
                this.weekly_id = 0;
            } else {
                this.weekly_id = 1;
            }
        },
        weekSelect(event) {
            this.weeks_id = event.target.value;
        },
        monthsSelectsId(event) {
            // this.modal_loading= false;
            this.months_id = event.target.value;
            console.log(this.weekly_id);
            // if(this.weekly_id==1){

            let uri = URL.baseUrl("shift_week/fiends");
            axios
                .post(uri, {
                    // types:this.weekly_id,
                    id: event.target.value,
                })
                .then((res) => {
                    console.log(res);
                    this.weekly_data = res.data;
                    this.modal_loading = true;
                })
                .catch((error) => {
                    this.modal_loading = true;
                });
            // }
            this.modal_loading = true;
        },
        // employeesSbu(option) {
        //   // console.log("sss");
        //   this.sbu_id = option.id;
        // },
        // employeesSection(option) {
        //   this.section_id = option.id;
        // },
        // employeesSubSection(option) {
        //   this.subsection_id = option.id;
        // },
        // employeesGroup(option) {
        //   this.employee_group = option.id;
        // },
        // employeesSubUnit(option) {
        //   this.subunit_id = option.id;
        // },
        // employeesUnit(option) {
        //   this.unit_id = option.id;
        // },
        // employeesWorkLocation(option) {
        //   this.employee_work_location = option.id;
        // },
        // onSelectDepartment(option) {
        //   this.department_id = option.id;
        // },
        onSelectDesignation(option) {
            this.employee_designation = option.id;
        },
        onSearchAllData() {
            this.modal_loading = false;
            this.page_loading = false;
            // alert('ss');
            console.log(this.form_data.employee_id);
            let uri = URL.baseUrl("shift_time/fiends");
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
                })
                .then((res) => {
                    console.log(res);
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
        resetModal() {
            // this.sbu_name_value='';
            // this.section_value='';
            // this.sub_section_value='';
            // this.employee_group_value='';
            // this.department_name_value='';
            // this.designation_name_value='';
            // this.jobgrade_name_value='';
            // this.unit_value='';
            // this.sub_unit_value='';
            // this.employee_name_value='';
            // this.work_location_value='';
            // this.form_data.employee_status = "1";
            // this.form_data.emplyee_category_mgt_non_mgt = "2";
            // this.form_data.employee_leave_group = "1";
            // this.form_data.employee_type = "2";
            // this.form_data.make_user = "";
            // this.form_data.user_type = "0";
            // this.form_data.ea_approve_by_name = "";
            // this.form_data.employee_mobile = "";
            // this.form_data.employee_id = "";
            // this.form_data.employee_number = "";
            // this.form_data.employee_fullname = "";
            // this.form_data.employee_joining_date = "";
            // this.form_data.employee_image = "";
            // this.form_data.make_user = "";
            // this.approvalnamevalue1="";
        },

        // notice_to(event){
        //  console.log(event.target.name);
        //  if (event.target.value==1) {
        //    this.noticeToType=1;
        //    this.noticeToTypeName='Company/SBU';
        //  }else if(event.target.value==2){
        //    this.noticeToType=2;
        //    this.noticeToTypeName='Department';
        //  }else if(event.target.value==3){
        //    this.noticeToType=3;
        //    this.noticeToTypeName='Unit';
        //  }else if(event.target.value==4){
        //    this.noticeToType=4;
        //    this.noticeToTypeName='Sub Unit';
        //  }else if(event.target.value==5){
        //    this.noticeToType=5;
        //    this.noticeToTypeName='Section';
        //  }else if(event.target.value==6){
        //    this.noticeToType=6;
        //    this.noticeToTypeName='Sub Section';
        //  }else if(event.target.value==7){
        //    this.noticeToType=7;
        //    this.noticeToTypeName='Employee';
        //  }
        // }
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

/* h1 {
     font-size: 20pt;
     margin: 0 0 20px;
     padding: 0;
     line-height: 100%;
 } */

.div_maintb {
    height: calc(55vh);
    width: calc(83vw);
    overflow: scroll;
    border: 1px solid #6f6f6f;
}

.div_maintb table {
    border-spacing: 0;
}

.div_maintb th {
    position: sticky;
    top: 0;
    background: #464646;
    color: #d1d1d1;
    width: 100px;
    min-width: 100px;
    padding: 6px;
    outline: 1px solid #7a7a7a;
    font-weight: normal;
}

.div_maintb td {
    padding: 6px;
    outline: 1px solid #c3c3c3;
}

.div_maintb th:nth-child(1),
.div_maintb td:nth-child(1) {
    position: sticky;
    left: 0;
    width: 200px;
    min-width: 200px;
}

/* .div_maintb th:nth-child(2),
.div_maintb td:nth-child(2) {
    position: sticky;
    left: 142px;
    width: 50px;
    min-width: 50px;
} */

.div_maintb td:nth-child(1) {
    background: #464646;
    color: #fff;
    z-index: 200;
}

.div_maintb th:nth-child(1),
.div_maintb th:nth-child(2) {
    z-index: 300;
}

td > .multiselect > .multiselect__tags {
    padding: 0px 0px 0 0px !important;
    border-radius: 0px !important;
    border-bottom-right-radius: 0px !important;
    border: none;
    min-height: 100% !important;
}

</style>
