/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
import CxltToastr from 'cxlt-vue2-toastr';
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css';
import '../../public/js/select2.min.js';
import VModal from 'vue-js-modal';
import Vuelidate from 'vuelidate';
import { routes } from "./route";
import VueSweetalert2 from 'vue-sweetalert2';
import Crud from './components/mixins/crud';
import Multiselect from 'vue-multiselect';
import Print from 'vue-print-nb';
import VueBarcode from 'vue-barcode';
import VueCharts from 'vue-chartjs'
import { Bar, Line } from 'vue-chartjs'
import Vue from 'vue'
import Vue2Filters from 'vue2-filters'
Vue.use(Vue2Filters)
import JsonExcel from 'vue-json-excel'
Vue.component('downloadExcel', JsonExcel)
import CKEditor from 'ckeditor4-vue';
import moment from 'moment'
import VueHtmlToPaper from 'vue-html-to-paper';
import VueLoaders from "vue-loaders";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import Toasted from "vue-toasted";
import 'animate.css';
import VueLocalStorage from "vue-localstorage";
import axios from "./components/appraisal/axios_instance";

// import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';

// import VueTimepicker from 'vue2-timepicker'

// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

Vue.filter('formatDate', function(value) {

    if (value) {
        return moment(String(value)).format('M/D/YY')
    }

});
Vue.use(
    Loading, {
        color: "#ec6523 ",
        loader: "spinner",
        width: 64,
        height: 64,
        backgroundColor: "#ffffff",
        opacity: 0.5,
        zIndex: 999,
    }, {}
);
Vue.use(Toasted);
Vue.use(VueLocalStorage);
Vue.use(CKEditor);
Vue.use(VueLoaders);
Vue.config.productionTip = false







new Vue({
    components: {
        'barcode': VueBarcode,
        'VueCharts': VueCharts,
    }
})

//import Select2MultipleControl from 'v-select2-multiple-component';
import Datepicker from 'vuejs-datepicker';
import VoerroTagsInput from '@voerro/vue-tagsinput';
//import VueHtmlToPaper from 'vue-html-to-paper';
Vue.use(VueRouter);
Vue.use(VModal);
Vue.use(Vuelidate);
Vue.use(require('vue-resource'));
Vue.use(VueSweetalert2);
Vue.mixin(Crud);




