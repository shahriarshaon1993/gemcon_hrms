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
                    <li class="breadcrumb-item active">Assessment Questions</li>
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
                      <h4 class="card-title">Assessment</h4>
                    </div>
                    <div class="card-content">
                      <form @submit.prevent="create()">
                        <div
                          class="card-body"
                          v-if="Object.keys(items).length > 0"
                        >
                          <label
                            class="text-gray-600 font-semibold text-lg"
                          ></label>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="controls">
                                  <div id="quizcontainer">
                                    <!-- <h3>Question 2 of 40:</h3> -->

                                    <div
                                      style="position: relative; width: 100%"
                                    >
                                      <div
                                        id="altcontainer"
                                        class="notranslate"
                                      >
                                        <template
                                          v-for="(value, index) in items"
                                        >
                                          <div :key="index" class="qusdes">
                                            <h4>
                                              <span id="qtext">
                                                {{ value.vQuestion }}
                                              </span>
                                            </h4>
                                            <label
                                              :key="index2"
                                              v-for="(
                                                item, index2
                                              ) in value.answersjoin"
                                              class="
                                                radiocontainer
                                                animate__animated
                                                animate__fadeInRight
                                              "
                                              :id="'label2' + index"
                                              :style="
                                                'animation-duration: calc(0.2s * ' +
                                                index +
                                                ')'
                                              "
                                            >
                                              {{ item.vAnswer
                                              }}<input
                                                type="radio"
                                                v-model="value.value"
                                                :name="'mcq_' + index"
                                                :value="item.id"
                                                required
                                              /><span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </template>
                                      </div>
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
                        <div
                          class="card-body"
                          v-else>
                          <p>No Assessment Questions or not assigned MOS</p>
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
export default {
  props: {},
  components: {},
  data() {
    return {
      itemsData: [],
      user_id: this.$route.params.user_id,
      items: [],
      save_items: [],
      item: [],
      base_url: window.base_url,
      api_url: window.api_url,
      user_data: JSON.parse(this.$localStorage.get("user")).data,

      addForm: new Form({
        items: [],
        user_id: 0,
      }),
    };
  },
  created() {
    this.getItems();
  },
  methods: {
    seccal(val) {
      console.log(val);
      if (val < 9) {
        return val;
      } else {
        return 1 + "." + val;
      }
    },
    async getItems() {
      let loader = this.$loading.show();
      try {
        await axios
          .get(this.api_url + "jd_qus/" + this.user_id, {
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
    create() {
      // let loader = this.$loading.show();
      try {
        this.addForm.user_id = this.user_id;
        this.addForm.items = this.items;
        this.addForm
          .post(this.api_url + "user_answers", {
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
#qtext {
  /* border-bottom: 1px solid #38393a42; */
}
.qusdes {
  margin-bottom: 20px;
  border-left: 2px solid #5a8deef0;
  padding-left: 20px;
}
.radiocontainer input:checked ~ .checkmark {
  background-color: #2196f3;
}
.radiocontainer {
  background-color: #8ac9a31f;
  display: block;
  position: relative;
  padding: 10px 10px 10px 50px;
  margin-bottom: 5px;
  cursor: pointer;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  word-wrap: break-word;
  border-radius: 20px;
}
.radiocontainer input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}
.checkmark {
  position: absolute;
  top: 10px;
  left: 15px;
  height: 19px;
  width: 19px;
  background-color: #fff;
  border-radius: 50%;
}
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