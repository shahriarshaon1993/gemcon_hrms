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
                      <router-link :to="{ path: '/' }"><i class="bx bx-home-alt"></i>
                      </router-link>
                    </li>
                    <li class="breadcrumb-item active"> KRA , KPI and MOS
                    </li>
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
                <div class="col-md-12" style="padding:0px;">
                    <div class="row report-box">    
                       <div class="form-group col-md-3" >
                          <label class="col-md-12 control-label" style="padding: 0px;">SBU <sup style="color:red; top: -2px;">*</sup></label>
                          <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                             <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="sbu_name_value" :options="sbuSelect2Aarry" @select="employeesSbu" placeholder="Select one" label="text" track-by="text"></vue-select>
                            </div>
                          </div>
                       </div>
                       <div class="form-group col-md-3" >
                          <label class="col-md-12 control-label" style="padding:0px;">Unit</label>
                          <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                             <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="unit_value" :options="unitSelect2Aarry" @select="employeesUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                            </div>
                          </div>
                       </div>
                       <div class="form-group col-md-3" >
                          <label class="col-md-12 control-label" style="padding:0px;">Sub Unit</label>
                          <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                             <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="sub_unit_value" :options="subUnitSelect2Aarry" @select="employeesSubUnit" placeholder="Select one" label="text" track-by="text"></vue-select>
                            </div>
                          </div>
                       </div>

                       <div class="form-group col-md-3" >
                          <label class="col-md-12 control-label" style="padding:0px;">Department</label>
                          <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                             <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="department_name_value" :options="departmentSelect2Aarry" @select="onSelectDepartment" placeholder="Select one" label="text" track-by="text"></vue-select>
                            </div>
                          </div>
                       </div>
                       <div class="form-group col-md-3" >
                          <label class="col-md-12 control-label" style="padding:0px;">Section</label>
                          <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                             <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="section_value" :options="sectionSelect2Aarry" @select="employeesSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                            </div>
                          </div>
                       </div>
                       <div class="form-group col-md-3" >
                          <label class="col-md-12 control-label" style="padding:0px;">Sub Section</label>
                          <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                             <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                              <vue-select v-model="sub_section_value" :options="subSectionSelect2Aarry" @select="employeesSubSection" placeholder="Select one" label="text" track-by="text"></vue-select>
                            </div>
                          </div>
                       </div>
                       <div class="form-group col-md-3"  >
                          <label class="col-md-12 control-label" style="padding:0px;">Work Loc.</label>
                          <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                             <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                              <vue-select v-model="work_location_value" :options="workLocationSelect2Aarry" @select="employeesWorkLocation" placeholder="Select one" label="text" track-by="text"></vue-select>
                            </div>
                          </div>
                       </div>

                        <div class="form-group col-md-3" >
                           <label class="col-md-6 control-label" style="padding:0px;">Employee</label>
                           <div class="col-md-12 inputGroupContainer" style="padding:0px;">
                              <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                               <vue-select v-model="employee_name_value" :options="employeeSelect2Aarry" @select="onSelectEmployee" placeholder="Select one" label="text" track-by="text"></vue-select>
                             </div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 ">
                  <div class="form-inline justify-content-center row" style="padding-top: 10px;">
                    <label class="mb-2 mr-sm-2 col-1">Show <strong>KRA</strong> <input type="checkbox" checked=""
                        value="1" v-model="filterForm.show_kra"></label>
                    <label class="mb-2 mr-sm-2 col-1">Show <strong>KPI</strong> <input type="checkbox" checked=""
                        value="1" v-model="filterForm.show_kpi"></label>
                    <label class="mb-2 mr-sm-2 col-1">Show <strong>MOS</strong> <input type="checkbox" checked=""
                        value="1" v-model="filterForm.show_mos"></label>
                    <label class="mb-2 mr-sm-2 col-1">Show <strong>Y.Achi.%</strong> <input type="checkbox" value="1"
                        v-model="filterForm.show_yachi"></label>
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-2">
                  <label for="users-list-verified">Quarter </label>
                  <fieldset class="form-group">
                    <select class="form-control" v-model="filterForm.quarter" id="users-list-verified">
                      <option>All</option>
                      <option v-for="row in quarter_months" :key="row.id" :value="row.id">
                        {{ row.name }}
                      </option>
                      <option value="5">1st Half yearly</option>
                      <option value="6">2nd Half yearly</option>
                    </select>
                  </fieldset>
                </div>
                <div class="col-12 col-sm-6 col-lg-2">
                  <label for="users-list-verified">Month </label>
                  <fieldset class="form-group">
                    <select class="form-control" v-model="filterForm.month" v-on:change="monthChange()"
                      id="users-list-verified">
                      <option>All</option>
                      <option v-for="row in months" :key="row.id" :value="row.id">{{
                        row.name
                        }}
                      </option>
                    </select>
                  </fieldset>
                </div> <!-- && deptItems.length > 1-->
                <div
                  v-if="deptItems.length > 0"
                  class="col-12 col-sm-6 col-lg-2">
                  <label for="users-list-verified">Department</label>
                  <fieldset class="form-group">
                    <select v-on:change="getKRA()" class="form-control" v-model="filterForm.dept_id"
                      id="users-list-verified">
                      <option>Select One</option>
                      <option v-for="row in deptItems" :key="row.id" :value="row.id">
                        {{ row.department_name }}
                      </option>
                    </select>
                  </fieldset>
                </div>
                <div class="col-12 col-sm-6 col-lg-2">
                  <label for="Profession">KRA</label>
                  <fieldset class="form-group">
                    <div class="controls">
                      <select id="Profession" name="kra_id" v-on:change="getKpi()" v-model="filterForm.kra_id"
                        class="form-control">
                        <option>Select one</option>
                        <option v-for="row in kraItem" :key="row.id" :value="row.id">
                          {{ row.kra_name }}
                        </option>
                      </select>
                    </div>
                  </fieldset>
                </div>
                <div class="col-12 col-sm-6 col-lg-2">
                  <label for="Profession">KPI</label>
                  <fieldset class="form-group">
                    <div class="controls">
                      <select id="Profession" name="kpi_id" v-on:change="getItems()" v-model="filterForm.kpi_id"
                        class="form-control">
                        <option>Select one</option>
                        <option v-for="row in kpiItem" :key="row.id" :value="row.id">
                          {{ row.kpi_name }}
                        </option>
                      </select>
                    </div>
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
                              <th v-if="filterForm.show_kra==1">KRA</th>
                              <th v-if="filterForm.show_kra==1">Weightage</th>
                              <th v-if="filterForm.show_kpi==1">KPI</th>
                              <th v-if="filterForm.show_mos==1">MOS</th>
                              <th>{{
                                filterForm.month != '' ? 'm.Target' : filterForm.quarter == 1 || filterForm.quarter == 2
                                || filterForm.quarter == 3 || filterForm.quarter == 4 ? 'Q.Target' : filterForm.quarter
                                == 5 || filterForm.quarter == 6 ? 'H.Target' : 'Y.Target'
                                }}
                              </th>
                              <th>{{
                                filterForm.month != '' ? 'm.Achi' : filterForm.quarter == 1 || filterForm.quarter == 2
                                || filterForm.quarter == 3 || filterForm.quarter == 4 ? 'Q.Achi' : filterForm.quarter ==
                                5 || filterForm.quarter == 6 ? 'H.Achi' : 'Y.Achi'
                                }}
                              </th>
                              <th v-if="filterForm.show_yachi==1">{{
                                filterForm.month != '' ? 'm.Achieve.%' : filterForm.quarter == 1 || filterForm.quarter
                                == 2 || filterForm.quarter == 3 || filterForm.quarter == 4 ? 'Q.Achieve.%' :
                                filterForm.quarter == 5 || filterForm.quarter == 6 ? 'H.Achieve%' : 'Y.Achieve.%'
                                }}
                              </th>
                              <th v-if="select_months('jan')">Jan</th>
                              <th v-if="select_months('feb')">Feb</th>
                              <th v-if="select_months('mar')">Mar</th>
                              <th v-if="select_months('apr')">Apr</th>
                              <th v-if="select_months('may')">May</th>
                              <th v-if="select_months('jun')">Jun</th>
                              <th v-if="select_months('jul')">Jul</th>
                              <th v-if="select_months('aug')">Aug</th>
                              <th v-if="select_months('sep')">Sep</th>
                              <th v-if="select_months('oct')">Oct</th>
                              <th v-if="select_months('nov')">Nov</th>
                              <th v-if="select_months('dec')">Dec</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <template v-for="(item , index ) in items" :key="item.id">

                              <tr :class="index">

                                <td :rowspan="rowVisible(index,item,'kra')"
                                  v-if="filterForm.show_kra==1 && (items[index > 0 ? index - 1 : 0 ].kra_id != item.kra_id || index ==0)">
                                  {{ item.krajoin ? item.krajoin.kra_name : '' }}
                                  <strong>(T-{{
                                    kraTotalTarget(item.kra_id, 'target')
                                    }}/A-{{
                                    kraTotalTarget(item.kra_id, 'achievement')
                                    }})</strong>
                                </td>
                                <td :rowspan="rowVisible(index,item,'kra')"
                                  v-if="filterForm.show_kra==1 && (items[index > 0 ? index - 1 : 0 ].kra_id != item.kra_id || index ==0)">
                                  {{ item.krajoin ? item.krajoin.kra_weight : '' }}
                                </td>
                                <td :rowspan="rowVisible(index,item,'kpi')"
                                  v-if="filterForm.show_kpi==1 && (items[index > 0 ? index - 1 : 0 ].kpi_id != item.kpi_id || index ==0)">
                                  {{ item.kpijoin ? item.kpijoin.kpi_name : '' }}
                                  (T-{{
                                  kpiTotalTarget(item.kpi_id, 'target')
                                  }}/A-{{ kpiTotalTarget(item.kpi_id, 'achievement') }})
                                </td> 
                                <td v-if="filterForm.show_mos==1">{{ item.mos_name }}
                                  (W-{{ item.weightage }})
                                  (T-{{
                                  mosTotalTarget(item, 'target')
                                  }}/A-{{ mosTotalTarget(item, 'achievement') }})
                                </td>
                                <td
                                  v-bind:class=" achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) >  100 ? 'gb_color_green': achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) <  100  && achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  Number(targetTotal(item)).toFixed(2)
                                  }}{{ item.isvalorper == 1 ? '%' : '' }}
                                </td>
                                <td
                                  v-bind:class=" achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) >  100 ? 'gb_color_green': achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) <  100  && achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  Number(achievementjoinTotal(item)).toFixed(2)
                                  }}{{ item.isvalorper == 1 ? '%' : '' }}
                                </td>
                                <td
                                  v-bind:class=" achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) >  100 ? 'gb_color_green': achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) <  100  && achievementTotal(item ,targetTotal(item), achievementjoinTotal(item)) > 0 ? 'gb_color_yellow' : ''"
                                  v-if="filterForm.show_yachi==1">
                                  {{
                                  achievementTotal(item, targetTotal(item), achievementjoinTotal(item))
                                  }}%
                                </td>
                                <td v-if="select_months('jan')"
                                  v-bind:class=" achievement(item , 'january') >  100 ? 'gb_color_green': achievement(item , 'january') <  100  && achievement(item , 'january') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'january') > 0 ? achievement(item, 'january') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'january') == 0 && item.mostargetjoin ? item.mostargetjoin.january : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(1) == 'red' ? 'color_red': '' "></i>
                                </td>
                                <td v-if="select_months('feb')"
                                  v-bind:class=" achievement(item , 'february') >  100 ? 'gb_color_green': achievement(item , 'february') <  100  && achievement(item , 'february') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'february') > 0 ? achievement(item, 'february') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'february') == 0 && item.mostargetjoin ? item.mostargetjoin.february : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(2) == 'red' ? 'color_red': '' "></i>
                                </td>
                                <td v-if="select_months('mar')"
                                  v-bind:class=" achievement(item , 'march') >  100 ? 'gb_color_green': achievement(item , 'march') <  100  && achievement(item , 'march') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'march') > 0 ? achievement(item, 'march') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'march') == 0 && item.mostargetjoin ? item.mostargetjoin.march : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(3) == 'red' ? 'color_red': '' "></i>
                                </td>
                                <td v-if="select_months('apr')"
                                  v-bind:class=" achievement(item , 'april') >  100 ? 'gb_color_green': achievement(item , 'april') <  100  && achievement(item , 'april') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'april') > 0 ? achievement(item, 'april') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'april') == 0 && item.mostargetjoin ? item.mostargetjoin.april : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(4) == 'red' ? 'color_red': '' "></i>
                                </td>
                                <td v-if="select_months('may')"
                                  v-bind:class=" achievement(item , 'may') >  100 ? 'gb_color_green': achievement(item , 'may') <  100  && achievement(item , 'may') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'may') > 0 ? achievement(item, 'may') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'may') == 0 && item.mostargetjoin ? item.mostargetjoin.may : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(5) == 'red' ? 'color_red': '' "></i>
                                </td>
                                <td v-if="select_months('jun')"
                                  v-bind:class=" achievement(item , 'june') >  100 ? 'gb_color_green': achievement(item , 'june') <  100  && achievement(item , 'june') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'june') > 0 ? achievement(item, 'june') + '%' : ''
                                  }}

                                  <i v-if="achievement(item , 'june') == 0 && item.mostargetjoin ? item.mostargetjoin.june : 0 > 0 "
                                    class="bx bx-map " v-bind:class=" colorCheck(6) == 'red' ? 'color_red': '' "></i>
                                </td>

                                <td v-if="select_months('jul')"
                                  v-bind:class=" achievement(item , 'july') >  100 ? 'gb_color_green': achievement(item , 'july') <  100  && achievement(item , 'july') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'july') > 0 ? achievement(item, 'july') + '%' : ''
                                  }} 
                                  <i v-if="achievement(item , 'july') == 0 && item.mostargetjoin ? item.mostargetjoin.july : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(7) == 'red' ? 'color_red': '' "></i>
                                </td>
                                <td v-if="select_months('aug')"
                                  v-bind:class=" achievement(item , 'august') >  100 ? 'gb_color_green': achievement(item , 'august') <  100  && achievement(item , 'august') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'august') > 0 ? achievement(item, 'august') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'august') == 0 && item.mostargetjoin ? item.mostargetjoin.august : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(8) == 'red' ? 'color_red': '' "></i>
                                </td>
                                <td v-if="select_months('sep')"
                                  v-bind:class=" achievement(item , 'september') >  100 ? 'gb_color_green': achievement(item , 'september') <  100  && achievement(item , 'september') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'september') > 0 ? achievement(item, 'september') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'september') == 0 && item.mostargetjoin ? item.mostargetjoin.september : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(9) == 'red' ? 'color_red': '' "></i>
                                </td>
                                <td v-if="select_months('oct')"
                                  v-bind:class=" achievement(item , 'october') >  100 ? 'gb_color_green': achievement(item , 'october') <  100  && achievement(item , 'october') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'october') > 0 ? achievement(item, 'october') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'october') == 0 && item.mostargetjoin ? item.mostargetjoin.october : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(10) == 'red' ? 'color_red': '' "></i>
                                </td>

                                <td v-if="select_months('nov')"
                                  v-bind:class=" achievement(item , 'november') >  100 ? 'gb_color_green': achievement(item , 'november') <  100  && achievement(item , 'november') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'november') > 0 ? achievement(item, 'november') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'november') == 0 && item.mostargetjoin ? item.mostargetjoin.november : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(11) == 'red' ? 'color_red': '' "></i>
                                </td>

                                <td v-if="select_months('dec')"
                                  v-bind:class=" achievement(item , 'december') >  100 ? 'gb_color_green': achievement(item , 'december') <  100  && achievement(item , 'december') > 0 ? 'gb_color_yellow' : ''">
                                  {{
                                  achievement(item, 'december') > 0 ? achievement(item, 'december') + '%' : ''
                                  }}
                                  <i v-if="achievement(item , 'december') == 0 && item.mostargetjoin ? item.mostargetjoin.december : 0 > 0 "
                                    class="bx bx-map" v-bind:class=" colorCheck(12) == 'red' ? 'color_red': '' "></i>
                                </td> 
                                <td>
                                  <div class="dropup">
                                    <span
                                      class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right">
                                       <router-link class="dropdown-item"
                                        :to="{ path: '/achievement/'+ item.id+'?quarter='+filterForm.quarter +'&month='+filterForm.month+'&dept_id='+filterForm.dept_id+'&kra_id='+filterForm.kra_id+'&kpi_id='+filterForm.kpi_id}">
                                        <i class="bx bx-edit-alt mr-1"></i>
                                        Achievement
                                      </router-link>
                                      <router-link class="dropdown-item"
                                        :to="{ path: '/bpt_report_details/'+ item.kpi_id }">
                                        <i class="bx bx-edit-alt mr-1"></i> Details
                                      </router-link>
                                      <router-link traget="_blank"
                                        class="dropdown-item" :to="{ path: '/measure_of_success/'+ item.kpi_id }">
                                        <i class="bx bx-edit-alt mr-1"></i> MOS
                                        Edit
                                      </router-link>


                                      <!-- <a @click="comment_show(item)" class="dropdown-item">
                                        <i class="bx bx-comment mr-1">
                                        </i>
                                        Comment
                                      </a>  -->
                                    </div>
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

          <!--FEEDBACK MODAL--->
          <modal height="80%" name="comment" style="padding:50px" width="65%">
            <i @click="comment_hidden()" class="bx bx-x-circle x-circle">
            </i>
            <div class="app-content ">
              <div class="card">
                <section id="dashboard-analytics">
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a @click="tabs('comments')" aria-controls="nav-home" aria-selected="true"
                        class="nav-item nav-link" data-toggle="tab" href="#nav-home" id="nav-home-tab" role="tab"
                        v-bind:class="{ active: comment_active  == 'comments' }">
                        Comments
                      </a>
                      <a @click="tabs('add')" aria-controls="nav-home" aria-selected="true" class="nav-item nav-link"
                        data-toggle="tab" href="#nav-home" id="nav-home-tab" role="tab"
                        v-bind:class="{ active: comment_active  == 'add' }">
                        New Comment
                      </a>
                    </div>
                  </nav>
                </section>
                <form @submit.prevent="task_comment()">
                  <table class="table table-bordered table-striped table-sm">
                    <tbody v-if="comment_active =='add'">
                      <tr>
                        <th class="text-center" colspan="4">
                          <vue-editor name="task" placeholder="Comment...." v-model="comment_mailForm.msg">
                          </vue-editor>
                        </th>
                      </tr>
                      <tr>
                        <th class="text-center">
                          <div class="form-group">
                            <label for="Profession">
                              Mail CC1
                            </label>
                            <div class="controls">
                              <input class="form-control" placeholder="example1@gmail.com" type="text"
                                v-model="comment_mailForm.mailcc1" />
                            </div>
                          </div>
                        </th>
                        <th class="text-center">
                          <div class="form-group">
                            <label for="Profession">
                              Mail CC3
                            </label>
                            <div class="controls">
                              <input class="form-control" placeholder="example2@gmail.com" type="text"
                                v-model="comment_mailForm.mailcc2" />
                            </div>
                          </div>
                        </th>
                        <th class="text-center">
                          <div class="form-group">
                            <label for="Profession">
                              Mail CC3
                            </label>
                            <div class="controls">
                              <input class="form-control" placeholder="example3@gmail.com" type="text"
                                v-model="comment_mailForm.mailcc3" />
                            </div>
                          </div>
                        </th>
                        <th class="text-center">
                          <button class="btn btn-success">
                            Save
                          </button>
                        </th>
                      </tr>
                    </tbody>
                    <tbody v-if="comment_active =='comments'">
                      <tr class="text-center">
                        <th>
                          Comment
                        </th>
                        <th>
                          User Name
                        </th>
                        <th>
                          Date
                        </th>
                      </tr>
                      <tr :key="index" class="text-center" v-for="(com, index) in feedback">
                        <th>
                          <p v-html="com.msg">
                          </p>
                        </th>
                        <th>
                          {{ com.feedback_user ? com.feedback_user.name : "" }}
                        </th>
                        <th>
                          {{ format_Date(com.created_at) }}
                        </th>
                      </tr>
                    </tbody>
                  </table>
                </form>
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
  // import { VueEditor } from "vue2-editor";

  export default {
    props: {},
    components: {
      // VueEditor
      // VueRecaptcha, facebookLogin
    },
    data() {
      return {
        sbuSelect2Aarry: [],
        unitSelect2Aarry: [],
        subUnitSelect2Aarry: [],
        departmentSelect2Aarry: [],
        sectionSelect2Aarry: [],
        subSectionSelect2Aarry: [],
        workLocationSelect2Aarry: [],
        employeeSelect2Aarry: [],
        base_url: window.base_url,
        api_url: window.api_url,
        token: this.$localStorage.get("d_token"),
        user_data: JSON.parse(this.$localStorage.get("user")).data,
        role_id: '',
        items: [],
        item: [],
        items_all: [],
        deptItems: [],
        quarter: this.$route.query.quarter,
        month: this.$route.query.month,
        dept_id: this.$route.query.dept_id,
        kra_id: this.$route.query.kra_id,
        comment_active: 'comments',
        feedback: '',
        filterForm: new Form({
          dept_id: '',
          kra_id: this.$route.query.kra_id ? this.$route.query.kra_id : '',
          kpi_id: '',
          quarter: this.$route.query.quarter ? this.$route.query.quarter : '',
          month: this.$route.query.month ? this.$route.query.month : '',
          show_kra: 1,
          show_kpi: 1,
          show_mos: 1,
          show_yachi: 1,
        }),

        comment_mailForm: new Form({
          mailcc1: "",
          mailcc2: "",
          mailcc3: "",
          msg: "",
          mos_id: ""
        }),

        status: '',
        kraItem: [],
        kpiItem: [],
        mosItem: [],

        year: this.$localStorage.get('year') ? this.$localStorage.get('year') : new Date().getFullYear(),
      };
    },
    created() {

      // this.role_id = this.user_data.role_id;
      //if (this.role_id == 5 || this.role_id == 6 || this.role_id == 7) {

      // if (this.role_id == 6 || this.role_id == 7 || this.role_id == 5) {
      //   this.filterForm.dept_id = this.user_data.department;
      //   this.getKRA();
      //   this.getItems();
      // } else {
        this.getDept();

        this.getSbuSelect2();
        this.getUnitSelect2();
        this.getSubUnitSelect2();
        this.getDeptSelect2();
        this.getSectionSelect2();
        this.getSubSectionSelect2();
        this.getWorkLocationSelect2();
        this.getEmployeeSelect2();
      // }
      // if (this.filterForm.kra_id) {
      //   this.getKpi();
      // }
      this.filterForm.dept_id =   this.user_data.department ;

    },
    methods: {
      countRow(index, item) {
        console.log(index);
        console.log(item);
        if (this.filterForm.month) {
          return '';
        }
      },
      monthChange() {
        this.items = this.items_all;
        return this.items ;
        // let a = this.items.filter(item => {
        //   //for (let index = 0; index < this.items.length; index++) {
        //   let target = item.mostargetjoin;
        //   //this.items.slice(0, index);
        //   let total = 0;

        //   if (this.filterForm.month == 'jan') {
        //     total = target.january;
        //   } else if (this.filterForm.month == 'feb') {
        //     total = target.february;
        //   } else if (this.filterForm.month == 'mar') {
        //     total = target.march;
        //   } else if (this.filterForm.month == 'apr') {
        //     total = target.april;
        //   } else if (this.filterForm.month == 'may') {
        //     total = target.may;
        //   } else if (this.filterForm.month == 'jun') {
        //     total = target.june;
        //   } else if (this.filterForm.month == 'jul') {
        //     total = target.july;
        //   } else if (this.filterForm.month == 'aug') {
        //     total = target.august;
        //   } else if (this.filterForm.month == 'sep') {
        //     total = target.september;
        //   } else if (this.filterForm.month == 'oct') {
        //     total = target.october;
        //   } else if (this.filterForm.month == 'nov') {
        //     total = target.november;
        //   } else if (this.filterForm.month == 'dec') {
        //     total = target.december;
        //   } else {
        //     total = target.total;
        //   }  
        //   return total > 0; 
        // });  
        //this.items = a;
      },
      rowVisible(index, item, type) {
        let crount = 0;
        this.items.filter(row => {
          if (type == 'kra') {
            if (row.kra_id === item.kra_id) {
              crount += 1;
            }
          } else if (type == 'kpi') {
            if (row.kpi_id === item.kpi_id) {
              crount += 1;
            }
          }

        })
        return crount;
      },
      achievementTotal(item, target, achievement) {
        if (target > 0 && achievement > 0) {

          if (item.mos_calculation == 0) {
            return ((achievement / target) * 100).toFixed();
          } else if (item.mos_calculation == 1) {

            return ((target / achievement) * 100).toFixed(2);

          } else if (item.mos_calculation == 2) {

            return ((achievement / target) * 100).toFixed(2);
          } else if (item.mos_calculation == 3) {

            return ((target / achievement) * 100).toFixed(2);
          } else {
            return ((achievement / target) * 100).toFixed(2);
          }

        } else {
          return 0;
        }
      },
      achievement(item, month) {
        let target = (item.mostargetjoin?item.mostargetjoin[month]:0);
        let achievement = (item.mosachievementjoin?item.mosachievementjoin[month]:0);
        if (target > 0 && achievement > 0) {
          if (item.mos_calculation == 0) {
            return ((achievement / target) * 100).toFixed();
          } else if (item.mos_calculation == 1) {

            return ((target / achievement) * 100).toFixed(2);

          } else if (item.mos_calculation == 2) {

            return ((achievement / target) * 100).toFixed(2);
          } else if (item.mos_calculation == 3) {

            return ((target / achievement) * 100).toFixed(2);
          } else {
            return ((achievement / target) * 100).toFixed(2);
          }
        } else {
          return 0;
        }
      },
      colorCheck(month_id) {
        var currentTime = new Date();
        if(currentTime.getFullYear() >= this.year){
          var month = currentTime.getMonth() + 1;
          if (month_id < month) {
            return 'red';
          }
        }else{
          return false ;
        }
        
      },
      mosTotalTarget(item, type) {
        let g_total = 0;
        //this.items =  this.items_all ;
        //this.items.filter(item => {
        let total = 0;
        let target;

        if (type == 'target') {
          if (item.mostargetjoin) {
            target = item.mostargetjoin;
          } else {
            return 0;
          }

        } else if (type == 'achievement') {
          if (item.mosachievementjoin) {
            target = item.mosachievementjoin;
          } else {
            return 0;
          }

        }

        let q1;
        let q2;
        let q3;
        let q4;
        let q5;
        let q6;
        q1 = target.january + target.february + target.march;
        q2 = target.april + target.may + target.june;
        q3 = target.july + target.august + target.september;
        q4 = target.october + target.november + target.december;
        q5 = q1 + q2;
        q6 = q3 + q4;
        if (this.filterForm.month == '') {
          if (this.filterForm.quarter == 1) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q1;
            } else {
              total = q1 / 3;
            }
          } else if (this.filterForm.quarter == 2) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q2;
            } else {
              total = q2 / 3;
            }
          } else if (this.filterForm.quarter == 3) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q3;
            } else {
              total = q3 / 3;
            }
          } else if (this.filterForm.quarter == 4) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q4;
            } else {
              total = q4 / 3;
            }
          } else if (this.filterForm.quarter == 5) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q5;
            } else {
              total = q5 / 6;
            }

          } else if (this.filterForm.quarter == 6) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q6;
            } else {
              total = q6 / 6;
            }
          } else {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = (q1 + q2 + q3 + q4);
            } else {
              total = (q1 + q2 + q3 + q4) / 12;
            }

            // total =  q1 + q2 + q3+ q4 ;
          }
        } else {


          if (this.filterForm.month == 'jan') {
            total = target.january;
          } else if (this.filterForm.month == 'feb') {
            total = target.february;
          } else if (this.filterForm.month == 'mar') {
            total = target.march;
          } else if (this.filterForm.month == 'apr') {
            total = target.april;
          } else if (this.filterForm.month == 'may') {
            total = target.may;
          } else if (this.filterForm.month == 'jun') {
            total = target.june;
          } else if (this.filterForm.month == 'jul') {
            total = target.july;
          } else if (this.filterForm.month == 'aug') {
            total = target.august;
          } else if (this.filterForm.month == 'sep') {
            total = target.september;
          } else if (this.filterForm.month == 'oct') {
            total = target.october;
          } else if (this.filterForm.month == 'nov') {
            total = target.november;
          } else if (this.filterForm.month == 'dec') {
            total = target.december;
          }
          // console.log(total);
          // return total > 0 ;
        }
        g_total += total;
        //}
        //});
        return this.amountConvert(g_total, 2);
        //return g_total ;
      },
      kpiTotalTarget(kpi_id, type) {
        let g_total = 0;
        //this.items =  this.items_all ;
        this.items.filter(item => {
          let total = 0;
          let target;
          if (item.kpi_id == kpi_id) {
            if (type == 'target') {
              target = item.mostargetjoin;
            } else if (type == 'achievement') {
              target = item.mosachievementjoin;
            }

            let q1;
            let q2;
            let q3;
            let q4;
            let q5;
            let q6;
            q1 = (target?target.january:0) + (target?target.february:0) + (target?target.march:0);
            q2 = (target?target.april:0) + (target?target.may:0) + (target?target.june:0);
            q3 = (target?target.july:0) + (target?target.august:0) + (target?target.september:0);
            q4 = (target?target.october:0) + (target?target.november:0) + (target?target.december:0);
            q5 = q1 + q2;
            q6 = q3 + q4;
            if (this.filterForm.month == '') {
              if (this.filterForm.quarter == 1) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q1;
                } else {
                  total = q1 / 3;
                }
              } else if (this.filterForm.quarter == 2) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q2;
                } else {
                  total = q2 / 3;
                }
              } else if (this.filterForm.quarter == 3) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q3;
                } else {
                  total = q3 / 3;
                }
              } else if (this.filterForm.quarter == 4) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q4;
                } else {
                  total = q4 / 3;
                }
              } else if (this.filterForm.quarter == 5) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q5;
                } else {
                  total = q5 / 6;
                }

              } else if (this.filterForm.quarter == 6) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q6;
                } else {
                  total = q6 / 6;
                }
              } else {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = (q1 + q2 + q3 + q4);
                } else {
                  total = (q1 + q2 + q3 + q4) / 12;
                }

                // total =  q1 + q2 + q3+ q4 ;
              }
            } else {


              if (this.filterForm.month == 'jan') {
                total = target.january;
              } else if (this.filterForm.month == 'feb') {
                total = target.february;
              } else if (this.filterForm.month == 'mar') {
                total = target.march;
              } else if (this.filterForm.month == 'apr') {
                total = target.april;
              } else if (this.filterForm.month == 'may') {
                total = target.may;
              } else if (this.filterForm.month == 'jun') {
                total = target.june;
              } else if (this.filterForm.month == 'jul') {
                total = target.july;
              } else if (this.filterForm.month == 'aug') {
                total = target.august;
              } else if (this.filterForm.month == 'sep') {
                total = target.september;
              } else if (this.filterForm.month == 'oct') {
                total = target.october;
              } else if (this.filterForm.month == 'nov') {
                total = target.november;
              } else if (this.filterForm.month == 'dec') {
                total = target.december;
              }
              // console.log(total);
              // return total > 0 ;
            }
            g_total += total;
          }
        });
        return this.amountConvert(g_total, 2);
        //return g_total ;
      },
      kraTotalTarget(kra_id, type) {
        let g_total = 0;
        //this.items =  this.items_all ;
        this.items.filter(item => {
          let total = 0;
          let target;
          if (item.kra_id == kra_id) {
            if (type == 'target') {
              target = item.mostargetjoin;
            } else if (type == 'achievement') {
              target = item.mosachievementjoin;
            }

            let q1;
            let q2;
            let q3;
            let q4;
            let q5;
            let q6;
            q1 = (target?target.january:0) + (target?target.february:0) + (target?target.march:0);
            q2 = (target?target.april:0) + (target?target.may:0) + (target?target.june:0);
            q3 = (target?target.july:0) + (target?target.august:0) + (target?target.september:0);
            q4 = (target?target.october:0) + (target?target.november:0) + (target?target.december:0);
            q5 = q1 + q2;
            q6 = q3 + q4;
            if (this.filterForm.month == '') {
              if (this.filterForm.quarter == 1) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q1;
                } else {
                  total = q1 / 3;
                }
              } else if (this.filterForm.quarter == 2) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q2;
                } else {
                  total = q2 / 3;
                }
              } else if (this.filterForm.quarter == 3) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q3;
                } else {
                  total = q3 / 3;
                }
              } else if (this.filterForm.quarter == 4) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q4;
                } else {
                  total = q4 / 3;
                }
              } else if (this.filterForm.quarter == 5) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q5;
                } else {
                  total = q5 / 6;
                }

              } else if (this.filterForm.quarter == 6) {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = q6;
                } else {
                  total = q6 / 6;
                }
              } else {
                if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                  total = (q1 + q2 + q3 + q4);
                } else {
                  total = (q1 + q2 + q3 + q4) / 12;
                }

                // total =  q1 + q2 + q3+ q4 ;
              }
            } else {


              if (this.filterForm.month == 'jan') {
                total = target.january;
              } else if (this.filterForm.month == 'feb') {
                total = target.february;
              } else if (this.filterForm.month == 'mar') {
                total = target.march;
              } else if (this.filterForm.month == 'apr') {
                total = target.april;
              } else if (this.filterForm.month == 'may') {
                total = target.may;
              } else if (this.filterForm.month == 'jun') {
                total = target.june;
              } else if (this.filterForm.month == 'jul') {
                total = target.july;
              } else if (this.filterForm.month == 'aug') {
                total = target.august;
              } else if (this.filterForm.month == 'sep') {
                total = target.september;
              } else if (this.filterForm.month == 'oct') {
                total = target.october;
              } else if (this.filterForm.month == 'nov') {
                total = target.november;
              } else if (this.filterForm.month == 'dec') {
                total = target.december;
              }
              // console.log(total);
              // return total > 0 ;
            }
            g_total += total;
          }
        });
        return this.amountConvert(g_total, 2);
        // return g_total ;
      },
      targetTotal(item) {
        let target = item.mostargetjoin;
        let total = 0;
        let q1;
        let q2;
        let q3;
        let q4;
        let q5;
        let q6;
        q1 = (target?target.january:0) + (target?target.february:0) + (target?target.march:0);
        q2 = (target?target.april:0) + (target?target.may:0) + (target?target.june:0);
        q3 = (target?target.july:0) + (target?target.august:0) + (target?target.september:0);
        q4 = (target?target.october:0) + (target?target.november:0) + (target?target.december:0);
        q5 = q1 + q2;
        q6 = q3 + q4;
        if (this.filterForm.month == '') {
          if (this.filterForm.quarter == 1) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q1;
            } else {
              total = q1 / 3;
            }
          } else if (this.filterForm.quarter == 2) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q2;
            } else {
              total = q2 / 3;
            }
          } else if (this.filterForm.quarter == 3) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q3;
            } else {
              total = q3 / 3;
            }
          } else if (this.filterForm.quarter == 4) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q4;
            } else {
              total = q4 / 3;
            }
          } else if (this.filterForm.quarter == 5) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q5;
            } else {
              total = q5 / 6;
            }

          } else if (this.filterForm.quarter == 6) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q6;
            } else {
              total = q6 / 6;
            }
          } else {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = (q1 + q2 + q3 + q4);
            } else {
              total = (q1 + q2 + q3 + q4) / 12;
            }

            // total =  q1 + q2 + q3+ q4 ;
          }
        } else {
          if (this.filterForm.month == 'jan') {
            total = target.january;
          } else if (this.filterForm.month == 'feb') {
            total = target.february;
          } else if (this.filterForm.month == 'mar') {
            total = target.march;
          } else if (this.filterForm.month == 'apr') {
            total = target.april;
          } else if (this.filterForm.month == 'may') {
            total = target.may;
          } else if (this.filterForm.month == 'jun') {
            total = target.june;
          } else if (this.filterForm.month == 'jul') {
            total = target.july;
          } else if (this.filterForm.month == 'aug') {
            total = target.august;
          } else if (this.filterForm.month == 'sep') {
            total = target.september;
          } else if (this.filterForm.month == 'oct') {
            total = target.october;
          } else if (this.filterForm.month == 'nov') {
            total = target.november;
          } else if (this.filterForm.month == 'dec') {
            total = target.december;
          } else {
            total = 0;
          }
        }
        return total;
      },
      moduleTotal(item) {
        if (item.mosmodulejoin) {
          let module = item.mosmodulejoin;
          let total = 0;
          let q1;
          let q2;
          let q3;
          let q4;
          let q5;
          let q6;
          q1 = module.january + module.february + module.march;
          q2 = module.april + module.may + module.june;
          q3 = module.july + module.august + module.september;
          q4 = module.october + module.november + module.december;
          q5 = q1 + q2;
          q6 = q3 + q4;
          if (this.filterForm.month == '') {
            if (this.filterForm.quarter == 1) {
              if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                total = q1;
              } else {
                total = q1 / 3;
              }
            } else if (this.filterForm.quarter == 2) {
              if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                total = q2;
              } else {
                total = q2 / 3;
              }
            } else if (this.filterForm.quarter == 3) {
              if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                total = q3;
              } else {
                total = q3 / 3;
              }
            } else if (this.filterForm.quarter == 4) {
              if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                total = q4;
              } else {
                total = q4 / 3;
              }
            } else if (this.filterForm.quarter == 5) {
              if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                total = q5;
              } else {
                total = q5 / 6;
              }

            } else if (this.filterForm.quarter == 6) {
              if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                total = q6;
              } else {
                total = q6 / 6;
              }
            } else {
              if (item.mos_calculation == 0 || item.mos_calculation == 1) {
                total = (q1 + q2 + q3 + q4);
              } else {
                total = (q1 + q2 + q3 + q4) / 12;
              }

              // total =  q1 + q2 + q3+ q4 ;
            }
          } else {
            if (this.filterForm.month == 'jan') {
              total = module.january;
            } else if (this.filterForm.month == 'feb') {
              total = module.february;
            } else if (this.filterForm.month == 'mar') {
              total = module.march;
            } else if (this.filterForm.month == 'apr') {
              total = module.april;
            } else if (this.filterForm.month == 'may') {
              total = module.may;
            } else if (this.filterForm.month == 'jun') {
              total = module.june;
            } else if (this.filterForm.month == 'jul') {
              total = module.july;
            } else if (this.filterForm.month == 'aug') {
              total = module.august;
            } else if (this.filterForm.month == 'sep') {
              total = module.september;
            } else if (this.filterForm.month == 'oct') {
              total = module.october;
            } else if (this.filterForm.month == 'nov') {
              total = module.november;
            } else if (this.filterForm.month == 'dec') {
              total = module.december;
            } else {
              total = 0;
            }
          }
          return total;
        }
      },
      achievementjoinTotal(item) {
        let achievement = item.mosachievementjoin;
        let total = 0;
        let q1;
        let q2;
        let q3;
        let q4;
        let q5;
        let q6;
        q1 = (achievement?achievement.january:0) + (achievement?achievement.february:0) + (achievement?achievement.march:0);
        q2 = (achievement?achievement.april:0) + (achievement?achievement.may:0) + (achievement?achievement.june:0);
        q3 = (achievement?achievement.july:0) + (achievement?achievement.august:0) + (achievement?achievement.september:0);
        q4 = (achievement?achievement.october:0) + (achievement?achievement.november:0) + (achievement?achievement.december:0);
        q5 = q1 + q2;
        q6 = q3 + q4;
        if (this.filterForm.month == '') {
          if (this.filterForm.quarter == 1) {
            // total =  q1 ;
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q1;
            } else {
              total = q1 / 3;
            }
          } else if (this.filterForm.quarter == 2) {
            // total = q2 ;
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q2;
            } else {
              total = q2 / 3;
            }
          } else if (this.filterForm.quarter == 3) {
            // total =  q3;
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q3;
            } else {
              total = q3 / 3;
            }
          } else if (this.filterForm.quarter == 4) {
            // total = q4 ;
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q4;
            } else {
              total = q4 / 3;
            }
          } else if (this.filterForm.quarter == 5) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q5;
            } else {
              total = q5 / 6;
            }
            // if(item.mos_calculation == 1 || item.mos_calculation == 2 || item.mos_calculation == 3){
            //     total =  q5/6;
            // }else{
            //     total =  q5;
            // }

          } else if (this.filterForm.quarter == 6) {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = q6;
            } else {
              total = q6 / 6;
            }
            // if(item.mos_calculation == 1 || item.mos_calculation == 2 || item.mos_calculation == 3){
            //     total =  q6/6;
            // }else{
            //     total =  q6;
            // }

          } else {
            if (item.mos_calculation == 0 || item.mos_calculation == 1) {
              total = (q1 + q2 + q3 + q4);
            } else {
              total = (q1 + q2 + q3 + q4) / 12;
            }
          }
        } else {
          if (this.filterForm.month == 'jan') {
            total = achievement.january;
          } else if (this.filterForm.month == 'feb') {
            total = achievement.february;
          } else if (this.filterForm.month == 'mar') {
            total = achievement.march;
          } else if (this.filterForm.month == 'apr') {
            total = achievement.april;
          } else if (this.filterForm.month == 'may') {
            total = achievement.may;
          } else if (this.filterForm.month == 'jun') {
            total = achievement.june;
          } else if (this.filterForm.month == 'jul') {
            total = achievement.july;
          } else if (this.filterForm.month == 'aug') {
            total = achievement.august;
          } else if (this.filterForm.month == 'sep') {
            total = achievement.september;
          } else if (this.filterForm.month == 'oct') {
            total = achievement.october;
          } else if (this.filterForm.month == 'nov') {
            total = achievement.november;
          } else if (this.filterForm.month == 'dec') {
            total = achievement.december;
          } else {
            total = 0;
          }
        }
        return total;
      },
      select_months(mo) {
        //const d = new Date();
        if (this.filterForm.month != '') {
          if (this.filterForm.month == mo) {
            return true;
          } else {
            return false;
          }
        } else {
          if (this.filterForm.quarter != '') {
            if (this.filterForm.quarter == 1 && (mo == 'jan' || mo == 'feb' || mo == 'mar')) {
              return true;
            } else if (this.filterForm.quarter == 2 && (mo == 'apr' || mo == 'may' || mo == 'jun')) {
              return true;
            } else if (this.filterForm.quarter == 3 && (mo == 'jul' || mo == 'aug' || mo == 'sep')) {
              return true;
            } else if (this.filterForm.quarter == 4 && (mo == 'oct' || mo == 'nov' || mo == 'dec')) {
              return true;
            } else if (this.filterForm.quarter == 5 && (mo == 'jan' || mo == 'feb' || mo == 'mar' || mo == 'apr' || mo == 'may' || mo == 'jun')) {
              return false;
            } else if (this.filterForm.quarter == 6 && (mo == 'jul' || mo == 'aug' || mo == 'sep' || mo == 'oct' || mo == 'nov' || mo == 'dec')) {
              return false;
            } else {
              return false;
            }
          } else {
            return true
          }
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
      async getDept() {
        let loader = this.$loading.show();
        this.getDepartments(this.status).then(({ data }) => {
          if (data.success) {
            loader.hide();
            this.deptItems = data.data;
            this.getItems();
          } else {
            loader.hide();
          }
        });
      },
      async getKRA() {
        await axios.get(this.api_url + "k_r_a_s?year="+ this.year+"&dept_id=" + this.filterForm.dept_id, {
          headers: {
            "Content-Type": "application/json",
            Authorization: this.token ? `Bearer ${this.token}` : ""
          },
        })
          .then(({ data }) => {
            this.getItems();
            this.kraItem = data.data;
            console.log(this.kraItem);
          });
      },
      async getKpi() {
        console.log(this.filterForm.kra_id);
        await axios.get(this.api_url + "k_p_i_s?kra_id=" + this.filterForm.kra_id, {
          headers: {
            "Content-Type": "application/json",
            Authorization: this.token ? `Bearer ${this.token}` : ""
          },
        })
          .then(({ data }) => {
            this.getItems();
            this.kpiItem = data.data;
            console.log(this.roles);
          });
      },
      async getItems() {

        console.log('dept_id', this.filterForm.dept_id);



        if (this.filterForm.dept_id || this.user_data.department) {
          let where = '?year=' + (this.year ? this.year : new Date().getFullYear());

          if (this.filterForm.dept_id) {
            where += '&dept_id=' + (this.filterForm.dept_id ? this.filterForm.dept_id : this.user_data.department);
          }
          if (this.filterForm.kra_id) {
            where += '&kra_id=' + this.filterForm.kra_id;
          }
          if (this.filterForm.kpi_id) {
            where += '&kpi_id=' + this.filterForm.kpi_id;
          }
          let loader = this.$loading.show();
          try {
            await axios
              .get(this.api_url + "kra_kpi_mos_list" + where, {
                headers: {
                  "Content-Type": "application/json",
                  Authorization: this.token ? `Bearer ${this.token}` : ""
                },
              })
              .then(({
                data
              }) => {
                if (data.success) {
                  this.items_all = data.data;
                  this.items = data.data;
                  console.log('items', this.items);
                } else {
                  console.log('not found');
                }
                loader.hide();
              });
          } catch (error) {
            loader.hide();
          }
        }
      },

      //SHOW COMMENT MODAL
      comment_show(item) {
        this.item = item;

        //GET COMMENTS
        axios.get(this.api_url + "mos_feadbacks?mos_id=" + item.id, {
          headers: {
            "Content-Type": "application/json",
            Authorization: this.token ? `Bearer ${this.token}` : ""
          },
        })
          .then(({
            data
          }) => {
            if (data.success) {
              this.feedback = data.data;
              console.log('feedback', this.feedback);
            }
          });

        this.$modal.show("comment");
      },
      tabs(i) {
        this.comment_active = i;
      },

      //HIDE COMMENT MODAL
      comment_hidden() {
        this.$modal.hide("comment");
      },

      //MONTHLY REPORT MOS FEEDBACK
      task_comment() {
        try {
          let loader = this.$loading.show();
          this.comment_mailForm.mos_id = this.item.id;
          this.comment_mailForm.dept_id = this.item.dept_id;
          this.comment_mailForm.fmonth = this.filterForm.month;

          this.comment_mailForm.post(this.api_url + "mos_feadbacks", {
            headers: {
              "Content-Type": "application/json",
              Authorization: this.token ? `Bearer ${this.token}` : ""
            },
          }).then((res) => {
            if (res.data.success) {
              this.comment_hidden();
              this.$toasted.show(res.data.message, {
                theme: "bubble",
                duration: 5000,
                position: "bottom-right",
              });
            }

            loader.hide();
            // this.$router.push('/daily_work');
          }, (error) => {
            console.log(error);
            loader.hide();
          })
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
  .color_red {
    color: red;
  }

  .gb_color_green {
    background-color: seagreen;
    color: seashell;
  }

  .gb_color_yellow {
    background-color: yellow;
    color: black;
  }
</style>