Vue.component('admin-header-link', require('./components/admin/headerLink.vue').default);
Vue.component('pos-header-link', require('./components/pages/headerLink.vue').default);
Vue.component('pos-topbar', require('./components/pages/posTopbar.vue').default);
Vue.component('admin-sidebar', require('./components/admin/AdminSidebar.vue').default);
Vue.component('bredcrumb', require('./components/BredCrumb.vue').default);
Vue.component('pos-sidebar', require('./components/pages/PosSidebar.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
// Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('pageLoading', require('./components/Loading.vue').default);
Vue.component('select2', require('./components/select2.vue').default);
//Vue.component('Select2MultipleControl', Select2MultipleControl);
Vue.component('vue-select', Multiselect);
Vue.component('Datepicker', Datepicker);
Vue.component('tags-input', VoerroTagsInput);

Vue.use(Print);
// const options = {
//   name: '_blank',
//   specs: [
//     'fullscreen=yes',
//     'titlebar=yes',
//     'scrollbars=yes'
//   ],
//   styles: [
//     'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
//     'https://unpkg.com/kidlat-css/css/kidlat.css',
//     './assets/css/print.css'
//   ]
// }

// Vue.use(VueHtmlToPaper, options);

var toastrConfigs = {
    position: 'top right',
    showDuration: 1000,
    hideDuration: 5000
};
//Vue.use(VueHtmlToPaper,options);
Vue.use(CxltToastr, toastrConfigs);

/*Vue.use(VueLoading, {
  dark: true, // default false
  text: 'Loading', // default 'Loading'
  loading: true, // default false
  customLoader:null, // replaces the spinner and text with your own
  background: 'rgb(255,255,255)', // set custom background
  classes: ['myclass'] // array, object or string
});*/



if ((location.host == 'localhost:8080') || (location.host == 'localhost:8000') || (location.host == '127.0.0.1:8080')) {
    window.base_url = 'http://localhost:8080/';
    window.api_url = 'http://127.0.0.1:8000/';
    window.backend_url = 'http://127.0.0.1:8000/';


} else {
    window.base_url = 'http://' + location.host + '/';
    window.api_url = 'http://' + location.host + '/';
    window.backend_url = 'http://' + location.host + '/';
}
const router = new VueRouter({
    routes,
    // mode:'history',
});
Vue.mixin({
    data: function() {
        return {
            year: 2021,
            months: [
                { 'name': 'Jan', 'id': 'jan' }, { 'name': 'Feb', 'id': 'feb' }, { 'name': 'Mar', 'id': 'mar' }, { 'name': 'Apr', 'id': 'apr' }, { 'name': 'May', 'id': 'may' }, { 'name': 'Jun', 'id': 'jun' }, { 'name': 'Jul', 'id': 'jul' }, { 'name': 'Aug', 'id': 'aug' }, { 'name': 'Sep', 'id': 'sep' }, { 'name': 'Oct', 'id': 'oct' }, { 'name': 'Nov', 'id': 'nov' }, { 'name': 'Dec', 'id': 'dec' },
            ],
            months_old: [
                { 'name': 'Jan', 'id': '1' }, { 'name': 'Feb', 'id': '2' }, { 'name': 'Mar', 'id': '3' }, { 'name': 'Apr', 'id': '4' }, { 'name': 'May', 'id': '5' }, { 'name': 'Jun', 'id': '6' }, { 'name': 'Jul', 'id': '7' }, { 'name': 'Aug', 'id': '8' }, { 'name': 'Sep', 'id': '9' }, { 'name': 'Oct', 'id': '10' }, { 'name': 'Nov', 'id': '11' }, { 'name': 'Dec', 'id': '12' },
            ],
            quarter_months: [
                { 'name': '1st quarter', 'id': '1' }, { 'name': '2nd quarter', 'id': '2' }, { 'name': '3rd quarter', 'id': '3' }, { 'name': '4th quarter', 'id': '4' },

            ],
            companis: [
                { 'id': 1100, 'name': 1100 }, { 'id': 1200, 'name': 1200 }, { 'id': 1300, 'name': 1300 }, { 'id': 1400, 'name': 1400 }, { 'id': 1700, 'name': 1700 }, { 'id': 1800, 'name': 1800 }
            ],
            formatAMPM(date) {
                // var hours = date.getHours();
                // var minutes = date.getMinutes();
                const myArr = date.split(":");
                var hours = myArr[0];
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                var minutes = myArr[1];
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var strTime = hours + ':' + minutes + '' + ampm;
                return strTime;
            },
            factory_old: [
                { "id": 50, "name": "Factory (Brass Rod)" },
                { "id": 110, "name": "Factory (Cable)" },
                { "id": 27, "name": "Factory (Electronics)" },
                { "id": 25, "name": "Factory (Fan)" },
                { "id": 24, "name": "Factory (IR Bulb)" },
                { "id": 69, "name": "Factory Operation (Access, Brass)" },
                { "id": 30, "name": "Factory (Tissue)" }
            ],

            format_Date(value) {
                return moment(String(value)).format('YYYY-MM-DD');
            },

            amountConvert(num, digits) {
                var si = [
                    { value: 1, symbol: "" }, { value: 1E3, symbol: "k" }, { value: 1E6, symbol: "M" }, { value: 1E9, symbol: "G" }, { value: 1E12, symbol: "T" }, { value: 1E15, symbol: "P" }, { value: 1E18, symbol: "E" }
                ];
                var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
                var i;
                for (i = si.length - 1; i > 0; i--) {
                    if (num >= si[i].value) {
                        break;
                    }
                }
                return (num / si[i].value).toFixed(digits).replace(rx, "$1") + si[i].symbol;
            },


            formatPrice(val) {

                val = Number(val);
                if (val) {
                    val = val.toFixed(0);
                    return val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                } else {
                    return 0;
                }

            },
            async getMonth() {
                return await axios.get(this.api_url + "months", {
                    headers: {
                        "Content-Type": "application/json",
                        //   Authorization: this.$localStorage.get("d_token")
                        //     ? `Bearer ${this.$localStorage.get("d_token")}`
                        //     : "",
                    },
                });
            },


            async getDepartments(status = null) {
                let where = "?";

                if (status) {
                    where += "status=" + status;
                }
                return await axios.get(this.api_url + "departments" + where, {
                    headers: {
                        "Content-Type": "application/json",
                        //   Authorization: this.$localStorage.get("d_token")
                        //     ? `Bearer ${this.$localStorage.get("d_token")}`
                        //     : "",
                    },
                });
            },

            async getDepartment(dept_id = null) {

                let deptid = null;
                if (dept_id) {
                    deptid = dept_id;
                } else {
                    let user_data = JSON.parse(this.$localStorage.get("user")).data;
                    deptid = user_data.department;
                }
                console.log('qwertyu');
                console.log(deptid);
                return await axios.get(this.api_url + "singel_dept/" + deptid, {
                    headers: {
                        "Content-Type": "application/json",
                        //   Authorization: this.$localStorage.get("d_token")
                        //     ? `Bearer ${this.$localStorage.get("d_token")}`
                        //     : "",
                    },
                });
            },

            async getItem(url) {
                return await axios.get(this.api_url + url, {
                    headers: {
                        "Content-Type": "application/json",
                        //   Authorization: this.$localStorage.get("d_token")
                        //     ? `Bearer ${this.$localStorage.get("d_token")}`
                        //     : "",
                    },
                });
            },
            async getData(path, setData) {
                // let loader = this.$loading.show();
                try {
                    await axios
                        .get(this.api_url + path, {
                            headers: {
                                "Content-Type": "application/json",
                                // Authorization: this.token ? `Bearer ${this.token}` : "",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                this[setData] = data.data;
                                if (data.access) {
                                    this.userAccess = data.access;
                                }
                                // console.log(this[setData]);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    console.log(error);
                    if (error.response.status == 401) {
                        this.$router.push("/login");
                    }
                    // loader.hide();
                }
            },

            getDeptSelect2() {
                // let loader = this.$loading.show();
                try {
                    axios
                        .get(this.api_url + "departmentSelect2", {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                this.departmentSelect2Aarry = data.data;
                                // console.log(this.departmentSelect2);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    // loader.hide();
                }
            },

            getSbuSelect2() {
                // let loader = this.$loading.show();
                try {
                    axios
                        .get(this.api_url + "sbuSelect2", {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                this.sbuSelect2Aarry = data.data;
                                // console.log(this.sbuSelect2Aarry);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    // loader.hide();
                }
            },
            getUnitSelect2() {
                // let loader = this.$loading.show();
                try {
                    axios
                        .get(this.api_url + "unitSelect2", {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                console.log(data);
                                this.unitSelect2Aarry = data.data;
                                // console.log(this.unitSelect2Aarry);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    // loader.hide();
                }
            },
            getSubUnitSelect2() {
                // let loader = this.$loading.show();
                try {
                    axios
                        .get(this.api_url + "subUnitSelect2", {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                console.log(data);
                                this.subUnitSelect2Aarry = data.data;
                                console.log(this.subUnitSelect2Aarry);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    // loader.hide();
                }
            },
            getSectionSelect2() {
                // let loader = this.$loading.show();
                try {
                    axios
                        .get(this.api_url + "sectionSelect2", {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                console.log(data);
                                this.sectionSelect2Aarry = data.data;
                                console.log(this.sectionSelect2Aarry);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    // loader.hide();
                }
            },
            getSubSectionSelect2() {
                // let loader = this.$loading.show();
                try {
                    axios
                        .get(this.api_url + "subSectionSelect2", {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                console.log(data);
                                this.subSectionSelect2Aarry = data.data;
                                console.log(this.subSectionSelect2Aarry);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    // loader.hide();
                }
            },

            getWorkLocationSelect2() {
                // let loader = this.$loading.show();
                try {
                    axios
                        .get(this.api_url + "workLocationSelect2", {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                console.log(data);
                                this.workLocationSelect2Aarry = data.data;
                                // console.log(this.workLocationSelect2Aarry);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    // loader.hide();
                }
            },
            getEmployeeSelect2() {
                // let loader = this.$loading.show();
                try {
                    axios
                        .get(this.api_url + "employeeSelect2", {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        })
                        .then(({ data }) => {
                            if (data.success) {
                                console.log(data);
                                this.employeeSelect2Aarry = data.data;
                                // console.log(this.employeeSelect2Aarry);
                            }
                            // loader.hide();
                        });
                } catch (error) {
                    // loader.hide();
                }
            },

            employeesSbu(option) {
                console.log('sss');
                this.sbu_id = option.id;
            },
            employeesSection(option) {
                this.section_id = option.id;
            },
            employeesSubSection(option) {
                this.subsection_id = option.id;
            },
            employeesGroup(option) {
                this.employee_group = option.id;
            },
            employeesSubUnit(option) {
                this.subunit_id = option.id;
            },
            employeesUnit(option) {
                this.unit_id = option.id;
            },
            employeesWorkLocation(option) {
                this.employee_work_location = option.id;
            },
            onSelectDepartment(option) {
                // let loader = this.$loading.show();
                this.department_id = option.id;
                // loader.hide();
                console.log(this.department_id);
            },
            onSelectEmployee(option) {
                this.form_data.employee_id = option.id;
            },
            // employeesSbu(option){
            //   this.sbu_id= option.id;
            //   console.log(this.sbu_id);
            // },
            // employeesSection(option){
            //   this.section_id= option.id;
            // },
            // employeesSubSection(option){
            //   this.subsection_id= option.id;
            // },
            // employeesGroup(option){
            //   this.employee_group= option.id;
            // },
            // employeesSubUnit(option){
            //   this.subunit_id= option.id;
            // },
            // employeesUnit(option){
            //   this.unit_id= option.id;
            // },
            // employeesWorkLocation(option){
            //   this.employee_work_location= option.id;
            // },
            // onSelectDepartment(option){
            //   this.department_id= option.id;
            //   console.log(this.department_id);
            // },
            // onSelectEmployee(option){
            //   this.form_data.employee_id = option.id;
            // },
        };
    }
})

const app = new Vue({
    router
}).$mount('#app');

var filter = function(text, length, clamp) {
    clamp = clamp || '...';
    var node = document.createElement('div');
    node.innerHTML = text;
    var content = node.textContent;
    return content.length > length ? content.slice(0, length) + clamp : content;
};

Vue.filter('truncate', filter);