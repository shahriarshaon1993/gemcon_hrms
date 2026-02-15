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
                        ><i class="bx bx-home-alt"></i>
                      </router-link>
                    </li>
                    <li class="breadcrumb-item active">Evaluation</li>
                  </ol>
                </div>
              </div>
              <div class="col-sm-3">
                <!-- <router-link class="btn btn-primary add-btn" :to="{ path: '/add_daily_work' }"> <i class="bx bx-add-alt"></i> Add daily work </router-link> -->
              </div>
            </div>
          </div>
        </div>
        <div class="content-body">
          <section id="basic-datatable">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body card-dashboard">
                      <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                          <thead class="thead-dark">
                            <tr>
                              <th>Question</th>
                              <th>MOS</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <template v-for="(item, index) in items">
                              <tr
                                :class="index"
                                class="animate__animated animate__fadeInLeft"
                                :style="
                                  'animation-duration: calc(0.2s * ' +
                                  index +
                                  ')'
                                "
                              >
                                <td @click="ansShow(item.answersjoin, index)">
                                  {{ item.vQuestion }}
                                </td>

                                <td @click="ansShow(item.answersjoin, index)">
                                  {{
                                    item.mosdata ? item.mosdata.mos_name : ""
                                  }}
                                </td>
                                <td>
                                  <router-link
                                    class="btn btn-info"
                                    :to="{
                                      path: '/assessment_qus_edit/' + item.id,
                                    }"
                                  >
                                    <i class="bx bx-edit-alt mr-1"></i>
                                  </router-link>
                                </td>
                              </tr>
                              <tr :key="index" v-if="show && showid == index">
                                <td></td>
                                <td colspan="5">
                                  <div>
                                    <table
                                      class="table table-bordered table-striped"
                                    >
                                      <thead>
                                        <tr>
                                          <th>Answer</th>
                                          <th>Mark</th>
                                        </tr>
                                        <tr
                                          :key="index"
                                          v-for="(row, index) in showitem"
                                        >
                                          <td>
                                            {{ row.vAnswer }}
                                          </td>
                                          <td>
                                            {{ row.mark }}
                                          </td>
                                        </tr>
                                      </thead>
                                    </table>
                                  </div>
                                </td>
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
// import JsonExcel from "vue-json-excel"
export default {
  props: {},
  components: {
    // "downloadExcel": JsonExcel
    //VueExcelXlsx
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {
      base_url: window.base_url,
      api_url: window.api_url,
      user_data: JSON.parse(this.$localStorage.get("user")).data,
      items: [],
      item: [],
      show: false,
      showid: 0,
      showitem: {},
    };
  },
  created() {
    this.getItems();
  },
  methods: {
    ansShow(row, index) {
      this.showitem = row;
      this.showid = index;
      this.show = !this.show;
    },
    async getItems() {
      let loader = this.$loading.show();
      try {
        await axios
          .get(this.api_url + "questions", {
            headers: {
              "Content-Type": "application/json",
              // Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then(({ data }) => {
            if (data.success) {
              this.items = data.data;
              console.log(this.items);
            }
            loader.hide();
          });
      } catch (error) {
        loader.hide();
      }
    },
  },
  computed: {},
};
</script>