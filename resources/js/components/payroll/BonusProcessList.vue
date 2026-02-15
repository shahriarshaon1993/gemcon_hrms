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
                          Bonus Process List
                        </h3>
                        <!-- <span class="float-sm-right" style="float: right;">
                                 <div v-if="lists.add=='add'"  @click="getModalData($event,{dataUrl:'create/payroll_list'},resetModal)" class="btn-group"> <span class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add Process</span></div>
                               </span> -->
                      </div>
                    </div>
                  </div>
                  <div class="card-body col-md-12">
                    <div
                      class="col-md-6 col-sm-6 col-6 float-left"
                      style="padding: 0px"
                    >
                      <div id="DataTables_Table_0_length" class="">
                        Show
                        <label>
                          <select
                            class="form-control pagination-number"
                            @change="onChange($event)"
                            v-model="paginate_num"
                            name="pageSize"
                          >
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                            <option value="35">35</option>
                            <option value="40">40</option>
                            <option value="45">45</option>
                            <option value="50">50</option>
                          </select>
                        </label>
                        entries
                      </div>
                    </div>

                    <div
                      class="col-md-6 col-sm-6 col-6 float-left"
                      style="padding: 0px"
                    >
                      <div
                        class="dataTables_filter"
                        id="DataTables_Table_0_filter"
                      >
                        <label class="float-right">
                          <div class="input-group">
                            <span class="input-group-addon"
                              ><i class="icon-search"></i
                            ></span>
                            <input
                              v-on:keyup="getResults"
                              v-model="search_input.search_key"
                              type="text"
                              aria-controls="DataTables_Table_0"
                              class="form-control search-keyword"
                              id="search"
                              placeholder="Search..."
                            />
                          </div>
                        </label>
                      </div>
                    </div>

                    <table
                      id="employeeTable"
                      class="table table-bordered table-striped employeeTable"
                    >
                      <thead>
                        <tr>
                          <th class="text-center">SL</th>
                          <th class="text-center">P. Date</th>
                          <th class="text-center">Month</th>
                          <th class="text-center">Festival</th>
                          <th class="text-center">Type</th>
                          <th class="text-center">Company/SBU</th>
                          <th class="text-center">Employees</th>
                          <th class="text-center">Bonus</th>
                          <th class="text-center">Remarks</th>
                          <th class="text-center">Status</th>
                          <th class="text-center" style="width: 25%">Action</th>
                        </tr>
                      </thead>
                      <tbody v-if="Object.keys(paginate_data.data).length > 0">
                        <tr
                          v-for="(form_data, index) in paginate_data.data"
                          v-bind:key="form_data.id"
                          i="index"
                        >
                          <td class="text-center">{{ index + 1 }}</td>
                          <td class="text-center">
                            {{ formatDate(form_data.process_date) }}
                          </td>
                          <td class="text-center">
                            {{ form_data.bonus_month }}
                          </td>
                          <td class="text-center">
                            <span v-if="form_data.bonus_for == 1">
                              {{ "Eid-Ul-Fitr" }}
                            </span>
                            <span v-if="form_data.bonus_for == 2">
                              {{ "Eid-Ul-Adha" }}
                            </span>
                          </td>
                          <td class="text-center">
                            <span v-if="form_data.type == 1">
                              {{ "Cash" }}
                            </span>
                            <span v-if="form_data.type == 2">
                              {{ "Bank" }}
                            </span>
                          </td>
                          <td>{{ form_data.sbu_name }}</td>
                          <td class="text-center">
                            {{ form_data.total_employee }}
                          </td>
                          <td class="text-center">
                            {{ form_data.total_bonus_amount }}
                          </td>
                          <td class="text-center">
                            <span
                              v-if="form_data.settlement == 1"
                              style="color: orange"
                            >
                              {{ form_data.remarks }}
                            </span>
                            <span
                              v-if="form_data.settlement == 2"
                              style="color: green"
                            >
                              {{ form_data.remarks }}
                            </span>
                          </td>
                          <td class="text-center">
                            <span
                              v-if="form_data.status == 1"
                              style="color: green"
                              >Active</span
                            >
                            <span v-else style="color: red">Inactive</span>
                          </td>
                          <td class="text-center" style="width: 15%">
                            <router-link
                              href="#"
                              :to="
                                '/bonus_process_list_details/' + form_data.id
                              "
                              class="btn btn-xs btn-success"
                              title="Details"
                            >
                              <i class="fa fa-search" aria-hidden="true"></i>
                              Details
                            </router-link>
                            <!-- v-if="form_data.settlement==1" -->
                            <button
                              v-if="form_data.settlement == 1"
                              class="btn btn-xs btn-info"
                              @click="
                                getModalData($event, {
                                  dataUrl:
                                    'final_process/bonus_process_list/' +
                                    form_data.id,
                                })
                              "
                              title="Fianl Process"
                            >
                              <i class="fa fa-cog"> </i> Process
                            </button>
                            <button
                              v-if="form_data.settlement == 2"
                              class="btn btn-xs btn-info"
                              title="Final Process Completed!"
                              @click="
                                AccessDenied(
                                  $event,
                                  (value = ' Final Process Completed!')
                                )
                              "
                              style="opacity: 0.5"
                            >
                              <i class="fa fa-cog"> </i> Process
                            </button>
                            <button
                              v-if="form_data.settlement == 1"
                              class="btn btn-xs btn-danger"
                              @click="
                                deleteItem({
                                  delUrl:
                                    'delete/bonus_process_list/' + form_data.id,
                                })
                              "
                              title="Delete"
                            >
                              <i class="fa fa-trash"></i> Delete
                            </button>
                            <button
                              v-if="form_data.settlement == 2"
                              class="btn btn-xs btn-danger"
                              title=""
                              @click="
                                AccessDenied(
                                  $event,
                                  (value = ' Final Process Completed!')
                                )
                              "
                              style="opacity: 0.5"
                            >
                              <i class="fa fa-trash"></i> Delete
                            </button>
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td colspan="12" align="center">
                            No data in database
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row">
                      <div
                        class="dataTables_footer clearfix"
                        style="width: 100%"
                      >
                        <div class="col-md-6" style="float: left">
                          <div
                            class="dataTables_info"
                            id="DataTables_Table_0_info"
                          >
                            Showing {{ paginate_data.current_page }} of
                            {{ paginate_data.last_page }} pages
                          </div>
                        </div>
                        <div class="col-md-6" style="float: right">
                          <div class="dataTables_paginate paging_bootstrap">
                            <pagination
                              :data="paginate_data"
                              :limit="2"
                              @pagination-change-page="getResults"
                            ></pagination>
                          </div>
                        </div>
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

        <modal
          class=""
          name="myModal"
          height="auto"
          :clickToClose="false"
          width="400"
        >
          <div v-if="modal_loading">
            <div class="widget-header modal-header">
              <h4>
                <i class="fa fa-info"></i> Are you sure want to process bonus?
              </h4>
              <button
                type="button"
                @click="hideModal"
                class="close close-modify"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modify-wraper modal-body">
              <div class="container">
                <form
                  @submit.prevent="
                    add(
                      { add: 'final_process_submit/bonus_process_list' },
                      resetModal
                    )
                  "
                  class="form-horizontal row-border"
                  id="validate-1"
                >
                  <div class="form-group">
                    <div class="col-md-12 inputGroupContainer">
                      <div class="input-group" style="padding: 30px">
                        <input type="hidden" v-model="form_data.id" />
                        <button
                          type="button"
                          @click="hideModal"
                          class="
                            btn btn-sm btn-default
                            float-right
                            col-md-2
                            offset-md-4
                          "
                          style="margin-right: 20px"
                        >
                          No
                        </button>
                        <input
                          type="submit"
                          tabindex="4"
                          value="Yes"
                          class="btn btn-sm btn-success float-right col-md-2"
                        />
                      </div>
                    </div>
                  </div>
                </form>
              </div>
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
import Loading from "../Loading.vue";
import dayjs from "dayjs";

