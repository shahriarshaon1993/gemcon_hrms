<template>
  <span v-if="ro_chart">
    <ColumnChart
      :title="chart.title"
      :subtitle="chart.subtitle"
      :backgroundColor="chart.backgroundColor"
      :gridLineColor="chart.gridLineColor"
      :thousandsSep="chart.thousandsSep"
      :decimalPoint="chart.decimalPoint"
      :height="chart.height"
      :yAxis="chart.yAxis"
      :xAxis="ro_chart.xAxis"
      :series="ro_chart.series"
      :crosshair="chart.crosshair"
      :customStyles="chart.customStyles"
      :plotOptions="chart.plotOptions"
    />
  </span>
  <span v-else>
    No data!
  </span>

</template>

<script>
import { ColumnChart } from 'vuejs-highcharts'

export default {
  // name: 'ColumnChartSample',
  components: {
    ColumnChart
  },
  props: ['ro_chart'],
  data () {
    return {
      chart: {
        title: 'wesrdtyuiop',
        subtitle: '',
        backgroundColor: '#fff',
        gridLineColor: '',
        thousandsSep: '.',
        decimalPoint: ',',
        height: 350,
        xAxis: {
          title: {
            text: 'xAxis title'
          },
          categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec",]
          // categories: []
        },
        yAxis: {
          title: {
            text: 'yAxis title'
          }
        },
        series: [
          {
            name: 'Recruitment',
            color: '#2fa95e',
            // data: [160.9, 129.5, 120.4, 129.2, 144.0, 148.3, 150, 156, 163, 171, 183, 164,]
            data: []
          },
          {
            name: 'Outgoing',
            color: '#f41127',
            // data: [63.6, 68.8, 70.0, 90.4, 106.0, 110.0, 115, 120, 125, 132, 142, 150,]
            data: []
          }
        ],
        crosshair: true,
        customStyles: {
          // color: '#666',
          // fontFamily: 'Nunito Sans'
        },
        // plotOptions: {
        //   column: {
        //     borderRadius: 2
        //   }
        // }
        plotOptions: {
          series: {
            borderWidth: 2,
            dataLabels: {
              enabled: true,
              // format: '{point.y:.1f}%'
              format: '{point.y:.0f}'
            }
          }
        }
      }
    }
  },
  created() {
    // this.findRecruitingOutgoing();
    // this.sbu_id_all=JSON.parse(this.sbu_id);
  },
   methods: {
  }
}
</script>