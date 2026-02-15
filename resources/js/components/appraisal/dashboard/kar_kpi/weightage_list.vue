<template>
  <div>
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-12 mb-1 mt-0">
            <div class="row breadcrumbs-top">
              <div class="col-sm-9">
                <div class="breadcrumb-wrapper col-9">
                  <ol class="breadcrumb p-0 mb-0">
                    <li class="breadcrumb-item">
                      <router-link :to="{ path: '/' }"
                        ><i class="bx bx-home-alt"></i
                      ></router-link>
                    </li>
                    <li class="breadcrumb-item active">Weightage List</li>
                  </ol>
                </div>
              </div>
              <!-- <div class=" col-sm-3">
                                <router-link class="btn btn-primary add-btn" :to="{ path: '/add_daily_work' }"> <i class="bx bx-add-alt"></i> Add daily work </router-link>
                            </div> -->
            </div>
          </div>
        </div>
        <div class="content-body">
          <section id="basic-datatable">
            <div class="users-list-filter px-1">
              <div class="row border rounded py-2 mb-2">
                <div
                  v-if="
                    role_id == 1 || role_id == 2 || role_id == 3 || role_id == 4
                  "
                  class="col-12 col-sm-6 col-lg-2"
                >
                  <label for="users-list-verified">Department</label>
                  <fieldset class="form-group">
                    <select
                      class="form-control"
                      v-on:change="getItems()"
                      v-model="filterForm.dept_id"
                      id="users-list-verified"
                    >
                      <option value="">Select One</option>
                      <option
                        v-for="row in deptItems"
                        :key="row.id"
                        :value="row.id"
                      >
                        {{ row.name }}
                      </option>
                    </select>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                          <thead class="thead-dark">
                            <tr>
                              <th>KRA</th>
                              <!-- <th>KRA Weightage</th> -->
                              <th>KPI</th>
                              <!-- <th>KPI Weightage</th> -->
                              <th>MOS</th>
                              <!-- <th>MOS Weightage</th>  -->
                            </tr>
                          </thead>
                          <tbody>
                            <template v-for="(item, index) in items">
                              <tr :key="item.id">
                                <td>
                                  {{
                                    item.krajoin ? item.krajoin.kra_name : ""
                                  }}
                                </td>
                                <!-- <td >{{ item.krajoin ? item.krajoin.kra_weight : '' }}</td> -->
                                <td>
                                  {{
                                    item.kpijoin ? item.kpijoin.kpi_name : ""
                                  }}
                                </td>
                                <!-- <td >{{ item.kpijoin ? item.kpijoin.kpi_weight : '' }}</td> -->
                                <td>{{ item.mos_name }}</td>
                                <!-- <td>{{ item.weightage }}</td>  -->
                                
                              </tr>
                            </template>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</template>
    
    <script>
import axios from "../../axios_instance";
import { Form } from "vform";
export default {
  props: {},
  components: {
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {
      base_url: window.base_url,
      api_url: window.api_url,
      token: this.$localStorage.get("d_token"),
      user_data: JSON.parse(this.$localStorage.get("user")).data,
      role_id: "",
      items: [],
      status: "",
      deptItems: [],
      year: this.$localStorage.get("year")
        ? this.$localStorage.get("year")
        : new Date().getFullYear(),
      filterForm: new Form({
        dept_id: "",
      }),
    };
  },
  created() {
    this.role_id = this.user_data.role_id;
    if (
      this.role_id == 1 ||
      this.role_id == 2 ||
      this.role_id == 3 ||
      this.role_id == 4
    ) {
      this.getDept();
    } else {
      //this.getItems();
      this.filterForm.dept_id = this.user_data.department;
      this.getItems();
    }
  },
  methods: {
    achievement(item, month) {
      if (item.mostargetjoin[month] > 0 && item.mosachievementjoin[month] > 0) {
        return (
          (item.mostargetjoin[month] / item.mosachievementjoin[month]) *
          100
        ).toFixed();
      } else {
        return 0;
      }
      // (item.mostargetjoin.january / item.mosachievementjoin.january)/100
    },
    checkConditionKra(length, kpi_index, mos_index) {
      if (kpi_index == 0 && mos_index == 0) {
        return true;
      } else {
        return false;
      }
    },
    checkConditionKpi(length, mos_index) {
      if (mos_index == 0) {
        return true;
      } else {
        return false;
      }
    },
    async getItems() {
      if (this.filterForm.dept_id != "") {
        let where =
          "?year=" + (this.year ? this.year : new Date().getFullYear());
        if (this.filterForm.dept_id) {
          where += "&dept_id=" + this.filterForm.dept_id;
        }
        let loader = this.$loading.show();
        try {
          await axios
            .get(this.api_url + "kra_kpi_mos_list" + where, {
              headers: {
                "Content-Type": "application/json",
                Authorization: this.token ? `Bearer ${this.token}` : "",
              },
            })
            .then(({ data }) => {
              if (data.success) {
                this.items = data.data;
                console.log("this.items", this.items);
              }
              loader.hide();
            });
        } catch (error) {
          loader.hide();
        }
      }
    },
    async getDept() {
      let loader = this.$loading.show();
      this.getDepartments(this.status).then(({ data }) => {
        if (data.success) {
          loader.hide();
          this.deptItems = data.data;
          //this.getItems();
        } else {
          loader.hide();
        }
      });
    },
  },
  computed: {},
};
</script>
    