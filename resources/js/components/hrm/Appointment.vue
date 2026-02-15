<template>
  <div>
    <div class="widget box">
      <div class="widget-header">
        <section class="content" style="">
          <div class="row">
            <div class="col-12">
              <div class="card" style="margin-top: -5px; margin-bottom: 0px">
                <div class="card-header">
                  <div class="row">
                    <div
                      class="col-12 col-sm-6 col-md-12"
                      style="padding: 5px 15px"
                    >
                      <h3 class="card-title d-none d-md-block">
                        Appointed Letter
                      </h3>
                      <!-- {{ resData.signature_settings[0].employee_fullname }} -->
                      <span class="float-sm-right" style="float: right">
                        <a
                          class="btn btn-default float-right"
                          @click="$router.go(-1)"
                          ><i class="fa fa-arrow-left"></i> Back</a
                        >
                        <button
                          @click="printDiv()"
                          class="btn-info float-right"
                          style="margin-right: 10px"
                        >
                          Print
                        </button>
                        <!-- lang change  -->
                        <button
                          @click="langChange()"
                          class="btn-info float-right"
                          style="margin-right: 10px"
                        >
                          {{textlang}}
                        </button>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid" id="printable">
            <div class="en" v-if="lang == 'en'">
              <div style="line-height: 18px; padding: 70px 0px 0px 60px;">
                <p
                  class="s1"
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  {{ today_date_en ? today_date_en : "............" }}

                </p>
                <p
                  class="s1"
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  Ref:GFAPL/HR/{{ year_en }}/{{ serial_en }}
                </p>
                <h4
                  class="s2"
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: center;
                  "
                >
                  <u><i>STRICTLY CONFIDENTIAL</i></u>
                </h4>

                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  <strong> {{resData.employee_fullname}} </strong>
                </p>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  {{resData.present_holding_no}} {{resData.present_house_name}} <span v-if="resData.present_road_no || resData.present_road_name">, Road #{{resData.present_road_no}} {{resData.present_road_name}}</span>
                </p>
                <p style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  ">
                  Vill: {{resData.present_vill_area}}, P.O: {{resData.present_post_office}}, P.S: {{resData.up_name}},
                </p>
                 <p style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  ">
                  Dist: {{resData.d_name}}.
                </p>
                <!-- <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  <br />
                </p> -->

                <h4
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: center;
                  "
                >
                  Appointment as ‘{{ resData.designation_name }},{{resData.department_name }}’
                </h4>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  <br />
                </p>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  Dear <b>{{resData.employee_fullname}}</b>,
                </p>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  Further to our discussion, I am pleased to offer you an
                  appointment as <b>{{ resData.designation_name }},{{resData.department_name }} </b>under {{resData.sbu_name}} effective from the date of your
                  joining on or before <b>{{joining_date_en}}</b>, on following terms
                  and conditions:
                </p>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  <br />
                </p>
              <ol type="1" style="list-style-position: outside;margin-left: 10px;">
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >

                  You will report to the <b><span v-if="resData.employee_department == 11"> Outlet Incharge</span>
                  <span v-else>{{resData.repotingToDesignations}},{{resData.repotingToDepartment}}</span>
                   </b> or any person
                  assigned by him/her or by the management for your overall and
                  day to day work.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  You will be paid a gross salary of
                  <b>Tk. {{resData.gross_salary}}/- </b>({{resData.gross_salary_inwords}}) per month.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  You will be on probation for {{resData.employee_due_month}} ({{resData.employee_due_month_text}}) months at the first
                  instance or until the time the company confirms in writing
                  that you have successfully completed the probation period.
                  During the period of probation either party can terminate the
                  employment at any time without prior notice or mentioning any
                  reason.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  You will be stationed at <b>{{resData.work_location_name}} </b>Outlet.
                  However, the Company preserves all the rights to transfer you
                  at any location as on when required.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  You will be entitled to get festival allowance in two major
                  religious Festivals (50% of monthly salary on each Festival),
                  as per policy.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  Any changes in any information (particularly educational
                  qualification, addresses, marital status etc.) given in your
                  resume must be communicated to HR &amp; Administration
                  Department immediately.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  You may be required to travel within Bangladesh or abroad
                  for official purpose. In that case company will reimburse cost
                  of travel as per the travel policy of the company.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  You will be entitled to enjoy leave as per company’s leave
                  policy.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  Other facilities will be provided to you as per company
                  policies.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  You will be bound by the terms &amp; conditions, policies,
                  rules &amp; regulations of the Gemcon Food and Agricultural
                  Products Ltd. that are currently in force and any new terms
                  &amp; conditions, policies, rules &amp; regulations that
                  become effective in future.
                </li>
                <li
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  During the continuation of your employment and thereafter,
                  you will keep the information acquired by you as secret or
                  confidential and will not divulge to any person, firm or
                  company whomsoever while in the service of the company.
                </li>
              </ol>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  <br />
                </p>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                    margin-bottom: 5px;
                  "
                >
                  We look forward to your contribution to the Company and
                  helping us to meet the exciting and important challenges that
                  lie ahead.
                </p>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: justify;
                  "
                >
                  Please countersign this letter below to verify your acceptance
                  of this position with the conditions as stipulated above.
                </p>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  <br />
                </p>
                <p
                  class="s3"
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    line-height: 11pt;
                    text-align: justify;
                  "
                >
                  Yours sincerely,
                </p>
                <p
                  class="s3"
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    line-height: 11pt;
                    text-align: justify;
                  "
                >
                  By the order of the Management,
                </p>
                <p
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  <br />
                </p>
                <p
                  style="
                    padding-top: 10px;
                    margin-bottom: 0rem;
                    text-indent: 0pt;
                    text-align: left;
                  ">
                  ____________________
                </p>

                <!-- {{ resData }} -->
                <span v-if="resData.emplyee_category_mgt_non_mgt == 1">

                    <p                  style="
                        padding: 0;
                        margin: 0;
                        text-indent: 0pt;
                        text-align: left;
                    "
                    >
                    <b> {{ resData.signature_settings[0].employee_fullname }} </b>
                    </p>
                    <p
                    class="s3"
                    style="
                        padding: 0;
                        margin: 0;
                        text-indent: 0pt;
                        text-align: left;
                    "
                    >
                    {{ resData.signature_settings[0].designation_name }},
                    {{ resData.signature_settings[0].department_name }}
                    </p>
                </span>
                <span v-else>
                    <p                  style="
                        padding: 0;
                        margin: 0;
                        text-indent: 0pt;
                        text-align: left;
                    "
                    >
                    <b> {{ resData.signature_settings[0].employee_fullname }}                    </b>
                    </p>
                    <p
                    class="s3"
                    style="
                        padding: 0;
                        margin: 0;
                        text-indent: 0pt;
                        text-align: left;
                    "
                    >
                    {{ resData.signature_settings[0].designation_name }},
                    {{ resData.signature_settings[0].department_name }}
                    <!-- Assistant Manager, HR & Administration -->
                    </p>
                </span>
                <!-- HR, Training &amp; Administration -->
                <p
                  class="s4"
                  style="
                    padding: 0;
                    margin: 0;
                    text-indent: 0pt;
                    text-align: left;
                  "
                >
                  Cc: Personnel File <b>(ID:{{resData.employee_id_no}})</b>
                </p>
              </div>

              <!-- /.row -->
            </div>
            <div class="bn" v-if="lang == 'bn'">
              <div class="row">
                <div style="line-height: 25px; padding: 60px">
                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0px 0px 0px 0px;
                      font-family: Bangla;
                      font-size: 11pt;
                    "
                  >
                    সূত্র: জিএফএপিএল/এইচ.আর/{{ year_bangla }}/{{
                      serial_bangla
                    }}
                    <!-- getYear()  -->
                    <!-- resData.id -->
                  </p>
                  <!-- <p style="text-align: justify; padding: 0; margin: 0">&nbsp;</p> -->
                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla">
                          <!-- // getDate() -->
                          {{
                            today_date_bangla
                              ? today_date_bangla
                              : "............"
                          }}
                        </span></span
                      ></span
                    >
                  </p>
                  <!-- <p style="text-align: justify; padding: 0; margin: 0">&nbsp;</p> -->
                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0px 0px 2px 0px;
                      line-height: 19px;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        >
                        <!-- <strong
                          ><span style="font-family: Bangla"
                            >{{
                              resData.employee_nid_name_bangla
                                ? resData.employee_nid_name_bangla
                                : "............"
                            }}
                          </span>
                        </strong> -->

                        <strong style="font-family: Bangla">

                            <samp
                              style="font-family: Bangla"
                              v-if="resData.employee_gender == 2"
                            >
                              জনাব</samp
                            >
                            <samp
                              style="font-family: Bangla"
                              v-if="resData.employee_gender == 1"
                            >
                              জনাবা</samp
                            >
                            <samp
                              style="font-family: Bangla"
                              v-if="resData.employee_gender == 3"
                            >
                              জনাব/জনাবা</samp
                            >

                            {{
                              resData.employee_nid_name_bangla
                                ? resData.employee_nid_name_bangla
                                : "............"
                            }},
                            </strong>
                        </span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >মাতা:
                          {{
                            resData.employee_mother_name_bangla
                              ? resData.employee_mother_name_bangla
                              : "............"
                          }}, পিতা:
                          {{
                            resData.employee_father_name_bangla
                              ? resData.employee_father_name_bangla
                              : "............"
                          }}
                        </span></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0px 0px 3px 0px;
                      line-height: 19px;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla">{{
                          resData.present_address_bangla
                        }}</span></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      font-size: 3px;
                      line-height: 3px;
                    "
                  >
                    &nbsp;
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0px 0px 3px 0px;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >বিষয়: {{ resData.designation_name_bangla }} পদে

                          <span v-if="resData.employee_type_bangla == 1">
                            স্থায়ী
                          </span>
                          <span v-if="resData.employee_type_bangla == 2">
                            শিক্ষানবিস
                          </span>
                          <span v-if="resData.employee_type_bangla == 3">
                            চুক্তিভিত্তিক
                          </span>
                          <span v-if="resData.employee_type_bangla == 6">
                            সাময়িক
                          </span>
                          <span v-if="resData.employee_type_bangla == 4">
                            অস্থায়ী
                          </span>
                          <span v-if="resData.employee_type_bangla == 5">
                            ইর্ন্টান
                          </span>
                          নিয়োগ।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      font-size: 3px;
                      line-height: 3px;
                    "
                  >
                    &nbsp;
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla">

                          <strong style="font-family: Bangla">

                            <samp
                              style="font-family: Bangla"
                              v-if="resData.employee_gender == 2"
                            >
                              জনাব</samp
                            >
                            <samp
                              style="font-family: Bangla"
                              v-if="resData.employee_gender == 1"
                            >
                              জনাবা</samp
                            >
                            <samp
                              style="font-family: Bangla"
                              v-if="resData.employee_gender == 3"
                            >
                              জনাব/জনাবা</samp
                            >

                            {{
                              resData.employee_nick_name
                                ? resData.employee_nick_name
                                : "............"
                            }},
                            </strong>
                          </span
                        ></span
                      ></span
                    >
                  </p>

                  <!-- <p style="text-align: justify; padding: 0; margin: 0">&nbsp;</p> -->

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0px 0px 12px 0px;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >আপনার অবগতির জন্য জানাচ্ছি যে, আপনার আবেদন ও আমাদের
                          সাথে সাক্ষাৎকারের ফলাফলের ভিত্তিতে আপনাকে নিম্নলিখিত
                          শর্ত সাপেক্ষে
                          {{
                            joining_date_bangla
                              ? joining_date_bangla
                              : "............"
                          }}
                          থেকে {{ confirmation_due_date_bangla }} তারিখ পর্যন্ত
                          {{ due_month_bangla ? due_month_bangla : "....." }}
                          মাসের জন্য অত্র প্রতিষ্ঠানে
                          <strong>
                            {{
                              resData.designation_name_bangla
                                ? resData.designation_name_bangla
                                : "............"
                            }}
                          </strong>
                          পদে নিয়োগ দেয়া হল:</span
                        ></span
                      ></span
                    >
                  </p>
                  <!-- <ol type="1" style="list-style-position: outside;margin-left: 10px;">
                  <li
                    style="
                      padding: 0;
                      margin: 0;
                      text-indent: 0pt;
                      text-align: justify;
                    "
                  > -->

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >১. প্রতিদিনের কাজের জন্য আপনি আউটলেট ইনচার্জ অথবা তার
                          দ্বারা নির্ধারিত ব্যক্তির নিকট রিপোর্ট করবেন।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >২. ট্রেইনি হিসেবে নিয়োগকালে আপনি সর্ব সাকুল্যে মাসিক
                          <strong>
                            {{
                              resData.gross_salary_bangla
                                ? resData.gross_salary_bangla
                                : "............"
                            }}
                            <span
                              v-if="resData.gross_salary_bangla_text"
                              style="font-family: Bangla"
                            >
                              (
                              {{
                                resData.gross_salary_bangla_text
                                  ? resData.gross_salary_bangla_text
                                  : "............"
                              }}
                              )</span
                            >
                          </strong>
                          টাকা মজুরি প্রাপ্ত হবেন।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >৩. আপনার মাসিক উপস্থিতির উপর ভিত্তি করে উপস্থিতি ও খাবারের জন্য সর্বোচ্চ ১,০০০ টাকা ভাতা প্রাপ্ত হবেন।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >৪. প্রাথমিকভাবে আপনি
                          <strong
                            >{{
                              resData.work_location_bangla
                                ? resData.work_location_bangla
                                : "............"
                            }}</strong>-এ কাজ করবেন। তবে আপনার চাকুরী যে কোন সময় বদলীযোগ্য।
                          কর্তৃপক্ষ প্রয়োজনে আপনাকে কোম্পানির যেকোনো শাখায় বা
                          বিভাগে বদলী করতে পারবে।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >৫. আপনি কোম্পানির নির্ধারিত শিফটে কাজ করতে বাধ্য
                          থাকবেন।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >৬.
                          <strong
                            >{{
                              joining_date_bangla
                                ? joining_date_bangla
                                : "............"
                            }}
                          </strong>
                          হতে
                          <strong>
                            {{
                              confirmation_due_date_bangla
                                ? confirmation_due_date_bangla
                                : "............"
                            }}
                          </strong>
                          তারিখ পর্যন্ত আপনার কর্মদক্ষতা ও যোগ্যতা কর্তৃপক্ষের
                          নিকট সন্তোষজনক বিবেচিত হলে উভয় পক্ষের সম্মতিক্রমে উক্ত
                          সময়ের পর এই নিয়োগের পুনঃনবায়ন করা যেতে পারে। তবে
                          উভয়পক্ষ যে কোন সময় ০১ (এক) মাসের নোটিশ সাপেক্ষে এই
                          নিয়োগ বাতিলও করতে পারবে।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >৭. আপনার স্থায়ী অথবা বর্তমান ঠিকানাসহ অন্য কোন প্রকার
                          তথ্যের পরিবর্তন হলে অবশ্যই তা লিখিত আকারে মানব সম্পদ
                          বিভাগকে অবগত করবেন। আপনার দেওয়া কোন তথ্য ভুল প্রমাণিত
                          হলে এবং কাগজপত্রে কোনো গরমিল পরিলক্ষিত হলে কর্তৃপক্ষ
                          আপনার বিরুদ্ধে প্রচলিত আইন অনুযায়ী ব্যবস্থা গ্রহন করতে
                          পারবে।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >৮. কর্তৃপক্ষের অনুমতি ছাড়া কোম্পানির কোনো
                          তথ্য/বস্তু/প্রয়োজনীয় কাগজপত্র কোথাও হস্তান্তর কিংবা
                          প্রকাশ করতে পারবেন না।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >৯. কোনো প্রকার অসদাচরণের জন্য আপনি দোষী সাব্যস্ত হলে
                          কর্তৃপক্ষ আপনার বিরুদ্ধে আইন সম্মত ব্যবস্থা নেয়ার
                          অধিকার রাখে।
                        </span></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >১০. আপনার চাকুরী কোম্পানির নিয়ম এবং দেশের প্রচলিত আইন
                          অনুযায়ী নিয়ন্ত্রিত হবে এবং আপনি তা মেনে চলতে বাধ্য
                          থাকবেন।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >১১. কোম্পানীর বর্তমানে প্রচলিত ও ভবিষ্যতে প্রবর্তিত
                          যে কোন নিয়ম কানুন মেনে চলতে আপনি বাধ্য থাকবেন।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >১২. আপনি আপনার প্রয়োজনে চাকুরীকালিন সময় কর্তৃপক্ষের
                          পূর্বানুমতি সাপেক্ষে বছরে (আনুপাতিক হারে) মোট ২৪ দিন
                          ছুটি প্রাপ্য হবেন।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0px 0px 5px 0px;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >১৩. কোম্পানীর যে সকল পরিসম্পদ যে গুলো কর্মরত অবস্থায়
                          আপনার অধীনে থাকবে যেমন, কোন কাঁচামাল, তথ্য,
                          স্মারকলিপি, নোট, ছবি, রেকর্ড, পরিকল্পনা, নেম ট্যাগ, আই
                          ডি, ইউনিফর্ম ইত্যাদি অথবা অন্য কোন দলিল যেটা আপনি তৈরি
                          করেছেন, চুক্তির পরিসমাপ্তি হলে সেগুলো আপনি কর্তৃপক্ষকে
                          ফেরত দিয়ে যাবেন। অন্যথায় আপনার পাওনাদি হতে সমন্বয় করা
                          হবে।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 3px;
                    "
                  >
                    &nbsp;
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0px 0px 5px 0px;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >অনুগ্রহ পূর্বক উপরোল্লিখিত শর্ত সাপেক্ষে নিম্নে
                          প্রতিস্বাক্ষরের মাধ্যমে এই নিয়োগ পত্রটি গ্রহণ
                          করুন।</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 3px;
                    "
                  >
                    &nbsp;
                  </p>

                  <p style="text-align: justify; padding: 0; margin: 0">
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >ধন্যবাদান্তে,</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0px 0px 25px 0px;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >কর্তৃপক্ষের আদেশক্রমে,</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 0px;
                    "
                  >
                    &nbsp;
                  </p>

                  <!-- <p style="text-align: justify; padding: 0; margin: 0">&nbsp;</p> -->

                  <!-- <p style="text-align: justify; padding: 0; margin: 0">
        <span style="font-size: 11pt"
          ><span
            >&nbsp;</span
          ></span
        >
      </p> -->
                <p
                  style="
                    padding-top: 0px;
                    margin-bottom: 0rem;
                    text-indent: 0pt;
                    text-align: left;
                  ">
                  ____________________
                </p>
                <span v-if="resData.emplyee_category_mgt_non_mgt == 1">
                    <p
                        style="
                        text-align: justify;
                        padding: 0;
                        margin: 0;
                        line-height: 19px;
                        font-family: Bangla;
                        "
                    >
                        <span style="font-size: 11pt"
                        ><span
                            ><strong
                            ><span style="font-family: Bangla"
                                >{{ resData.signature_settings[0].employee_name_bangla }}</span
                            ></strong
                            ></span
                        ></span
                        >
                    </p>

                    <p
                        style="
                        text-align: justify;
                        padding: 0;
                        margin: 0;
                        line-height: 19px;
                        font-family: Bangla;
                        "
                    >
                        <span style="font-size: 11pt"
                        ><span
                            ><span style="font-family: Bangla"
                            >{{ resData.signature_settings[0].designation_name_bangla }},
                            {{ resData.signature_settings[0].department_name_bangla }}</span
                            ></span
                        ></span
                        >
                    </p>
                </span>

                <span v-else>
                    <p
                        style="
                        text-align: justify;
                        padding: 0;
                        margin: 0;
                        line-height: 19px;
                        font-family: Bangla;
                        "
                    >
                        <span style="font-size: 11pt"
                        ><span
                            ><strong
                            ><span style="font-family: Bangla"
                                >{{ resData.signature_settings[0].employee_name_bangla }}</span
                            ></strong
                            ></span
                        ></span
                        >
                    </p>

                    <p
                        style="
                        text-align: justify;
                        padding: 0;
                        margin: 0;
                        line-height: 19px;
                        font-family: Bangla;
                        "
                    >
                        <span style="font-size: 11pt"
                        ><span
                            ><span style="font-family: Bangla"
                            >{{ resData.signature_settings[0].designation_name_bangla }}</span
                            ></span
                        ></span
                        >
                    </p>

                    <p
                        style="
                        text-align: justify;
                        padding: 0;
                        margin: 0;
                        line-height: 19px;
                        font-family: Bangla;
                        "
                    >
                        <span style="font-size: 11pt"
                        ><span
                            ><span style="font-family: Bangla"
                            >{{ resData.signature_settings[0].department_name_bangla }}</span
                            ></span
                        ></span
                        >
                    </p>
                </span>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 18px;
                    "
                  >
                    &nbsp;
                  </p>

                  <p style="text-align: justify; padding: 0; margin: 0">
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla">ঘোষনা:</span></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >আমি
                          .................................................................................
                          এই নিয়োগপত্রের সকল শর্ত পাঠ করে এবং এতে উল্লেখিত
                          শর্তাবলীতে সম্মত হয়ে অত্র পত্রের মূল (এক) কপি বুঝে
                          পেয়ে স্বজ্ঞানে, সুস্থ মস্তিস্কে ও অন্যের বিনা
                          প্ররোচনায় স্বাক্ষর করলাম।
                        </span></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 17px;
                    "
                  >
                    &nbsp;
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >স্বাক্ষর ও তারিখ:
                          .............................................</span
                        ></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla">অনুলিপি:</span></span
                      ></span
                    >
                  </p>

                  <p
                    style="
                      text-align: justify;
                      padding: 0;
                      margin: 0;
                      line-height: 19px;
                      font-family: Bangla;
                    "
                  >
                    <span style="font-size: 11pt"
                      ><span
                        ><span style="font-family: Bangla"
                          >১)&nbsp;&nbsp; ব্যক্তিগত নথি <b>(ID:{{resData.employee_id_no}})</b></span
                        ></span
                      ></span
                    >
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
          <!-- <input
            type="button"
            @click="printDiv('printableArea')"
            value="print a div!"
          /> -->
          <div style="padding: 60px">
            <button @click="printDiv()" class="btn-info float-right">
              Print
            </button>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<style>
