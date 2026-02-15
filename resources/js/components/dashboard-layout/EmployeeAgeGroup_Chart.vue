<template >
 
  <ColumnChart style="height:450px !important;"
    :title="chart.title"
    :subtitle="chart.subtitle"
    :backgroundColor="chart.backgroundColor"
    :gridLineColor="chart.gridLineColor"
    :thousandsSep="chart.thousandsSep"
    :decimalPoint="chart.decimalPoint"
    :height="chart.height"
    :yAxis="chart.yAxis"
    :xAxis="chart.xAxis"
    :series="chart_series.series"
    :crosshair="chart.crosshair"
    :customStyles="chart.customStyles"
    :plotOptions="chart.plotOptions"
    
  />
</template>

<script>
import { ColumnChart } from 'vuejs-highcharts'

export default {
  components: {
    ColumnChart
  },
  props: ['chart_series'],
  data () {
    return {
      employees_from:'',
      chart: {
        type: 'column',
        styledMode: true,
        backgroundColor: '#fff',
        // gridLineColor: '#ccd6eb',
        gridLineColor: '',
        thousandsSep: '.',
        decimalPoint: ',',
        height: 460,
        xAxis: {
          title: {
            text: 'xAxis title'
          },
          categories: ["18-25Y","26-35Y","36-45Y","46-55Y","56-60Y","60+ Y"]
        },
        yAxis: {
          title: {
            text: 'yAxis title'
          }
        },       

        series: [{
              name: "Age Group",              
              colorByPoint: true,
              data: [{
                name: "18-25Y",
                y: 25.74,
                drilldown: "18-25Y",
                color: '#efefef',
              }, {
                name: "26-35Y",
                y: 50.57,
                drilldown: "26-35Y",
              }, {
                name: "36-45Y",
                y: 38.23,
                drilldown: "36-45Y"
              }, {
                name: "46-55Y",
                y: 65.58,
                drilldown: "46-55Y"
              }, {
                name: "56-60Y",
                y: 45.02,
                drilldown: "56-60Y"
              },{
                name: "60+Y",
                y: 20.62,
                drilldown: null
              }]
            }],

        crosshair: true,
        customStyles: {

        },

        plotOptions: {          
          series: {
            // color: '#000',
            borderWidth: 8,
            dataLabels: {
              enabled: true,
              // format: '{point.y:.1f}%'
              format: '{point.y:.0f}%'
            }
          }
        }
      }
    }},
    created() {
      // this.employeeAgeGroup();
    },
    methods: {
      employeeAgeGroup(){
            let uri = URL.baseUrl("home_dashboard/emp_age_group");
            axios.get(uri)
            .then((res) => {
              // this.chart=res.data.chart;
              this.chart.series=[{ 
                colorByPoint: true,
                data:res.data.employeeAgeGroup,
              }];
              this.chart.plotOptions.series={
                 borderWidth: 4,
                dataLabels:res.data.dataLabels,
              }
              // this.chart.series= res.data.employeeAgeGroup;
              console.log(res);            
            })
              .catch((error) => {
                this.showToster({ status: 0, message: "opps! something went wrong" });
              });
      }
    }
  }

</script>
<style type="text/css">
  rect.highcharts-point.highcharts-color-0 {
      stroke: #2fa95e !important;
      fill: #2fa95e !important;
    }
  rect.highcharts-point.highcharts-color-1 {
      stroke: #2fa95e !important;
      fill: #2fa95e !important;
    }
  rect.highcharts-point.highcharts-color-2 {
      stroke: #2fa95e !important;
      fill: #2fa95e !important;
    }
  rect.highcharts-point.highcharts-color-3 {
      stroke: #2fa95e !important;
      fill: #2fa95e !important;
    }
  rect.highcharts-point.highcharts-color-4 {
      stroke: #ffc107 !important;
      fill: #ffc107 !important;
    }
  rect.highcharts-point.highcharts-color-5 {
      stroke: #f41127 !important;
      fill: #f41127 !important;
    }
</style>