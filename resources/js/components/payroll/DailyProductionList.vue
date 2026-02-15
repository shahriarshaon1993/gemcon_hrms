<template>
  <div>
    <div v-if="page_loading" class="widget box">
      <div class="widget-header">
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body col-md-12">
                    <div class="row" style="padding: 0px">
                      <div class="form-group col-md-4">
                        <datepicker
                          placeholder="Select Date"
                          v-model="from_date"
                          class="form-control"
                        ></datepicker>
                      </div>

                      <div class="form-group col-md-4">
                        <datepicker
                          placeholder="Select Date"
                          v-model="to_date"
                          class="form-control"
                        ></datepicker>
                      </div>

                      <div class="form-group col-md-4">
                        <button
                          type="button"
                          class="btn btn-primary"
                          @click="daily_production"
                        >
                          Search
                        </button>
                      </div>
                    </div>

                    <table
                      id="employeeTable"
                      class="table table-bordered table-striped employeeTable"
                    >
                      <thead>
                        <tr class="text-center">
                          <th class="text-center">#</th>
                          <th style="width: 95px">Date</th>

                          <th>Tota Employee</th>
                          <th>Total Quantity</th>
                          <th>Total OT Quantity</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody class="text-left">
                        <tr
                          v-for="(
                            data, index
                          ) in daily_production_data"
                          :key="index"
                          @click="showModel_aa(data)"
                        >
                          <td>{{ index + 1 }}</td>
                          <td>{{ data.production_date }}</td>
                          <td class="text-center">{{ data.totalemp }}</td>
                          <td class="text-right">{{ data.totalqty | number('0,0.00') }}</td>
                          <td class="text-right">{{ data.totalotqty | number('0,0.00') }}</td>
                          <td class="text-right">{{ data.totalamount | number('0,0.00')}}</td>
                        </tr>
                      </tbody>
                    </table>
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
    <modal
      class=""
      width="60%"
      name="myModal"
      height="auto"
      :clickToClose="false"
    >
      <div>
        <div class="widget-header modal-header">
          <h4><i class="fa fa-bars"></i> Daily Production List</h4>
          <button
            type="button"
            @click="hideModel_aa"
            class="close close-modify"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- modal-body -->
        <div class="modify-wraper">
          <div class="row" style="padding-left: 10px; padding-right: 10px">
            <div class="col-md-12 table-responsive">
              <table
                id="employeeTable"
                class="table table-bordered table-striped employeeTable"
              >
                <thead>
                  <th>SL</th>
                  <th>ID No.</th>
                  <th style="width: 15%">Name</th>
                  <th style="width: 95px">Date</th>
                  <th>Shift</th>
                  <th>Product</th>
                  <th>Bundle</th>
                  <th>Grade</th>
                  <th>Machine</th>
                  <th>Line</th>
                  <th>Quantity</th>
                  <th>OT Qty</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th >
                    Status
                  </th>
                </thead>
                <tbody class="text-left">
                  <tr
                    v-for="(data, index) in click_data.getalldata"
                    :key="index"
                    class="ths"
                  >
                    <td class="ths">{{ index + 1 }}</td>
                    <td class="ths">
                      {{
                        data.joinemployee
                          ? data.joinemployee.employee_id_no
                          : ""
                      }}
                    </td>
                    <td class="ths">
                      {{
                        data.joinemployee
                          ? data.joinemployee.employee_fullname
                          : ""
                      }}
                    </td>
                    <td class="ths">{{ data.production_date }}</td>
                    <td class="ths">
                      {{ data.joinshift ? data.joinshift.title : "" }}
                    </td>
                    <td class="ths">
                      {{
                        data.joinproduct ? data.joinproduct.product_name : ""
                      }}
                    </td>
                    <td class="ths">
                      {{
                        data.joinbundle
                          ? data.joinbundle.bundle?data.joinbundle.bundle.bundle_name:""
                          : ""
                      }}
                    </td>
                    <td class="ths">
                      {{ data.joingrade ? data.joingrade.grade_name : "" }}
                    </td>
                    <td class="ths">
                      {{
                        data.joinmachine ? data.joinmachine.machine_name : ""
                      }}
                    </td>
                    <td class="ths">
                      {{ data.joinline ? data.joinline.line_name : "" }}
                    </td>
                    <td class="ths">{{ data.product_quantity }}</td>
                    <td class="ths">{{ data.product_qt_quantity }}</td>
                    <td class="ths">{{ data.product_rate }}</td>
                    <td class="ths text-right">{{ data.amount }}</td>
                    <td
                      class="ths"
                      
                    >
                      <!-- {{ data.status ? "Active" : "Inactive" }} -->
                      <a
                        v-if="data.status ==1"
                        href="javascript:void(0)"
                        @click="change_status(data, index)"
                        class="btn btn-success"
                      >
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                      </a>
                      <a
                        v-else
                        href="javascript:void(0)"
                        @click="change_status(data, index)"
                        class="btn btn-info"
                      >
                        <i class="fa fa-clock" aria-hidden="true"></i>
                      </a>
                      <a
                      v-if="data.status ==1"
                      href="javascript:void(0)"
                      @click="deleteItem({delUrl:'delete/daily_production_entry/'+data.id})"
                      class="btn btn-info"
                    >
                    <i class="fa fa-trash"> Delete</i>
                    </a>
                      <!-- lists.delete=='delete' && -->
                      <!-- <button  v-if=" data.status ==1" @click="deleteItem({delUrl:'delete/daily_production_entry/'+data.id})" title="Delete" class="btn-xs btn-danger"><i class="fa fa-trash"></i> </button> -->
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="form-actions col-md-12">
            <button
              type="button"
              @click="change_status_all"
              class="btn btn-sm btn-success float-left col-md-2"
              style="margin-left: 10px"
            >
              Approve All
            </button>
            <button
              type="button"
              @click="hideModel_aa"
              class="btn btn-sm btn-default float-right col-md-2"
              style="margin-right: 10px"
            >
              Close
            </button>
          </div>
        </div>
      </div>
      <div v-if="!modal_loading">
        <pageLoading></pageLoading>
      </div>
    </modal>
    <div v-if="!page_loading">
      <pageLoading></pageLoading>
    </div>
  </div>
