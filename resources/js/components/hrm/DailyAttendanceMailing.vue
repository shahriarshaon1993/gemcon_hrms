<template>
    <div>
        <div v-if="page_loading" class="widget box">
            <div class="widget-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="d-flex align-items-center justify-content-between" style="padding: .5rem 1.2rem 0 1.2rem !important;">
                                    <h3 class="card-title">
                                        Daily Attendance Mailing
                                    </h3>

                                    <a class="btn btn-sm btn-default" @click="$router.go(-1)">
                                        <i class="fa fa-arrow-left"></i>
                                        Back
                                    </a>
                                </div>

                                <div class="card-body">
                                    <div v-if="errors" class="alert alert-danger">
                                        <div v-for="error in errors">
                                            <span v-if="isObject(error)" v-for="err in error">{{err }}</span>
                                            <span v-if="!isObject(error)">{{ error }}</span>
                                        </div>
                                    </div>

                                    <form @submit.prevent="add({ add: 'attendance-send-mail' })" id="validate-1">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="sbu">SBU</label>
                                                <vue-select
                                                    v-model="form_data.sbu_name_value"
                                                    :options="option_data.company_sbu_data"
                                                    @select="onSectionSelected"
                                                    placeholder="Select one"
                                                    label="text"
                                                    track-by="id"
                                                ></vue-select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="sbu">Unit</label>
                                                <vue-select
                                                    v-model="form_data.unit_value"
                                                    :options="option_data.unit_data"
                                                    @select="employeesUnit"
                                                    placeholder="Select one"
                                                    label="text"
                                                    track-by="text"
                                                ></vue-select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="sbu">Subunit</label>
                                                <vue-select
                                                    v-model="form_data.sub_unit_value"
                                                    :options="option_data.sub_unit_data"
                                                    @select="employeesSubUnit"
                                                    placeholder="Select one"
                                                    label="text"
                                                    track-by="text"
                                                ></vue-select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="sbu">Department</label>
                                                <vue-select
                                                    v-model="form_data.department_name_value"
                                                    :options="option_data.department_data"
                                                    @select="onSelectDepartment"
                                                    placeholder="Select one"
                                                    label="text"
                                                    track-by="text"
                                                ></vue-select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="sbu">Section</label>
                                                <vue-select
                                                    v-model="form_data.section_value"
                                                    :options="option_data.section_data"
                                                    @select="employeesSection"
                                                    placeholder="Select one"
                                                    label="text"
                                                    track-by="text"
                                                ></vue-select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="sbu">Sub Section</label>
                                                <vue-select
                                                    v-model="form_data.sub_section_value"
                                                    :options="option_data.sub_section_data"
                                                    @select="employeesSubSection"
                                                    placeholder="Select one"
                                                    label="text"
                                                    track-by="text"
                                                ></vue-select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="sbu">Work Loc.</label>
                                                <vue-select
                                                    v-model="form_data.work_location_value"
                                                    :options="option_data.work_location_data"
                                                    @select="employeesWorkLocation"
                                                    placeholder="Select one"
                                                    label="text"
                                                    track-by="text"
                                                ></vue-select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="sbu">Employee</label>
                                                <vue-select
                                                    v-model="form_data.employee_name_value"
                                                    :options="option_data.employee_data"
                                                    @select="onSelectEmployee"
                                                    placeholder="Select one"
                                                    label="text"
                                                    track-by="text"
                                                ></vue-select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="sbu">From Date</label>
                                                <datepicker
                                                    placeholder="Select Date"
                                                    v-model="form_data.from_date"
                                                    class="form-control"
                                                ></datepicker>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="sbu">To Date</label>
                                                <datepicker
                                                    placeholder="Select Date"
                                                    v-model="form_data.to_date"
                                                    class="form-control"
                                                ></datepicker>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-sm btn-success">Send Mail</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <!-- Table for mailing start -->
                                    <div class="row">
                                        <!-- <div id="" class="section-to-print col-md-12"> -->
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="row" style="margin-left: 21px;">
                                                    <table class="sssssss" style="width: 100%;">
                                                        <tbody>
                                                        <tr>
                                                            <td style="width: 20%;">
                                                                <div class="col-md-12"
                                                                     style="padding: 0px; margin-top: 17px;">
                                                                    <img src="/company_logo/jUhwnsldPMgsMJq2.png"
                                                                         style="width: 25%;"/>
                                                                </div>
                                                            </td>
                                                            <td style="width: 60%;">
                                                                <div class="col-md-12"
                                                                     style="margin: 0px; text-align: center !important;">
                                                                    <h3 class="text-center"
                                                                        sstyle="margin:0px;text-align: center!important;">
                                                                        Gemcon Group</h3>
                                                                    <h5 class="text-center"
                                                                        style="margin: 0px; text-align: center !important;">
                                                                        Gemcon Security</h5>
                                                                    <h6 class="text-center"
                                                                        style="margin: 0px; text-align: center !important;">
                                                                        Suman Ranjan Podder (100376), Assistant Manager,
                                                                        Finance & Accounts
                                                                    </h6>
                                                                    <h6 class="text-center"
                                                                        style="margin: 0px; text-align: center !important;">
                                                                        Attendance Late Report</h6>
                                                                    <h6 class="text-center"
                                                                        style="margin: 0px; text-align: center !important;">
                                                                        01 Oct,2024 To 16 Oct,2024</h6>
                                                                </div>
                                                            </td>
                                                            <td style="width: 20%;">
                                                                <div class="col-md-12"
                                                                     style="padding: 0px; margin-top: 17px;">
                                                                    <p><strong> Print Date :</strong> 16 Oct,2024</p>
                                                                    <p style="margin-top: -7px;"><strong> Created By
                                                                        :</strong> Faruk Khan</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br/>
                                            </div>
                                            <table class="table table-condensed">
                                                <thead>
                                                <tr style="background: #eee;">
                                                    <th class="text-center">SL.</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Name</th>
                                                    <th class="text-center">Designation</th>
                                                    <th class="text-center">Department</th>
                                                    <th class="text-center">Section</th>
                                                    <th class="text-center">W. Location</th>
                                                    <th class="text-center">DOJ</th>
                                                    <th class="text-center">Shift</th>
                                                    <th class="text-center">Shift Hour</th>
                                                    <th class="text-center">In Time</th>
                                                    <th class="text-center">Out Time</th>
                                                    <th class="text-center">Late</th>
                                                    <th class="text-center">Working Hour</th>
                                                    <th class="text-center">Extra/Short Hour</th>
                                                    <th class="text-center">Remarks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">01 Oct, 2024</td>
                                                    <td class="text-center">600678</td>
                                                    <td>Md. Al Mamun</td>
                                                    <td>Special Guard</td>
                                                    <td>Safety &amp; Security</td>
                                                    <td></td>
                                                    <td>Corporate Office</td>
                                                    <td>02 Sep, 2019</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">09:00 - 18:00</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">00:00:00</td>
                                                    <td class="text-center">00:00</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">AL</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center">02 Oct, 2024</td>
                                                    <td class="text-center">600678</td>
                                                    <td>Md. Al Mamun</td>
                                                    <td>Special Guard</td>
                                                    <td>Safety &amp; Security</td>
                                                    <td></td>
                                                    <td>Corporate Office</td>
                                                    <td>02 Sep, 2019</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">09:00 - 18:00</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">00:00:00</td>
                                                    <td class="text-center">00:00</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">Absent</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">03 Oct, 2024</td>
                                                    <td class="text-center">600678</td>
                                                    <td>Md. Al Mamun</td>
                                                    <td>Special Guard</td>
                                                    <td>Safety &amp; Security</td>
                                                    <td></td>
                                                    <td>Corporate Office</td>
                                                    <td>02 Sep, 2019</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">09:00 - 18:00</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">00:00:00</td>
                                                    <td class="text-center">00:00</td>
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">Absent</td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <!-- </div> -->
                                    </div>
                                    <!-- Table for mailing end -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>

<!--                <button type="button" class="btn btn-success" @click="sendMail">Send mail</button>-->
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
        async sendMail() {
            // console.log(URL.baseUrl('attendance-send-mail'));
            await axios.get(URL.baseUrl('attendance-send-mail'))
                .then((res) => {
                    console.log(res.data);
                })
                .catch((err) => console.error(err.message));
        },
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
            // if(this.weekly_id==1){

            let uri = URL.baseUrl("shift_week/fiends");
            axios
                .post(uri, {
                    // types:this.weekly_id,
                    id: event.target.value,
                })
                .then((res) => {
                    this.weekly_data = res.data;
                    this.modal_loading = true;
                })
                .catch((error) => {
                    this.modal_loading = true;
                });
            // }
            this.modal_loading = true;
        },

        onSectionSelected(option) {
            this.sbu_name_value = option.id;
        },

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
            this.form_data.employee_job_grade = option.id;
            this.permission_id = option.id;
            this.permission_id_name = option.text;
        },
        onSelectEmployee(option) {
            this.form_data.employee_id = option.id;
            this.employees_ids = option.id;
            this.permission_id = option.id;
            this.permission_id_name = option.text;
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
