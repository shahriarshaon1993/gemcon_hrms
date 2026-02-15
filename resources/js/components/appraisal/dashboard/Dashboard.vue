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
                      <router-link :to="{ path: '/' }">
                        <i class="bx bx-home-alt"> </i>
                      </router-link>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section id="basic-datatable">
          <div class="content-body">
            <div class="users-list-filter px-1">
              <div class="row border rounded py-2 mb-2">
                <div class="col-12 col-sm-6 col-lg-2">
                  <label for="users-list-verified"> Department </label>
                  <fieldset class="form-group">
                    <select
                      class="form-control"
                      id="users-list-verified"
                      v-model="filterForm.dept_id"
                      v-on:change="filter_data()"
                    >
                      <option value="">All</option>
                      <option
                        :key="row.id"
                        :value="row.id"
                        v-for="row in deptItems"
                      >
                        {{ row.name }}
                      </option>
                    </select>
                  </fieldset>
                </div>
                <div class="col-12 col-sm-6 col-lg-2">
                  <label for="users-list-verified"> Filter By </label>
                  <fieldset class="form-group">
                    <select
                      class="form-control"
                      id="users-list-verified"
                      v-model="filterForm.filter_by"
                    >
                      <option value="year">Year</option>
                      <option value="quarter">Quarter</option>
                    </select>
                  </fieldset>
                </div>
              </div>

              <!-- //Dept Wise Monthly Activity -->
            </div>
          </div>
        </section>
      </div>
    </div>
    <!-- END: Content-->
    <!-- demo chat-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
  </div>