/* @font-face {
  font-family: Bangla;
  src: url(/asset/customBangla.ttf);
} */
@font-face {
  font-family: Bangla;
  @import url("https://cdn.rawgit.com/sh4hids/bangla-web-fonts/bangla/stylesheet.css");
  /* src: url(/asset/customBangla.woff) format("woff"); */
}
@page {
  size: A4;
  margin-top: 50px;
  margin-bottom: 50px;
}
</style>
<script>
import Loading from "../Loading.vue";
import $ from "jquery";

export default {
  data() {
    return {
      separation_status: 0,
      employeeId: this.$route.params.employeeId,
      lang: this.$route.params.lang,
      resData: {},
      joining_date_bangla: "",
      joining_date_en: "",
      confirmation_due_date_bangla: "",
      due_month_bangla: "",
      gross_salary_bangla: "",
      gross_salary_inwords: "",
      salary_inwords_bangla: "",
      today_date_bangla: "",
      today_date_en: "",
      textlang: "",
      year_bangla: "",
      year_en: "",
      serial_bangla: "",
      serial_en: "",
      finalEnglishToBanglaNumber: {
        0: "০",
        1: "১",
        2: "২",
        3: "৩",
        4: "৪",
        5: "৫",
        6: "৬",
        7: "৭",
        8: "৮",
        9: "৯",
      },
    };
  },
  created() {
    this.userInfo();
    if(this.lang == 'en'){
        this.textlang = 'বাংলা';
      }else{
        this.textlang = 'English';
      }
  },
  components: {
    pageLoading: Loading,
  },
  methods: {
    langChange() {
      console.log(this.lang);
      if(this.lang == 'en'){
        this.lang = 'bn';
        this.textlang = 'English';
      }else{
        this.lang = 'en';
        this.textlang = 'বাংলা';
      }
      console.log(this.lang);
      this.$router.push("/appointment/" +  this.employeeId +'/'+ this.lang);
      // this.userInfo();
    },
    getDate() {
      const today = new Date();
      const date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      return date;
    },
    getYear() {
      const today = new Date();
      return today.getFullYear();
    },
    getDigitBanglaFromEnglish(retStr) {
      // var retStr = this;
      for (var x in this.finalEnglishToBanglaNumber) {
        retStr = retStr.replace(
          new RegExp(x, "g"),
          this.finalEnglishToBanglaNumber[x]
        );
      }
      return retStr;
    },
    printDiv() {
      $("ol").each(function () {
        this.style.setProperty("margin-left", "-20px", "important");
        this.style.setProperty("text-align", "justify", "important");
        // this.style.setProperty("font-size", "1.75rem", "important");
      });
      // $("en").each(function () {
      //   this.style.setProperty("font-size", "14px", "important");
      //   // this.style.setProperty("text-align", "justify", "important");
      //   // this.style.setProperty("font-size", "1.75rem", "important");
      // });

      // $("h4").each(function () {
      //   this.style.setProperty("margin", "0px", "important");
      //   this.style.setProperty("font-size", "1.5rem", "important");
      // });
      // $("h5").each(function () {
      //   this.style.setProperty("margin", "0px", "important");
      //   this.style.setProperty("font-size", "1.25rem", "important");
      // });
      // $("h6").each(function () {
      //   this.style.setProperty("margin", "0px", "important");
      //   this.style.setProperty("font-size", "1rem", "important");
      // });
      // $('table').each(function() {
      //   this.style.setProperty('border', '1px solid #dee2e6', 'important');
      //   this.style.setProperty('padding', '5px .75rem', 'important');
      //   this.style.setProperty('border-collapse', 'collapse', 'important');
      // });
      // $('td').each(function() {
      //   this.style.setProperty('border', '1px solid #dee2e6', 'important');
      //   this.style.setProperty('padding', '5px .75rem', 'important');
      //   this.style.setProperty('border-collapse', 'collapse', 'important');
      // });
      // $(".table-bordered").each(function () {
      //   this.style.setProperty("border", "1px solid #dee2e6", "important");
      //   this.style.setProperty("padding", "5px .75rem", "important");
      //   this.style.setProperty("border-collapse", "collapse", "important");
      // });
      // $('').each(function() {
      //   this.style.setProperty('border', '1px solid #dee2e6', 'important');
      //   this.style.setProperty('padding', 'padding: 5px .75rem;', 'important');
      // });
      // $(".ths").each(function () {
      //   this.style.setProperty("border", "1px solid #dee2e6", "important");
      //   this.style.setProperty("padding", "5px 5px", "important");
      //   this.style.setProperty("border-collapse", "collapse", "important");
      // });
      let contents = document.getElementById("printable").innerHTML;

      let frame1 = document.createElement("iframe");
      frame1.name = "frame1";
      frame1.style.position = "absolute";
      frame1.style.top = "-1000000px";
      document.body.appendChild(frame1);
      let frameDoc = frame1.contentWindow
        ? frame1.contentWindow
        : frame1.contentDocument.document
        ? frame1.contentDocument.document
        : frame1.contentDocument;
      frameDoc.document.open();
      frameDoc.document.write(
        '<html lang="en"><head><title>Gemcon Group</title>'
      );
      frameDoc.document.write(
        '<link href="https://cdn.rawgit.com/sh4hids/bangla-web-fonts/bangla/stylesheet.css" rel="stylesheet">',
        '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>'
      );
      frameDoc.document.write("</head><body>");
      frameDoc.document.write(contents);
      frameDoc.document.write("</body></html>");
      frameDoc.document.close();
      setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        document.body.removeChild(frame1);
      }, 500);
      return false;
    },
    // printDiv() {
    //   let contents = document.getElementById("printable").innerHTML;
    //   $("p").each(function () {
    //     this.style.setProperty("color", "red", "important");
    //   });
    //   let frame1 = document.createElement("iframe");
    //   frame1.name = "frame1";
    //   document.body.appendChild(frame1);
    //   let frameDoc = frame1.contentWindow
    //     ? frame1.contentWindow
    //     : frame1.contentDocument.document
    //     ? frame1.contentDocument.document
    //     : frame1.contentDocument;
    //   frameDoc.document.open();
    //   frameDoc.document.write("</head><body>");
    //   frameDoc.document.write(contents);
    //   frameDoc.document.write(
    //     "</body>"
    //     // <style>@page { size: A4; margin-top: 50px;  margin-bottom: 50px;font-family: Bangla !important; }.page-break { page-break-before: always;} @font-face{ @import url('https://cdn.rawgit.com/sh4hids/bangla-web-fonts/bangla/stylesheet.css');font-family: Bangla !important;} </style></html>"
    //   );
    //   frameDoc.document.close();
    //   setTimeout(function () {
    //     window.frames["frame1"].focus();
    //     window.frames["frame1"].print();
    //     document.body.removeChild(frame1);
    //   }, 500);
    //   return false;
    // },

    userInfo() {
      // this.page_loading = false;
      var fetchUrl = this.$route.meta.fetchUrl;
      var obj_params = {
        employee_id: this.employeeId,
      };
      var data_params = Object.assign(this.search_input, obj_params);

      axios
        .get(URL.baseUrl(fetchUrl), {
          params: data_params,
        })
        .then((res) => {
          console.log(res.data);
          this.resData = res.data.employee_data;
          this.joining_date_bangla = res.data.joining_date_bangla;
          this.joining_date_en = res.data.joining_date_en;
          this.confirmation_due_date_bangla =
            res.data.confirmation_due_date_bangla;
          this.due_month_bangla = res.data.due_month_bangla;
          this.gross_salary_bangla = res.data.gross_salary_bangla;
          this.salary_inwords_bangla = res.data.salary_inwords_bangla;
          this.today_date_bangla = res.data.today_date_bangla;
          this.today_date_en = res.data.today_date_en;
          this.year_bangla = res.data.year_bangla;
          this.year_en = res.data.year_en;
          this.serial_bangla = res.data.serial_bangla;
          this.serial_en = res.data.serial_en;
          if (res.data.status == "logout") {
            window.location.href = res.data.url;
          } else {
            console.log(res);
          }

          this.page_loading = true;
          this.modal_loading = true;
        })

        .catch((error) => {
          console.log(error);
          this.showToster({ status: 0, message: "opps! something went wrong" });
          this.page_loading = true;
        });
    },
  },
};
// $('#assetsTable').dataTable( {
//   "destroy": true,
//     "pageLength": 5,
//     "bLengthChange": false,
//     "bFilter": true,
//     "bInfo": false,
//     "bAutoWidth": false
// });
// $('.assetsInfo').show(500);
</script>

<style>
  strong{
    font-family: Bangla;
    font-weight: bolder;
  }
  span{
    font-family: Bangla;
  }
</style>
