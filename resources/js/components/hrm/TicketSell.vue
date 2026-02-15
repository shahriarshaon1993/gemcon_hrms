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
                          Ticket Sell List
                        </h3>
                        <span class="float-sm-right" style="float: right">
                          <div
                            v-if="lists.use == 'use'"
                            @click="ticketuse($event)"
                            class="btn-group"
                          >
                            <span class="btn btn-sm btn-success">
                              <i class="icon-plus"></i>Use</span
                            >
                          </div>
                          <div
                            v-if="lists.add == 'add'"
                            @click="getModalData($event)"
                            class="btn-group"
                          >
                            <span class="btn btn-sm btn-info"
                              ><i class="icon-plus"></i>Add New</span
                            >
                          </div>
                          <a class="btn btn-default" href="#"
                            ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
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
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('total_ticket')"
                            @click="sortingChanged('total_ticket')"
                          >
                            Total ticket <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('used_ticket')"
                            @click="sortingChanged('used_ticket')"
                          >
                            Used ticket <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('date')"
                            @click="sortingChanged('date')"
                          >
                            Sell start date <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('ticket_status')"
                            @click="sortingChanged('ticket_status')"
                          >
                            Status <i class="fas fa-sort"></i>
                          </th>
                          <th class="text-center">Action</th>
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
                            {{ form_data.total_ticket }}
                          </td>
                          <td class="text-center">
                            {{ form_data.used_ticket }}
                          </td>
                          <td class="text-center">
                            {{ form_data.date }}
                          </td>
                          <td class="text-center">
                            <span v-if="form_data.ticket_status == 1">
                              {{ "Used" }}
                            </span>
                            <span v-else>
                              {{ "unused" }}
                            </span>
                          </td>
                          <td class="text-center">
                            <!-- <button
                              v-if="lists.edit == 'edit'"
                              @click="
                                getModalData($event, {
                                  dataUrl: 'edit/ticketsell/' + form_data.id,
                                })
                              "
                              class="btn btn-info btn-xs"
                              title="Edit"
                              data-toggle="modal"
                              data-target="#addNewJobGrade"
                            >
                              <i class="fa fa-edit"> </i> Edit |
                            </button> -->

                            <button
                              v-if="lists.delete == 'delete'"
                              @click="
                                deleteItem({
                                  delUrl: 'delete/ticketsell/' + form_data.id,
                                })
                              "
                              title="Delete"
                              class="btn btn-danger btn-xs"
                            >1
                              <i class="fa fa-trash"></i> Delete
                            </button>
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td colspan="6" align="center">
                            No data in database
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row">
                      <div
                        class="dataTables_footer clearfix col-md-12 col-12"
                        style="padding: 10px 0px"
                      >
                        <div class="col-md-6 col-6 float-left">
                          <div
                            class="dataTables_info"
                            id="DataTables_Table_0_info"
                          >
                            Showing {{ paginate_data.current_page }} of
                            {{ paginate_data.last_page }} pages
                          </div>
                        </div>
                        <div class="col-md-6 col-6 float-right">
                          <div
                            class="
                              dataTables_paginate
                              paging_bootstrap
                              float-right
                            "
                          >
                            <pagination
                              :data="paginate_data"
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

        <modal class="" name="myModal" height="auto" :clickToClose="false">
          <div v-if="modal_loading">
            <div class="widget-header modal-header">
              <h4><i class="fa fa-bars"></i> Ticket Open</h4>
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
              <form
                @submit.prevent="add({ add: 'add/ticketsell' }, resetModal)"
                class="form-horizontal row-border"
                id="validate-1"
              >
                <div class="">
                  <div class="col-md-12">
                    <div class="form-group" v-if="!form_data.id">
                      <label class="col-md-6 control-label"
                        >Employee
                        <sup style="color: red; top: -2px">*</sup></label
                      >
                      <div class="col-md-12 inputGroupContainer">
                        <div class="input-group">
                          <span
                            class="input-group-addon"
                            style="max-width: 100%"
                            ><i class="glyphicon glyphicon-list"></i
                          ></span>
                          <vue-select
                            v-model="employee_name_value"
                            :options="option_data.employee_data"
                            @select="onSelectEmployeeSearch"
                            placeholder="Select one"
                            label="text"
                            track-by="text"
                          ></vue-select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-6 control-label">Total Ticket</label>
                      <div class="col-md-12 inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"
                            ><i class="glyphicon glyphicon-home"></i
                          ></span>
                          <input
                            id="total_ticket"
                            v-model="form_data.total_ticket"
                            name="total_ticket"
                            placeholder=""
                            class="form-control"
                            required="true"
                           
                            type="text"
                          />
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-6 control-label">Date</label>
                      <div class="col-md-12 inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"
                            ><i class="glyphicon glyphicon-home"></i
                          ></span>
                          <datepicker
                            placeholder="Select Date"
                            v-model="form_data.date"
                            class="form-control"
                            required
                          ></datepicker>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" v-if="form_data.id">
                      <label class="col-md-6 control-label">Status</label>
                      <div class="col-md-12 inputGroupContainer">
                        <div class="input-group">
                          <span
                            class="input-group-addon"
                            style="max-width: 100%"
                            ><i class="glyphicon glyphicon-list"></i
                          ></span>
                          <select
                            class="form-control"
                            v-model="form_data.ticket_status"
                            required="true"
                          >
                            <option disabled>--Select--</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-actions col-md-12">
                  <input
                    type="submit"
                    tabindex="4"
                    value="Save"
                    class="btn btn-sm btn-info float-right col-md-2"
                  />
                  <button
                    type="button"
                    @click="hideModal"
                    class="
                      btn btn-sm btn-default
                      float-right
                      col-md-2
                      offset-md-6
                    "
                    style="margin-right: 10px"
                  >
                    Close
                  </button>
                </div>
              </form>
            </div>
          </div>
          <div v-if="!modal_loading">
            <pageLoading></pageLoading>
          </div>
        </modal>
        <modal class="" name="usemyModal" height="auto" :clickToClose="false">
          <div v-if="modal_loading">
            <div class="widget-header modal-header">
              <h4><i class="fa fa-bars"></i> Ticket Use</h4>
              <button
                type="button"
                @click="usehideModal"
                class="close close-modify"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modify-wraper modal-body">
              <div class="">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="col-md-6 control-label"
                      >Search Ticket Number</label
                    >
                    <div class="col-md-12 inputGroupContainer">
                      <div class="input-group">
                        <span class="input-group-addon"
                          ><i class="glyphicon glyphicon-home"></i
                        ></span>
                        <input
                          id="total_ticket"
                          v-on:keyup="getunusedticket"
                          v-model="ticket_number"
                          name="total_ticket"
                          placeholder=""
                          class="form-control"
                         
                          type="text"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Ticket Number</th>
                        <th>Ticket Price</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(ticket, index) in search_list" :key="index">
                        <td>{{ ticket.ticket_number }}</td>
                        <td>
                          {{ ticket.jointicketsell.ticket_price_per }}
                        </td>
                        <td>
                          <button
                            class="btn btn-sm btn-info"
                            @click="useticket(ticket.id)"
                          >
                            Use
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
import "vue2-timepicker/dist/VueTimepicker.css";
import $ from "jquery";
export default {
  data() {
    return {
      ticket_number: null,
      employee_name_value: "",
      search_list: [],
    };
  },
  created() {
    this.getResults(1);
  },
  components: {
    pageLoading: Loading,
  },
  methods: {
    useticket(id) {
      var self = this;
      let uri = URL.baseUrl("update/useticket");
      axios
        .get(uri, {
          params: {
            id: id,
          },
        })
        .then((res) => {
          // self.search_list = res.data;
          if (res.data.status == 1) {
            this.getunusedticket();
          }
          this.showToster({ status: res.data.status, message: res.data.message });
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getunusedticket() {
      var self = this;
      var form_data = new FormData();
      form_data.append("ticket_number", this.ticket_number);
      let uri = URL.baseUrl("search/unusedticket");
      axios
        .post(uri, form_data)
        // .then(function (response) {
        .then((res) => {
          self.search_list = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    ticketuse() {
      this.$modal.show("usemyModal");
    },
    usehideModal() {
      this.$modal.hide("usemyModal");
    },
    onSelectEmployeeSearch(option) {
      this.form_data.emp_id = option.id;
    },
  },
};
</script>