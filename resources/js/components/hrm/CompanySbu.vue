<template>
  <div>
    <link
      href="http://127.0.0.1:8000/melon/assets/css/table-sort.css"
      rel="stylesheet"
      type="text/css"
    />
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
                          Comapny/SBU List
                        </h3>
                        <span class="float-sm-right" style="float: right">
                          <div
                            v-if="lists.add == 'add'"
                            @click="
                              getModalData(
                                $event,
                                { dataUrl: 'create/companysbu' },
                                resetModal
                              )
                            "
                            class="btn-group"
                          >
                            <span class="btn btn-sm btn-info"
                              ><i class="icon-plus"></i>Add New</span
                            >
                          </div>
                          <a class="btn btn-default" @click="$router.go(-1)"
                            ><i class="fa fa-arrow-left"></i> Back</a
                          >
                        </span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-4">
                        <div class="info-box">
                          <span class="info-box-icon bg-info elevation-1"
                            ><i class="fa fa-paper-plane"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Total </span>
                            <span class="info-box-number">
                              {{ lists.total_data }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-4">
                        <div class="info-box">
                          <span class="info-box-icon bg-warning elevation-1"
                            ><i class="fas fa-clock"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Inactive </span>
                            <span class="info-box-number">
                              {{ lists.inactive_data }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-4">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-success elevation-1"
                            ><i class="fa fa-check-circle"></i
                          ></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Active </span>
                            <span class="info-box-number">
                              {{ lists.active_data }}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix hidden-md-up"></div>
                      <!-- <div class="col-12 col-sm-12 col-md-3">
                         <div class="info-box mb-3">
                           <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-ban"></i></span>
                           <div class="info-box-content">
                             <span class="info-box-text">Rejected </span>
                             <span class="info-box-number">DDD</span>
                           </div>
                         </div>
                       </div> -->
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
                            v-bind:class="getSortingClass('sbu_code')"
                            @click="sortingChanged('sbu_code')"
                          >
                            SBU Code <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('sbu_name')"
                            @click="sortingChanged('sbu_name')"
                          >
                            SBU Name <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('sbu_short_name')"
                            @click="sortingChanged('sbu_short_name')"
                          >
                            Short Name <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('employees_count')"
                            @click="sortingChanged('employees_count')"
                          >
                            No. of Emploee <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('office_start_time')"
                            @click="sortingChanged('office_start_time')"
                          >
                            Office Time <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('weekend')"
                            @click="sortingChanged('weekend')"
                          >
                            Priority <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center"
                            v-bind:class="getSortingClass('weekend')"
                            @click="sortingChanged('weekend')"
                          >
                            Weekend <i class="fas fa-sort"></i>
                          </th>
                          <th
                            class="text-center sortable"
                            v-bind:class="getSortingClass('sbu_name')"
                            @click="sortingChanged('sbu_logo')"
                          >
                            SBU Logo
                          </th>
                          <th
                            class="text-center sortable"
                            v-bind:class="getSortingClass('sbu_name')"
                            @click="sortingChanged('sbu_logo')"
                          >
                            Status
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
                          <td class="text-center">
                            {{ order_no + index + 1 }}
                          </td>
                          <td style="text-align: center">
                            {{ form_data.sbu_code }}
                          </td>
                          <td>{{ form_data.sbu_name }}</td>
                          <td  style="text-align: center">{{ form_data.sbu_short_name }}</td>
                          <td style="text-align: center">
                            {{ form_data.employees_count }}
                          </td>
                          <td style="text-align: center">
                            {{ form_data.office_start_time }}-{{
                              form_data.office_end_time
                            }}
                          </td>
                          <td style="text-align: center">
                            {{ form_data.priority }}
                          </td>
                          <td style="text-align: center">
                            {{ form_data.weekend }}
                          </td>
                          <td style="text-align: center">
                            <img
                              v-if="form_data.sbu_logo !== ''"
                              :src="`company_logo/${form_data.sbu_logo}`"
                              class="card-img-top border rounded"
                              style="height: 50px; width: 50px"
                            />
                          </td>
                          <td style="text-align: center">
                            <span
                              v-if="form_data.sbu_status == 1"
                              style="color: green"
                            >
                              {{ "Active" }}
                            </span>
                            <span v-else style="color: red">
                              {{ "Inactive" }}
                            </span>
                          </td>
                          <td class="text-center">
                            <button
                              v-if="lists.edit == 'edit'"
                              @click="
                                getModalData($event, {
                                  dataUrl: 'edit/companysbu/' + form_data.id,
                                })
                              "
                              class="btn btn-xs btn-info"
                              title="Edit"
                              data-toggle="modal"
                              data-target="#addNewDepartment"
                              style=""
                            >
                              <i class="fa fa-edit"> </i> Edit |
                            </button>

                            <button
                              v-if="lists.delete == 'delete'"
                              @click="
                                deleteItem({
                                  delUrl: 'delete/companysbu/' + form_data.id,
                                })
                              "
                              title="Delete"
                              class="btn btn-xs btn-danger"
                              style=""
                            >
                              <i class="fa fa-trash"></i> Delete
                            </button>
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td colspan="3" align="center">
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
              <h4><i class="fa fa-bars"></i> Company/SBU</h4>
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
                @submit.prevent="add({ add: 'add/companysbu' }, resetModal)"
                class="form-horizontal row-border"
                enctype="multipart/form-data"
              >
                <div class="">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="col-md-12 control-label"
                            >Company/SBU Name</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                id="sbu_name"
                                v-model="form_data.sbu_name"
                                name="sbu_name"
                                placeholder=""
                                class="form-control"
                                required="true"

                                type="text"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-md-12 control-label"
                            >SBU Short Name</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                id="sbu_name"
                                v-model="form_data.sbu_short_name"
                                name="sbu_name"
                                placeholder=""
                                class="form-control"
                                required="true"

                                type="text"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 5px">
                      <label class="col-md-4 control-label">Image Upload</label>
                      <div class="col-md-12 inputGroupContainer">
                        <div class="col-md-6 float-left">
                          <div class="input-group file-upload-form">
                            <input
                              type="file"
                              v-on:change="onFileChange"
                              accept="image/*"
                            />
                          </div>
                        </div>
                        <div
                          class="col-md-6 float-left"
                          style="margin-bottom: 0px"
                        >
                          <div
                            class="image-preview"
                            style="
                              width: 190px;
                              height: 40px;
                              padding: 0px 36px 0px;
                            "
                          >
                            <img
                              v-if="form_data.sbu_logo !== ''"
                              :src="`company_logo/${form_data.sbu_logo}`"
                              class="card-img-top border rounded"
                              style="
                                margin-top: -20px;
                                height: 70px;
                                width: 70px;
                              "
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-6 control-label">Weekend</label>
                      <div class="col-md-12 inputGroupContainer">
                        <div class="input-group">
                          <span
                            class="input-group-addon"
                            style="max-width: 100%"
                            ><i class="glyphicon glyphicon-list"></i
                          ></span>

                          <vue-select
                            v-model="form_data.weekend"
                            :options="form_data.weekendList"
                            @select="onSelectWeekend"
                            placeholder="Select one"
                            multiple="multiple"
                            label="text"
                            track-by="text"
                          >
                          </vue-select>
                          <select
                            class="mdb-select md-form form-control"
                            v-model="form_data.weekend"
                            multiple="true"
                            v-bind:class="{ 'fix-height': multiple === 'true' }"
                            style="height: 70px !important"
                          >
                            <option disabled>--Select--</option>
                            <option value="Sat">Saturday</option>
                            <option value="Sun">Sunday</option>
                            <option value="Mon">Monday</option>
                            <option value="Tue">Tuesday</option>
                            <option value="Wed">Wednesday</option>
                            <option value="Thu">Thursday</option>
                            <option value="Fri">Friday</option>
                          </select>
                          <!-- <multiselect v-model="value" :options="options"></multiselect> -->
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="col-md-12 inputGroupContainer" style="margin-top: 15px;">
                          <label class="col-md-12 control-label" style="padding-left: 0px;">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input v-if="form_data.casual_absent == 1" @click = "casualAbsentAllow($event)" checked="checked" type="checkbox" style="margin: 5px 5px 0px 0px;">
                                <input v-else @click = "casualAbsentAllow($event)"  type="checkbox" style="margin: 5px 5px 0px 0px;">
                                Casual Absent Allow ?
                            </div>
                          </label>
                      </div>
                      </div>
                      <div class="col-md-7">
                        <div class="form-group">
                          <label class="col-md-12 control-label">Not Allow Work Location</label>
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>

                              <vue-select
                                v-model="form_data.workLocationData"
                                :options="form_data.work_location_data"
                                @select="onSelectWorkLocation"
                                placeholder="Select one"
                                multiple="multiple"
                                label="text"
                                track-by="text"
                              >
                              </vue-select>
                          </div>
                        </div>
                      </div>


                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-6 control-label"
                            >Office Start Time</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <vue-timepicker
                                class="form-control"
                                v-model="form_data.office_start_time"
                                required
                              ></vue-timepicker>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-6 control-label"
                            >Office End Time</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <vue-timepicker
                                class="form-control"
                                v-model="form_data.office_end_time"
                                required
                              ></vue-timepicker>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-6 control-label"
                            >Late Consider Time</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span
                                class="input-group-addon"
                                style="max-width: 100%"
                                ><i class="glyphicon glyphicon-list"></i
                              ></span>
                              <vue-timepicker
                                class="form-control"
                                v-model="form_data.lateConsiderTime"
                                required
                              ></vue-timepicker>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-6 control-label">Priority</label>
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                id="sbu_name"
                                v-model="form_data.priority"
                                name="sbu_name"
                                placeholder=""
                                class="form-control"
                                type="number"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-md-12 control-label"
                            >Modal Header Color</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                v-model="form_data.modal_header_color"
                                type="color"

                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-md-12 control-label"
                            >Header Font Color</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                v-model="form_data.header_font_color"
                                type="color"

                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="col-md-12 control-label"
                            >Header Font Size</label
                          >
                          <div class="col-md-12 inputGroupContainer">
                            <div class="input-group">
                              <span class="input-group-addon"
                                ><i class="glyphicon glyphicon-home"></i
                              ></span>
                              <input
                                v-model="form_data.header_font_size"
                                class="form-control"
                                type="number"
                              />
                            </div>
                          </div>
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
                            class="mdb-select md-form form-control"
                            v-model="form_data.sbu_status"
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
                <div class="form-actions">
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
// import Multiselect from 'vue-multiselect'

export default {
  data() {
    return {
      work_location_data:'',
      weekendList: [
        { id: "Sat", text: "Saturday" },
        { id: "Sun", text: "Sunday" },
        { id: "Mon", text: "Monday" },
        { id: "Tue", text: "Tuesday" },
        { id: "Wed", text: "Wednesday" },
        { id: "Thu", text: "Thursday" },
        { id: "Fri", text: "Friday" },
      ],
      // value: '',
      // options: ['Select option', 'options', 'selected', 'mulitple', 'label', 'searchable', 'clearOnSelect', 'hideSelected', 'maxHeight', 'allowEmpty', 'showLabels', 'onChange', 'touched']
    };
  },
  created() {
    this.getResults(1);
  },
  components: {
    pageLoading: Loading,
    VueTimepicker,
    // Multiselect
  },
  methods: {
    casualAbsentAllow(event){
      console.log(event.target.checked);
      this.form_data.casual_absent=event.target.checked;
      if(event.target.checked==false){
        this.work_location_data = null;
      }
    },
    onSelectWeekend(option) {
      console.log(form_data.weekend);
    },
    onSelectWorkLocation(option){
      // console.log(form_data.weekend);
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        this.form_data.sbu_logo = e.target.result;
        console.log(this.form_data.approve_by);
      };
      reader.readAsDataURL(file);
    },
    resetModal() {
      this.form_data.sbu_name = "";
      this.form_data.sbu_status = "1";
    },
  },
};
</script>