</template>
<style>
.ths {
  border: 1px solid #dee2e6;
}
</style>
<script>
import Loading from "../Loading.vue";
import Datepicker from "vuejs-datepicker";
import * as xlsx from 'xlsx/xlsx';

export default {
  data() {
    return {
      page_loading: true,
      from_date: "",
      to_date: "",
      click_data: [],
      daily_production_data: [],
      all_date: "",
    };
  },

  created() {
    this.daily_production();
  },
  components: {
    pageLoading: Loading,
  },
  methods: {
    change_status_all() {
      var self = this;
      self.page_loading = false;
      let url = URL.baseUrl("daily_production/change_status_all");
      // var url = "daily_production/change_status";
      var data = {
        status: 0,
        all_date: this.all_date,
      };
      axios
        .post(url, data)
        .then(function (response) {
          self.daily_production();
          self.page_loading = true;
          self.showToster({
            status: response.data.status,
            message: response.data.message,
          });
          self.$modal.hide("myModal");
        })
        .catch(function (error) {
          console.log(error);
          self.page_loading = true;
          self.showToster({ status: 0, message: "opps! something went wrong" });
          self.$modal.hide("myModal");
        });
    },
    change_status(data, index) {
      let id = data.id;
      this.page_loading = false;
      let status = data.status;
      var self = this;
      let url = URL.baseUrl("daily_production/change_status");
      // var url = "daily_production/change_status";
      var data = {
        id: id,
        status: status ? 0 : 1,
      };
      axios
        .post(url, data)
        .then(function (response) {
          self.click_data.getalldata[index].status = !data.status;
          self.daily_production();
          self.showToster({ status: 1, message: "Status Changed" });
          // self.$modal.hide("myModal");
          this.page_loading = true;
        })
        .catch(function (error) {
          console.log(error);
          self.showToster({ status: 0, message: "opps! something went wrong" });
          // self.$modal.hide("myModal");
          this.page_loading = true;

        });
    },
    showModel_aa(data) {
      this.click_data = data;
      this.all_date = data.production_date;
      this.$modal.show("myModal");
    },
    hideModel_aa() {
      this.$modal.hide("myModal");
    },
    daily_production() {
       this.page_loading = false;
       this.modal_loading = false;
      let data = {
        from_date: this.from_date,
        to_date: this.to_date,
      };
       
      let urls = URL.baseUrl("daily_production_list");
      axios
        .get(urls, {
          params: data,
        })
        .then((res) => {
          if (res.data.status == "logout") {
            window.location.href = res.data.url;
          } else {
            this.daily_production_data = res.data;
            this.page_loading = true;
            this.modal_loading = true;
          }
        })

        .catch((error) => {
          console.log(error);
          this.showToster({ status: 0, message: "opps! something went wrong" });
        });
    },
  },
};
</script>
<style type="text/css">
.salaryTable.table td {
  padding: 15px 5px;
}
</style>