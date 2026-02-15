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
                    <li class="breadcrumb-item active">
                      MOS (Measure of Success)
                    </li>
                  </ol>
                </div>
              </div>
              <div class="col-sm-3">
                <a class="btn btn-primary add-btn" @click="show_pop()">
                  <i class="bx bx-add-alt"></i> Add New MOS
                </a>
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
                        <table
                          class="table table-bordered table-striped table-sm"
                        >
                          <tbody>
                            <tr>
                              <th class="text-left" width="15%">
                                <strong>KRA</strong>
                              </th>
                              <th class="text-left">
                                <strong>{{
                                  item.krajoin ? item.krajoin.kra_name : ""
                                }}</strong>
                              </th>
                              <th class="text-left" width="15%">
                                <strong>KRA WEIGHTAGE</strong>
                              </th>
                              <th class="text-left">
                                <strong>{{
                                  item.krajoin ? item.krajoin.kra_weight : ""
                                }}</strong>
                              </th>
                            </tr>
                            <tr>
                              <th class="text-left"><strong>KPI</strong></th>
                              <th class="text-left">
                                <strong>{{ item.kpi_name }}</strong>
                              </th>
                              <th class="text-left">
                                <strong>KPI WEIGHTAGE</strong>
                              </th>
                              <th class="text-left">
                                <strong>{{ item.kpi_weight }}</strong>
                              </th>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-bordered table-sm">
                          <template v-for="mos_item in item.mosjoin">
                            <tr class="thead-dark">
                              <th colspan="13" class="text-center">
                                {{ mos_item.mos_name }}
                              </th>
                            </tr>
                            <tr>
                              <td>MOS</td>
                              <td colspan="2">
                                <input
                                  type="text"
                                  v-model="mos_item.mos_name"
                                  class="form-control"
                                />
                              </td>
                              <td colspan="1">
                                <input
                                  type="radio"
                                  value="0"
                                  v-model="mos_item.mos_calculation"
                                />
                                <label for="normal0">Normal</label><br />
                              </td>
                              <td colspan="1">
                                <input
                                  type="radio"
                                  value="1"
                                  v-model="mos_item.mos_calculation"
                                />
                                <label for="reverse0">Reverse</label><br />
                              </td>
                              <td colspan="1">
                                <input
                                  type="radio"
                                  value="2"
                                  v-model="mos_item.mos_calculation"
                                />
                                <label for="avg0">Avg</label><br />
                              </td>
                              <td colspan="1">
                                <input
                                  type="radio"
                                  value="3"
                                  v-model="mos_item.mos_calculation"
                                />
                                <label for="avgrev0">Avg&amp;Rev</label><br />
                              </td>
                              <td>TARGET</td>
                              <td colspan="1">
                                <label class="form-control number">{{
                                  target(
                                    mos_item.mostargetjoin,
                                    mos_item.mos_calculation
                                  )
                                }}</label>
                              </td>
                              <td>WEIGHTAGE</td>
                              <td>
                                <input
                                  type="text"
                                  @keypress="onlyNumber"
                                  v-model="mos_item.weightage"
                                  class="form-control number"
                                />
                              </td>
                              <td>
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    value="0"
                                    v-model="mos_item.isvalorper"
                                  />
                                  <label for="val_0">Val</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control custom-radio">
                                  <input
                                    type="radio"
                                    value="1"
                                    v-model="mos_item.isvalorper"
                                  />
                                  <label for="per_0">Per</label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div class="custom-control"></div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Jan_0_1">Jan</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Feb_0_2">Feb</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Mar_0_3">Mar</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Apr_0_4">Apr</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="May_0_5">May</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Jun_0_6">Jun</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Jul_0_7">Jul</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Aug_0_8">Aug</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Sep_0_9">Sep</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Oct_0_10">Oct</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Nov_0_11">Nov</label>
                                </div>
                              </td>
                              <td>
                                <div class="custom-control">
                                  <label for="Dec_0_12">Dec</label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label>MONTHLY TARGET</label>
                                <p style="color: red"></p>
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.january"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target_0_1
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.february"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target_0_2
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.march"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target_0_3
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.april"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target_0_4
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.may"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target_0_5
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.june"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target_0_6
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.july"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target target_0_7
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.august"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target target_0_8
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.september"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target target_0_9
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.october"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target target_0_10
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.november"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target target_0_11
                                  "
                                />
                              </td>
                              <td>
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mostargetjoin.december"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    month_val0
                                    target_0 target target_0_12
                                  "
                                />
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label>MONTHLY Module</label>
                                <p style="color: red"></p>
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.january"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module_0_1
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.february"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module_0_2
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.march"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module_0_3
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.april"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module_0_4
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.may"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module_0_5
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.june"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module_0_6
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.july"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module module_0_7
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.august"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module module_0_8
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.september"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module module_0_9
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.october"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module module_0_10
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.november"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module module_0_11
                                  "
                                />
                              </td>
                              <td v-if="mos_item.mosmodulejoin">
                                <input
                                  @keypress="onlyNumber"
                                  v-model="mos_item.mosmodulejoin.december"
                                  type="text"
                                  class="
                                    number
                                    form-control
                                    module_val0 module_0 module module_0_12
                                  "
                                />
                              </td>
                            </tr>
                          </template>
                        </table>
                        <div class="row">
                          <div class="col-12 text-right">
                            <button
                              @click="updateMOS()"
                              class="btn btn-success"
                            >
                              Update
                            </button>
                          </div>
                          <br />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <modal
            width="60%"
            height="70%"
            style="padding: 50px"
            name="popup-singel"
          >
            <i @click="hide_pop()" class="bx bx-x-circle x-circle"></i>
            <div class="app-content">
              <div class="card">
                <table class="table table-bordered table-striped table-sm">
                  <tbody>
                    <tr>
                      <th colspan="2" class="text-center" width="15%">
                        <strong>KRA</strong>
                      </th>
                    </tr>
                    <tr>
                      <th class="text-center" width="15%">
                        <strong>Name</strong>
                      </th>
                      <th class="text-center" width="15%">
                        <strong>Weightage</strong>
                      </th>
                    </tr>
                    <tr>
                      <th class="text-center">
                        {{ item.krajoin ? item.krajoin.kra_name : "" }}
                      </th>
                      <th class="text-center">
                        {{ item.krajoin ? item.krajoin.kra_weight : "" }}
                      </th>
                    </tr>
                    <tr>
                      <th colspan="2" class="text-center" width="15%">
                        <strong>KPI</strong>
                      </th>
                    </tr>
                    <tr>
                      <th class="text-center">{{ item.kpi_name }}</th>
                      <th class="text-center">{{ item.kpi_weight }}</th>
                    </tr>
                    <tr>
                      <th colspan="2" class="text-center" width="15%">
                        <strong>KPI</strong>
                      </th>
                    </tr>
                    <tr>
                      <th class="text-center">{{ item.kpi_name }}</th>
                      <th class="text-center">{{ item.kpi_weight }}</th>
                    </tr>
                    <tr>
                      <th colspan="2" class="text-center" width="15%">
                        <strong>MOS</strong>
                      </th>
                    </tr>
                    <tr>
                      <th class="text-center">
                        <input
                          class="form-control text-center"
                          placeholder="MOS Name"
                          v-model="addForm.mos_name"
                        />
                      </th>
                      <th class="text-center">
                        <button @click="addMOS()" class="btn btn-success">
                          Save
                        </button>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </modal>
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
      kpi_id: this.$route.params.id,
      base_url: window.base_url,
      api_url: window.api_url,
      token: this.$localStorage.get("d_token"),
      item: [],
      status: "",
      updateForm: new Form({
        arrayData: "",
      }),
      addForm: new Form({
        mos_name: "",
        weightage: 0,
      }),
    };
  },
  created() {
    this.getItems();
  },
  methods: {
    hide_pop() {
      this.$modal.hide("popup-singel");
    },
    show_pop() {
      this.$modal.show("popup-singel");
    },
    target(mos_item, mos_calculation) {
      if (mos_calculation == 2 || mos_calculation == 3) {
        if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0 &&
          mos_item.may > 0 &&
          mos_item.june > 0 &&
          mos_item.july > 0 &&
          mos_item.august > 0 &&
          mos_item.september > 0 &&
          mos_item.october > 0 &&
          mos_item.november > 0 &&
          mos_item.december > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april) +
              Number(mos_item.may) +
              Number(mos_item.june) +
              Number(mos_item.july) +
              Number(mos_item.august) +
              Number(mos_item.september) +
              Number(mos_item.october) +
              Number(mos_item.november) +
              Number(mos_item.december)) /
            12
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0 &&
          mos_item.may > 0 &&
          mos_item.june > 0 &&
          mos_item.july > 0 &&
          mos_item.august > 0 &&
          mos_item.september > 0 &&
          mos_item.october > 0 &&
          mos_item.november > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april) +
              Number(mos_item.may) +
              Number(mos_item.june) +
              Number(mos_item.july) +
              Number(mos_item.august) +
              Number(mos_item.september) +
              Number(mos_item.october) +
              Number(mos_item.november)) /
            11
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0 &&
          mos_item.may > 0 &&
          mos_item.june > 0 &&
          mos_item.july > 0 &&
          mos_item.august > 0 &&
          mos_item.september > 0 &&
          mos_item.october > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april) +
              Number(mos_item.may) +
              Number(mos_item.june) +
              Number(mos_item.july) +
              Number(mos_item.august) +
              Number(mos_item.september) +
              Number(mos_item.october)) /
            10
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0 &&
          mos_item.may > 0 &&
          mos_item.june > 0 &&
          mos_item.july > 0 &&
          mos_item.august > 0 &&
          mos_item.september > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april) +
              Number(mos_item.may) +
              Number(mos_item.june) +
              Number(mos_item.july) +
              Number(mos_item.august) +
              Number(mos_item.september)) /
            9
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0 &&
          mos_item.may > 0 &&
          mos_item.june > 0 &&
          mos_item.july > 0 &&
          mos_item.august > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april) +
              Number(mos_item.may) +
              Number(mos_item.june) +
              Number(mos_item.july) +
              Number(mos_item.august)) /
            8
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0 &&
          mos_item.may > 0 &&
          mos_item.june > 0 &&
          mos_item.july > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april) +
              Number(mos_item.may) +
              Number(mos_item.june) +
              Number(mos_item.july)) /
            7
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0 &&
          mos_item.may > 0 &&
          mos_item.june > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april) +
              Number(mos_item.may) +
              Number(mos_item.june)) /
            6
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0 &&
          mos_item.may > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april) +
              Number(mos_item.may)) /
            5
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0 &&
          mos_item.april > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march) +
              Number(mos_item.april)) /
            4
          );
        } else if (
          mos_item.january > 0 &&
          mos_item.february > 0 &&
          mos_item.march > 0
        ) {
          return (
            (Number(mos_item.january) +
              Number(mos_item.february) +
              Number(mos_item.march)) /
            3
          );
        } else if (mos_item.january > 0 && mos_item.february > 0) {
          return (Number(mos_item.january) + Number(mos_item.february)) / 2;
        } else if (mos_item.january > 0) {
          return Number(mos_item.january) / 1;
        }
      } else {
        return (
          Number(mos_item.january) +
          Number(mos_item.february) +
          Number(mos_item.march) +
          Number(mos_item.april) +
          Number(mos_item.may) +
          Number(mos_item.june) +
          Number(mos_item.july) +
          Number(mos_item.august) +
          Number(mos_item.september) +
          Number(mos_item.october) +
          Number(mos_item.november) +
          Number(mos_item.december)
        );
      }
    },
    onlyNumber($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
        // 46 is dot
        $event.preventDefault();
      }
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
    updateMOS() {
      try {
        let loader = this.$loading.show();
        this.updateForm.arrayData = this.item;
        this.updateForm
          .post(this.api_url + "mos_update", {
            headers: {
              "Content-Type": "application/json",
              Authorization: this.token ? `Bearer ${this.token}` : "",
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
            }
            loader.hide();
          });
      } catch (error) {
        console.log(error);
      }
      console.log(this.item);
    },
    addMOS() {
      try {
        let loader = this.$loading.show();
        this.addForm.kra_id = this.item.krajoin.id;
        this.addForm.kpi_id = this.item.id;
        this.addForm.dept_id = this.item.dept_id;
        this.addForm
          .post(this.api_url + "m_o_s", {
            headers: {
              "Content-Type": "application/json",
              Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then((res) => {
            console.log(res);
            if (res.data.success) {
              this.hide_pop();
              this.getItems();
              this.$toasted.show(res.data.message, {
                theme: "bubble",
                duration: 5000,
                position: "bottom-right",
              });
            }
            loader.hide();
          });
      } catch (error) {
        console.log(error);
      }
      console.log(this.item);
    },
    async getItems() {
      let loader = this.$loading.show();
      try {
        await axios
          .get(this.api_url + "k_p_i_s/" + this.kpi_id, {
            headers: {
              "Content-Type": "application/json",
              Authorization: this.token ? `Bearer ${this.token}` : "",
            },
          })
          .then(({ data }) => {
            if (data.success) {
              this.item = data.data;
              console.log(this.item);
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
 
 