export default {
  data() {
    return {
      employee_name_value: "",
      gross_salary_entry: "",
      basic_salary_entry: "",
      housing_allowance_entry: "",
      medical_allowance_entry: "",
      conveyance_allowance_entry: "",
      overtime_work_compensation_entry: "",
      profile_open: "",
      increment_type_field: "",
      car_allowance_field: "",
      increment_percentage_entry: "",
      gross_salary_entryyy: "",
      provident_fund_amount_entry: "",
    };
  },
  created() {
    this.getResults(1);
  },
  components: {
    pageLoading: Loading,
  },

  methods: {
    formatDate(dateString) {
      const date = dayjs(dateString);
      // Then specify how you want your dates to be formatted
      return date.format("D MMMM YYYY");
      // return date.format('dddd MMMM D, YYYY');
    },
    onSelectEmployee(option) {
      console.log(option);
      this.form_data.employee_id = option.id;
      console.log(this.form_data.employee_id);
    },
    onSelectEmployeeSearch(option) {
      this.profile_open = 1;
      this.getModalDataOther(option.id);
      this.form_data.employee_id = option.id;
      this.form_data.employee_id = this.form_data.employee_id;
      console.log(this.form_data.employee_id);
      console.log(option);
      let allData = this.form_data.user_employee_data_all[option.id];
      this.form_data.employee_id = allData["id"];
    },
    getModalDataOther(id) {
      // console.log('aaaaaa');
      let uri = URL.baseUrl("other_create/payroll_list/" + id);
      console.log(uri);
      axios
        .get(uri)
        .then((res) => {
          console.log(res.data);
          this.form_data = res.data;
          this.form_data.employee_id = id;
          this.form_data.car_allowance_status = 2;
          this.form_data.increment_type = 2;
          this.increment_type_field = 2;
          this.errors = null;
          if (callback) {
            callback();
          }
        })
        .catch((error) => {
          this.modal_page_loading = true;
        });
    },

    setModalData() {
      this.employee_name_value = this.form_data.employee_name_value;
      this.gross_salary_entry = this.form_data.gross_salary.toFixed(2);
      this.basic_salary_entry = this.form_data.basic_salary.toFixed(2);
      this.housing_allowance_entry =
        this.form_data.housing_allowance.toFixed(2);
      this.medical_allowance_entry =
        this.form_data.medical_allowance.toFixed(2);
      this.conveyance_allowance_entry =
        this.form_data.conveyance_allowance.toFixed(2);
      this.overtime_work_compensation_entry =
        this.form_data.overtime_work_compensation.toFixed(2);
      this.profile_open = 1;
      this.increment_type_field = this.form_data.increment_type;
      this.increment_percentage_entry = this.form_data.increment_percentage;
      // this.form_data.id = form_data.id
    },
    resetModal() {
      this.gross_salary_entry = "";
      this.basic_salary_entry = "";
      this.housing_allowance_entry = "";
      this.medical_allowance_entry = "";
      this.conveyance_allowance_entry = "";
      this.overtime_work_compensation_entry = "";
      this.profile_open = "";
      this.employee_name_value = "";
      this.car_allowance_field = "";
      this.increment_type_field = 2;
      this.form_data.car_allowance_status = 2;
      this.form_data.increment_type = 2;
    },
    car_allowance(e) {
      var val = e.target.value;
      if (val == 1) {
        this.car_allowance_field = 1;
      } else {
        this.car_allowance_field = 2;
      }
    },
    increment_type(e) {
      var val = e.target.value;
      if (val == 1) {
        this.increment_type_field = 1;
        this.increment_percentage_entry = "";
        this.gross_salary_entry = "";
        this.basic_salary_entry = "";
        this.housing_allowance_entry = "";
        this.medical_allowance_entry = "";
        this.conveyance_allowance_entry = "";
      } else {
        this.increment_type_field = 2;
        this.increment_percentage_entry = "";
        this.basic_salary_entry = "";
        this.gross_salary_entry = "";
        this.housing_allowance_entry = "";
        this.medical_allowance_entry = "";
        this.conveyance_allowance_entry = "";
      }
    },
  },
};
</script>