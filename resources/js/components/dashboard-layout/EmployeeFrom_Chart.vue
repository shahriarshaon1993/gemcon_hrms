<template>
  <div>
    <!-- {{ chart_from_series }} -->
  <span v-if="page_loading_from">
    <PieChart
      :title="chart.title"
      :subtitle="chart.subtitle"
      :backgroundColor="chart.backgroundColor"
      :gridLineColor="chart.gridLineColor"
      :colors="chart.colors"
      :thousandsSep="chart.thousandsSep"
      :decimalPoint="chart.decimalPoint"
      :height="chart.height"
      :yAxis="chart.yAxis"
      :xAxis="chart.xAxis"
      :series="chart_from_series.series"
      :customStyles="chart.customStyles"
    />
  </span>
  <span v-if="!page_loading_from">
      <pageLoading></pageLoading>
  </span>
 <!--  <div>
    <vue-select v-model="sbu_nameValue" multiple="multiple" :options="sbu_id" @select="employeesSbu" placeholder="Select SBU Name" label="text" track-by="text"></vue-select>
    
  </div> -->
  
  </div>

</template>

<script>
import Loading from "../Loading.vue";
import { PieChart } from 'vuejs-highcharts'

export default {
  props: ['chart_from_series', 'page_loading_from'],
  components: {
    pageLoading: Loading,
    PieChart,
    
  },
  data () {
    return {
      sbu_id:1,
      chart: {
        // title: 'Pie chart title',
        // subtitle: 'Pie chart subtitle',
        backgroundColor: '#fff',
        gridLineColor: '#ccd6eb',
        colors: [
          '#fdcd01',
          '#ffec47',
          '#a1c653',
          '#5baca7',
          '#61a6df',
          '#62aec5',
          '#904576',
          '#c04999',
          '#eb4f88',
          '#f15958',
          '#df8135',
          '#fd970f',
        ],
        company_sbuDataE:'',
        thousandsSep: '.',
        decimalPoint: ',',
        height: 280,
        xAxis: {
          
        },

        series: [{
          data: [
          {
            name: 'Chittagong',
            y: 0
          }, {
            name: 'Dhaka '.y,
            y: 0
          }, {
            name: 'Rajshahi',
            y: 0
          },
          {
            name: 'Sylhet',
            y: 0
          }, {
            name: 'Mymensingh',
            y: 0
          }, {
            name: 'Barisal',
            y: 0
          }, {
            name: 'Rangpur',
            y: 0
          }, {
            name: 'Khulna',
            y: 0
          },
          ]
        }],
        
      },
      // series:'',
      sbu_nameValue:'',
      sbu_id_all:'',
    }
  },
  created() {
    // this.employeesFrom(this.sbu_id);
    // this.sbu_id_all=JSON.parse(this.sbu_id);
  },
  //  methods: {
  //     employeesFrom(sbu_id = null){
  //       console.log(sbu_id);
  //       console.log('ffff');
  //       this.page_loading = false;
  //       let uri = URL.baseUrl("dashboard_emp_from/"+sbu_id);
  //       axios.get(uri)
  //       .then((res) => {
  //         this.chart.series = [{ 
  //           data:this.employees_from = res.data.employee_from
  //         }];
  //         this.page_loading = true;
  //       })
  //       .catch((error) => {
  //         this.showToster({ status: 0, message: "opps! something went wrong" });
  //          this.page_loading = true;
  //       });
  //     },
  //  }
}
</script>