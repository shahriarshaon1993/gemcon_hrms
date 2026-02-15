<template>
  <div>
    <div class="widget box">
      <div class="widget-header">
        <section class="content">
          <div class="container-fluid">
            <div
              class="row"
              id="printable"
              style="margin: 0px 0px 0px -10px; padding: 0px 0px 0px -10px"
            >
              <!-- /.col -->
              <div
                v-if="resData.employee_sbu == 21"
                style="
                  margin: 0 auto;
                  padding: 0;
                  width: 215px;
                  height: 335px;
                  background-image: url('/asset/idback.png');
                  background-color: white;
                  background-size: cover;
                  background-position: center;
                  background-repeat: no-repeat;
                "
              >
                <div
                  class=""
                  style="
                    padding-top: 30px;
                    padding-right: 10px;
                    float: right;
                    text-align: right;
                  "
                >
                  <div style="text-align: right">
                    <img
                      :src="`asset/1-1.jpg`"
                      alt="..."
                      style="width: 60px; height: 60px"
                    />
                  </div>
                  <div style="width: 170px; text-align: right">
                    <h4
                      style="font-weight: 600; font-size: 16px; color: #ff842a"
                    >
                      {{ resData.sbu_name }}
                    </h4>
                  </div>
                  <div style="text-align: right" v-if="resData.employee_image">
                    <img
                      style="width: 90px; height: 90px"
                      :src="'images/' + resData.employee_image"
                    />
                  </div>
                  <div style="text-align: right" v-else>
                    <img
                      style="width: 90px; height: 90px"
                      src="https://bootdey.com/img/Content/avatar/avatar1.png"
                      alt=""
                    />
                  </div>
                  <div style="text-align: right">
                    <div
                      style="
                        background-color: green;
                        width: 170px;
                        text-align: center;
                        margin-top: 10px;
                        border-radius: 20px 0px 0px 20px;
                        height: 25px;
                        font-size: 80%;
                        color: white;
                        font-weight: 600;
                      "
                    >
                      <p style="padding-top: 4px">
                        {{ resData.employee_fullname }}
                      </p>
                    </div>
                    <div
                      style="
                        background-color: #ff842a;
                        width: 170px;
                        text-align: center;
                        margin-top: 10px;
                        border-radius: 20px 0px 0px 20px;
                        height: 25px;
                        font-size: 14px;
                        color: white;
                        font-weight: 600;
                      "
                    >
                      <p style="padding-top: 5px">
                        ID # {{ resData.employee_id_no }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="resData.employee_sbu == 11"
                style="
                  margin: 0 auto;
                  padding: 0;
                  width: 215px;
                  height: 335px;
                  background-color: white;
                  background-size: cover;
                  background-position: center;
                  background-repeat: no-repeat;
                "
              >
                <div class="" style="padding-top: 30px; text-align: center">
                  <div style="width: 170px; text-align: right"></div>
                  <div style="text-align: center" v-if="resData.employee_image">
                    <img
                      style="width: 120px; height: 130px; border: solid 1px red"
                      :src="'images/' + resData.employee_image"
                    />
                  </div>
                  <div style="text-align: center" v-else>
                    <img
                      style="width: 120px; height: 140px"
                      src="https://bootdey.com/img/Content/avatar/avatar1.png"
                      alt=""
                    />
                  </div>
                  <div style="text-align: right">
                    <div
                      style="
                        width: 100%;
                        text-align: center;
                        margin-top: 10px;
                        height: 15px;
                        font-size: 14px;
                        font-weight: 600;
                      "
                    >
                      <p style="padding-top: 4px">
                        {{ resData.employee_fullname }}
                      </p>
                    </div>
                    <div
                      style="
                        width: 100%;
                        text-align: center;
                        margin-top: 10px;
                        height: 15px;
                        font-size: 14px;
                        font-weight: 600;
                      "
                    >
                      <p style="padding-top: 5px">
                        ID # {{ resData.employee_id_no }}
                      </p>
                    </div>

                    <div style="padding-top: 20px;">
                      <img
                        :src="`asset/meenalogo.jpg`"
                        alt="..."
                        style="width: 100%; height: 90px;    margin-top: 6px;"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="row"
              id="printable2"
              style="margin: 20px 0px 0px -10px; padding: 0px 0px 0px -10px"
            >
              <!-- /.col -->

              <div
                v-if="resData.employee_sbu == 11"
                style="
                  margin: 0 auto;
                  padding: 0;
                  width: 215px;
                  height: 335px;
                  background-color: white;
                  background-size: cover;
                  background-position: center;
                  background-repeat: no-repeat;
                "
              >
                <div
                  class=""
                  style="
                    text-align: center;
                    padding: 20px 5px 5px 5px;
                    line-height: 15px;
                  "
                >
                  <p style="padding-top: 10px">
                    Please Assist the holder of this card in performing his
                    professional duties.
                  </p>
                  <div style="text-align: center">
                    <img
                      :src="`asset/backsign.jpg`"
                      alt="..."
                      style="height: 60px"
                    />
                  </div>
                  <p style="padding: 0; margin: 0">_____________________</p>
                  <p style="font-size: 11px">Authorized Signature</p>

                  <p style="font-size: 11px">
                    <strong>If found please return to</strong>
                  </p>

                  <p style="font-size: 11px">
                    Gemcon Food &amp; Agricultural Products Ltd.
                  </p>

                  <p style="font-size: 10px; line-height: 12px; margin: 0;padding: 0;">
                    House-44, Road-27 (Old), 16 (New), Dhanmondi R/A,
                    Dhaka-1209. Bangladesh Phone: 88-02-8152039, 9139860
                  </p>
                  <p style="font-size: 10px; line-height: 12px;  margin: 0;padding: 0;">E-mail: info@meenabazar.com.bd</p>
                  <p style="font-size: 10px; line-height: 12px;  margin: 0;padding: 0;">www.meenaclick.com</p>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
          <!-- <input
            type="button"
            @click="printDiv('printableArea')"
            value="print a div!"
          /> -->
          <button @click="printDiv()" class="btn-info float-right">
            Print
          </button>
          <button
            v-if="resData.employee_sbu == 11"
            @click="printDivback()"
            class="btn-info float-right"
          >
            Print back
          </button>
        </section>
      </div>
    </div>
  </div>
