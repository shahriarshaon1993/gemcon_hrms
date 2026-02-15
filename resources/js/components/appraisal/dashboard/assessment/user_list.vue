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
                    <li class="breadcrumb-item active">Evaluation Questions</li>
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
                      <h4 class="card-title">Evaluate </h4>
                    </div>
                    <div class="card-content">
                      <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12 col-sm-12 col-lg-12">
                            <!-- Section Heading-->
                            <div
                              class="section_heading text-center wow fadeInUp"
                              data-wow-delay="0.2s"
                              style="
                                visibility: visible;
                                animation-delay: 0.2s;
                                animation-name: fadeInUp;
                              "
                            >
                              <h3>Our Creative <span> Team</span></h3>
                              <!-- <p>
                                Appland is completely creative, lightweight,
                                clean &amp; super responsive app landing page.
                              </p> -->
                              <div class="line"></div>
                            </div>
                          </div>
                        </div>
                        <div class="row" style="width: 100%">
                          <!-- Single Advisor-->

                          <div
                            class="
                              col-3 col-sm-3 col-lg-3
                              animate__animated animate__fadeInUp
                            "
                            :key="index"
                            v-for="(row, index) in this.laravelData.data"
                            :style="
                              'animation-duration: calc(0.2s * ' + index + ')'
                            "
                          >
                            <router-link
                              :to="{ path: '/assessment/' + row.id }"
                            >
                              <div class="single_advisor_profile">
                                <!-- Team Thumb-->
                                <div class="advisor_thumb">
                                  <img
                                    v-if="row.employee_image"
                                    height="320px"
                                    :src="'images/' + row.employee_image"
                                    @error="imageUrlAlt"
                                  />
                                  <!-- <img
                                  v-else
                                  src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                  alt=""
                                /> -->
                                  <!-- Social Info-->
                                  <div class="social-info">
                                    <a href="#"
                                      ><i class="fa fa-facebook"></i></a
                                    ><a href="#"
                                      ><i class="fa fa-twitter"></i></a
                                    ><a href="#"
                                      ><i class="fa fa-linkedin"></i
                                    ></a>
                                  </div>
                                </div>
                                <!-- Team Details-->
                                <div class="single_advisor_details_info">
                                  <h6>
                                    {{ row.employee_fullname }}({{
                                      row.employee_number
                                    }})
                                  </h6>
                                  <p class="designation">
                                    {{ row.designation_name }}
                                  </p>
                                  <p class="designation">
                                    {{ row.department_name }}
                                  </p>
                                </div>
                              </div>
                            </router-link>
                          </div>
                        </div>
                        <div style="padding-left: 10px">
                          <pagination
                            :data="laravelData"
                            :limit="3"
                            @pagination-change-page="getResults"
                          ></pagination>
                        </div>
                      </div>
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
      items: [],
      search: "",
      laravelData: {},
      save_items: [],
      item: [],
      base_url: window.base_url,
      api_url: window.api_url,
      user_data: JSON.parse(this.$localStorage.get("user")).data,

      addForm: new Form({ items: [] }),
    };
  },
  created() {
    this.getResults();
  },
  methods: {
    imageUrlAlt(event) {
      event.target.src = "images/default.png";
    },

    getResults(page = 1) {
      if (this.search != "") {
        this.getData(
          "user_wise_emp?page=" + page + "&search=" + this.search,
          "items"
        ).then(() => {
          this.laravelData = this.items;
        });
      } else if (this.fild_name != null) {
        this.getData(
          "user_wise_emp?paginate=true&page=" +
            page +
            "&" +
            this.fild_name +
            "=" +
            this.fild_data,
          "items"
        ).then(() => {
          this.laravelData = this.items;
        });
      } else {
        this.getData("user_wise_emp?paginate=true&page=" + page, "items").then(
          () => {
            this.laravelData = this.items;
          }
        );
      }
    },
    async getItems() {
      let loader = this.$loading.show();
      try {
        await axios
          .get(this.api_url + "user_wise_emp", {
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
        this.addForm.items = this.items;
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
.single_advisor_profile img {
  max-width: 100%;
  object-fit: cover;
  object-position: top;
  transition: all 0.4s;
}
.single_advisor_profile img:hover {
  transform: scale(1.2);
}
.single_advisor_profile {
  position: relative;
  margin-bottom: 50px;
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
  z-index: 1;
  border-radius: 15px;
  -webkit-box-shadow: 0 0.25rem 1rem 0 rgba(47, 91, 234, 0.125);
  box-shadow: 0 0.25rem 1rem 0 rgba(47, 91, 234, 0.125);
}
.single_advisor_profile .advisor_thumb {
  position: relative;
  z-index: 1;
  border-radius: 15px 15px 0 0;
  margin: 0 auto;
  /* padding: 30px 30px 0 30px; */
  background-color: #e7e7e7;
  overflow: hidden;
}
.single_advisor_profile .advisor_thumb::after {
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
  position: absolute;
  width: 150%;
  height: 80px;
  bottom: -45px;
  left: -25%;
  content: "";
  background-color: #ffffff;
  -webkit-transform: rotate(-15deg);
  transform: rotate(-15deg);
}
@media only screen and (max-width: 575px) {
  .single_advisor_profile .advisor_thumb::after {
    height: 160px;
    bottom: -90px;
  }
}
.single_advisor_profile .advisor_thumb .social-info {
  position: absolute;
  z-index: 1;
  width: 100%;
  bottom: 0;
  right: 30px;
  text-align: right;
}
.single_advisor_profile .advisor_thumb .social-info a {
  font-size: 14px;
  color: #020710;
  padding: 0 5px;
}
.single_advisor_profile .advisor_thumb .social-info a:hover,
.single_advisor_profile .advisor_thumb .social-info a:focus {
  color: #e7e7e7;
}
.single_advisor_profile .advisor_thumb .social-info a:last-child {
  padding-right: 0;
}
.single_advisor_profile .single_advisor_details_info {
  position: relative;
  z-index: 1;
  padding: 30px;
  text-align: right;
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
  border-radius: 0 0 15px 15px;
  background-color: #ffffff;
}
.single_advisor_profile .single_advisor_details_info::after {
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
  position: absolute;
  z-index: 1;
  width: 50px;
  height: 3px;
  background-color: #e7e7e7;
  content: "";
  top: 12px;
  right: 30px;
}
.single_advisor_profile .single_advisor_details_info h6 {
  margin-bottom: 0.25rem;
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
}
@media only screen and (min-width: 768px) and (max-width: 991px) {
  .single_advisor_profile .single_advisor_details_info h6 {
    font-size: 14px;
  }
}
.single_advisor_profile .single_advisor_details_info p {
  -webkit-transition-duration: 500ms;
  transition-duration: 500ms;
  margin-bottom: 0;
  font-size: 14px;
}
@media only screen and (min-width: 768px) and (max-width: 991px) {
  .single_advisor_profile .single_advisor_details_info p {
    font-size: 12px;
  }
}
.single_advisor_profile:hover .advisor_thumb::after,
.single_advisor_profile:focus .advisor_thumb::after {
  background-color: #f19500;
}
.single_advisor_profile:hover .advisor_thumb .social-info a,
.single_advisor_profile:focus .advisor_thumb .social-info a {
  color: #ffffff;
}
.single_advisor_profile:hover .advisor_thumb .social-info a:hover,
.single_advisor_profile:hover .advisor_thumb .social-info a:focus,
.single_advisor_profile:focus .advisor_thumb .social-info a:hover,
.single_advisor_profile:focus .advisor_thumb .social-info a:focus {
  color: #ffffff;
}
.single_advisor_profile:hover .single_advisor_details_info,
.single_advisor_profile:focus .single_advisor_details_info {
  background-color: #f19500;
}
.single_advisor_profile:hover .single_advisor_details_info::after,
.single_advisor_profile:focus .single_advisor_details_info::after {
  background-color: #ffffff;
}
.single_advisor_profile:hover .single_advisor_details_info h6,
.single_advisor_profile:focus .single_advisor_details_info h6 {
  color: #ffffff;
}
.single_advisor_profile:hover .single_advisor_details_info p,
.single_advisor_profile:focus .single_advisor_details_info p {
  color: #ffffff;
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