<template>
  <div>
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-12 mb-1 mt-0">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb p-0 mb-0">
                    <li class="breadcrumb-item">
                      <router-link :to="{ path: '/' }"
                        ><i class="bx bx-home-alt"></i>
                      </router-link>
                    </li>
                    <li class="breadcrumb-item active">
                      Assessment Questions
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="content-body">
          <transition>
            <section class="input-validation">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Assessment questions setup</h4>
                    </div>
                    <div class="card-content">
                      <form @submit.prevent="create()">
                        <div class="card-body">
                          <label class="text-gray-600 font-semibold text-lg"
                            >question</label
                          >
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="controls">
                                  <input
                                    type="text"
                                    v-model="addForm.vQuestion"
                                    class="form-control"
                                    placeholder="Entry question"
                                  />
                                </div>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="controls">
                                  <button
                                    type="button"
                                    @click="addFieldKPI(qus.children)"
                                    class="btn btn-primary"
                                  >
                                    Answer
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div
                              v-for="(item, index) in qus.children"
                              :key="`phoneInput-${index}`"
                              class="input wrapper flex items-center label_2 animate__animated animate__fadeInRight"
                                :style="
                                  'animation-duration: calc(0.2s * ' +
                                  index +
                                  ')'
                                "
                            >
                              <label class="text-gray-600 font-semibold text-lg"
                                >Answer {{ index + 1 }}</label
                              >
                              <div class="row">
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <div class="controls">
                                      <input
                                        type="text"
                                        v-model="item.name"
                                        class="form-control"
                                        placeholder="Entry Answer"
                                      />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <div class="controls">
                                      <input
                                        type="number"
                                        @keypress="onlyNumber"
                                        v-model="item.mark"
                                        class="form-control"
                                        placeholder="Mark"
                                      />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary">
                            Submit
                          </button>
                        </div>
                      </form>
                    </div>

                    <!-- COPY KRA KPI MOD AREA --->
                  </div>
                </div>
              </div>
            </section>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Form } from "vform";
import axios from "../../axios_instance";
//import VueTree from '@ssthouse/vue-tree-chart';
export default {
  props: {},
  components: {
    //'vue-tree': VueTree
    // VueRecaptcha, facebookLogin
  },
  data() {
    return {
      itemsData: [],
      items: [],
      item: [],
      mos_id: this.$route.params.mos_id,
      qus: {
        
        children: [
          {
            name: "",
            mark: 0,
          },
        ],
      },
      chart: [],
      base_url: window.base_url,
      api_url: window.api_url,
    //   token: this.$localStorage.get("d_token"),
      user_data: JSON.parse(this.$localStorage.get("user")).data,
      role_id: "",
      sampleData: [],
      filterForm: new Form({
        dept_id: "",
      }),
      treeConfig: { nodeWidth: 200, nodeHeight: 100, levelHeight: 170 },
      addForm: new Form({
        arrayData: "",
        vQuestion: "",
        mos_id: '',
      }),

      mos_item: [],
      kpi_item: [],
      kra_item: [],
      year: this.$localStorage.get("year")
        ? this.$localStorage.get("year")
        : new Date().getFullYear(),
      optionFromYearValue: "",
      optionToYearValue: ""
    };
  },
  created() {
    this.role_id = this.user_data.role_id;
    this.filterForm.dept_id = this.user_data.department;
    // this.getItems();
    // this.getYearWiseKraKpiMosItems();
  },
  methods: {
    onlyNumber($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
        // 46 is dot
        $event.preventDefault();
      }
    },

    addFieldKPI(array) {
      array.push({
        children: [{ name: "", mark: 100 }],
      });
      // this.chart  = this.qus ;
    },

    addField(value, fieldType) {
      fieldType.push({ value: "" });
      console.log(this.qus);
    },
    removeField(index, fieldType) {
      console.log(fieldType);
      fieldType.splice(index, 1);
    },

    create() {
      // let loader = this.$loading.show();
      try {
        console.log(this.qus);
        this.addForm.arrayData = this.qus;
        this.addForm.year = this.year;
        this.addForm.mos_id = this.mos_id;
        this.addForm
          .post(this.api_url + "questions", {
            headers: {
              "Content-Type": "application/json",
            //   Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then((res) => {
            console.log(res);
            if (res.data.success) {
              this.$toasted.show(res.data.message, {
                theme: "bubble",
                duration: 5000,
                position: "bottom-right",
              });
              this.getItems();
            }
            // loader.hide();
          });
      } catch (error) {
        // loader.hide();
        console.log(error);
      }
    },
  },

  computed: {},
};
</script>
<style>
.input.wrapper.flex.items-center.label_2 {
  margin: 0 0 0 100px;
}

.input.wrapper.flex.items-center.label_3 {
  margin: 0 0 0 100px;
}
</style>


<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.rich-media-node {
  width: 180px;
  padding: 8px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  color: white;
  background-color: #f7c616;
  border-radius: 4px;
}

.settings ul {
  list-style: none;
  line-height: 33px;
}

.settings ul ul li {
  border-bottom: 1px solid #c1bbbb;
}

.main {
  background: #efefef;
  padding: 14px 11px 17px 16px;
  margin-top: 20px;
  margin-right: 47px;
}
</style>