</template>
<style>
@media print {
  @page {
    margin: 0;
    padding: 0;
  }
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
      resData: {},
    };
  },
  created() {
    this.userInfo();
  },
  components: {
    pageLoading: Loading,
  },
  methods: {
    printDivback() {
      $("html").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("padding", "0px", "important");
      });

      let contents = document.getElementById("printable2").innerHTML;

      let frame1 = document.createElement("iframe");
      frame1.name = "frame1";
      document.body.appendChild(frame1);
      let frameDoc = frame1.contentWindow
        ? frame1.contentWindow
        : frame1.contentDocument.document
        ? frame1.contentDocument.document
        : frame1.contentDocument;
      frameDoc.document.open();
      frameDoc.document.write(
        "<html style='padding:0; margin:0' lang='en'><body style='padding:0; margin:0'>"
      );
      frameDoc.document.write(contents);
      // frameDoc.document.write(
      //   '<div style=" margin: 0 auto; padding: 0; width: 215px; height: 337px; border: 1px solid #000;  " class="printable"></div>'
      // );
      frameDoc.document.write("</body></html>");
      frameDoc.document.close();
      setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        document.body.removeChild(frame1);
      }, 500);
      return false;
    },
    printDiv() {
      $("html").each(function () {
        this.style.setProperty("margin", "0px", "important");
        this.style.setProperty("padding", "0px", "important");
      });

      let contents = document.getElementById("printable").innerHTML;

      let frame1 = document.createElement("iframe");
      frame1.name = "frame1";
      document.body.appendChild(frame1);
      let frameDoc = frame1.contentWindow
        ? frame1.contentWindow
        : frame1.contentDocument.document
        ? frame1.contentDocument.document
        : frame1.contentDocument;
      frameDoc.document.open();
      frameDoc.document.write(
        "<html style='padding:0; margin:0' lang='en'><body style='padding:0; margin:0'>"
      );
      frameDoc.document.write(contents);
      // frameDoc.document.write(
      //   '<div style=" margin: 0 auto; padding: 0; width: 215px; height: 337px; border: 1px solid #000;  " class="printable"></div>'
      // );
      frameDoc.document.write("</body></html>");
      frameDoc.document.close();
      setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        document.body.removeChild(frame1);
      }, 500);
      return false;
    },

    userInfo() {
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
          this.resData = res.data;
          console.log(res.data);
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