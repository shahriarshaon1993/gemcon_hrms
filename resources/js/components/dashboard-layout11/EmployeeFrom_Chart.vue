<template>
  <div>
  <span v-if="page_loading">
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
      :series="chart.series"
      :customStyles="chart.customStyles"
    />
  </span>
  <span v-if="!page_loading">
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
  props: ['sbu_id'],
  components: {
    pageLoading: Loading,
    PieChart,
    
  },
  data () {
    return {
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
            y: 104
          }, {
            name: 'Dhaka',
            y: 197
          }, {
            name: 'Rajshahi',
            y: 140
          },
          {
            name: 'Sylhet',
            y: 104.67
          }, {
            name: 'Mymensingh',
            y: 224.18
          }, {
            name: 'Barisal',
            y: 111.64
          }, {
            name: 'Rangpur',
            y: 211.6
          }, {
            name: 'Khulna',
            y: 121.2
          },
          ]
        }],
        
      },
      series:'',
      sbu_nameValue:'',
      sbu_id_all:'',
    }
  },
  created() {
    this.employeesFrom();
    // this.sbu_id_all=JSON.parse(this.sbu_id);
  },
   methods: {
      employeesFrom(){
         this.page_loading = false;
      let uri = URL.baseUrl("home_dashboard/emp_from");
      axios.get(uri)
      .then((res) => {
         this.chart.series = [{ 
          data:this.employees_from = res.data.employee_from
        }];
         this.page_loading = true;
      })
        .catch((error) => {
          this.showToster({ status: 0, message: "opps! something went wrong" });
           this.page_loading = true;
        });
    },

   }
}
</script>