</template>
<script>
//import LineChart from './LineChart.js'
//import axios from "../axios_instance";
import axios from "../axios_instance";
import { Form } from "vform";
import VueApexCharts from "vue-apexcharts";
export default {
  props: {},
  components: {
    apexchart: VueApexCharts,
    // LineChart
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {
      monthNames: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      monthly_activity: [],
      target_achievement: [],

      // achievement : JSON.parse(this.$localStorage.get("achievement")),
      // target : JSON.parse(this.$localStorage.get("target")),
      // achievement_with_remaining : JSON.parse(this.$localStorage.get("achievement_with_remaining")),
      // piecolor : JSON.parse(this.$localStorage.get("piecolor")),
      // monthname : JSON.parse(this.$localStorage.get("monthname")),
      // //performance_value : JSON.parse(this.$localStorage.get("performance_value")),
      // user_data: JSON.parse(this.$localStorage.get("user")).data,
      base_url: window.base_url,
      api_url: window.api_url,
      search: "",
      item: [],
      current_month: "",
      current_monthstr: "",
      month_index: 0,
      deptItems: [],
      filterForm: new Form({
        dept_id: "",
        filter_by: "year",
      }),
      // token: this.$localStorage.get("d_token"),

      achievement_1: [12, 34, 12],

      achievement_2: [20, 34, 12],

      achievement_3: [12, 10, 12],

      achievement_4: [50, 34, 12],

      // performance_value :  JSON.parse(this.$localStorage.get("performance_value")),
      performance: {
        chartOptions: {
          chart: {
            height: "100%",
            type: "donut",
          },
          title: {
            text: "Performance Management",
            align: "center",
          },
          labels: ["Performance", "Remaining "],
          theme: {
            monochrome: {
              enabled: true,
            },
          },
          responsive: [
            {
              breakpoint: 480,
              options: {
                chart: {
                  width: 200,
                },
                legend: {
                  position: "bottom",
                },
              },
            },
          ],
        },
      },

      dept_analytics_series: [],
    };
  },
  mounted: function () {},
  created() {
    // this.dept_id = this.user_data.department ;
    this.dept_id = 1;
    if (this.$route.params.type == "login") {
      //  alert('ok');
      this.$router.push("/");
      this.$router.go("/");
    }
    // this.role_id = this.user_data.role_id ;
    // if(this.role_id == 5 || this.role_id == 6 || this.role_id == 7){
    //    this.filterForm.dept_id =   this.user_data.department ;
    //   // this.getWing();
    //   this.getDept();
    // }else{
    //     this.getDept();
    // }

    // let d = new Date();
    // this.month_index =  d.getMonth() ;
    // this.current_month  =  this.monthNames[ this.month_index] ;
    // this.current_monthstr = this.current_month.toLowerCase() ;

    // this.getTargetAchievement();
    // this.getMonthly_activity();
  },
  methods: {
    
    changeMonth() {
      let loader = this.$loading.show();
      this.current_month = this.monthNames[this.month_index];
      this.current_monthstr = this.current_month.toLowerCase();
      loader.hide();
    },
    hide_pop() {
      this.$modal.hide("popup-singel");
    },
    filter_data() {
      this.getTargetAchievement();
      this.getMonthly_activity();
    },
    show_pop(row) {
      if (this.item.target && this.item.achievement) {
        this.item = row;
        this.$modal.show("popup-singel");
        // this.dept_analytics_series = [{
        //             name: 'Target',
        //             data: [
        //               this.item.target.january,
        //               this.item.target.february, this.item.target.march,
        //               this.item.target.april, this.item.target.may,
        //               this.item.target.june, this.item.target.july,
        //               this.item.target.august, this.item.target.september,
        //               this.item.target.october, this.item.target.november,
        //               this.item.target.december]
        //         },
        //         {
        //             name: 'Achievement',
        //             data: [this.item.achievement.january,
        //              this.item.achievement.february, this.item.achievement.march,
        //               this.item.achievement.april, this.item.achievement.may,
        //               this.item.achievement.june, this.item.achievement.july,
        //               this.item.achievement.august, this.item.achievement.september,
        //               this.item.achievement.october, this.item.achievement.november,
        //               this.item.achievement.december]
        //         }]  ;
        this.$refs.singel_analytics_bar.updateSeries(
          this.dept_analytics_series
        );
        // this.group_donut_value = [this.item.jan, this.item.feb, this.item.mar, this.item.apr, this.item.may, this.item.jun, this.item.jul, this.item.aug, this.item.sep, this.item.oct, this.item.nov, this.item.dec]
        // this.$refs.group_donut.updateSeries(this.group_donut_value );
      }
    },

    async getTargetAchievement() {
      // setInterval(() => {
      let loader = this.$loading.show();
      let where = "?";
      if (this.filterForm.dept_id) {
        where += "&dept_id=" + this.filterForm.dept_id;
      }
      try {
        await axios
          .get(this.api_url + "dashboard" + where, {
            headers: {
              "Content-Type": "application/json",
              Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then(({ data }) => {
            if (data.success) {
              // setInterval(() => {
              this.target_achievement = data.data;
              this.achievement = this.target_achievement.achievement;
              this.achievement_with_remaining =
                this.target_achievement.achievement_with_remaining;
              this.piecolor = this.target_achievement.color;
              this.monthname = this.target_achievement.monthname;
              this.performance_value =
                this.target_achievement.performance_value;

              this.target = this.target_achievement.target;
              // this.$localStorage.get("achievement")
              this.$localStorage.set(
                "achievement",
                JSON.stringify(this.achievement)
              );
              this.$localStorage.set("target", JSON.stringify(this.target));
              this.$localStorage.set(
                "achievement_with_remaining",
                JSON.stringify(this.achievement_with_remaining)
              );
              this.$localStorage.set("piecolor", JSON.stringify(this.piecolor));
              this.$localStorage.set(
                "monthname",
                JSON.stringify(this.monthname)
              );
              this.$localStorage.set(
                "performance_value",
                JSON.stringify(this.performance_value)
              );
            }
            loader.hide();
          });
      } catch (error) {
        loader.hide();
      }
      // }, 3000);
    },

    //Department Wise Monthly Activity
    async getMonthly_activity() {
      let where = "?";

      // if (this.filterForm.dept_id ) {
      //     where += '&id=' + this.filterForm.dept_id;
      // }
      //let loader = this.$loading.show();
      try {
        await axios
          .get(this.api_url + "department_wise_monthly_activity" + where, {
            headers: {
              "Content-Type": "application/json",
              Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then(({ data }) => {
            if (data.success) {
              this.monthly_activity = data.data;

              console.log(this.items);
            }
            //loader.hide();
          });
      } catch (error) {
        console.log(error);
        //loader.hide();
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
  computed: {
    // achievement_series() {
    //     return this.achievement ;
    // }
    filteredItems() {
      return this.monthly_activity.filter((item) => {
        return item.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
      });
    },
  },
};
</script>
<style>
.card_box {
  min-height: 310px !important;
}
</style>