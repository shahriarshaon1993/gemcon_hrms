<template>
  <ColumnChart
    :title="chart.title"
    :subtitle="chart.subtitle"
    :backgroundColor="chart.backgroundColor"
    :gridLineColor="chart.gridLineColor"
    :thousandsSep="chart.thousandsSep"
    :decimalPoint="chart.decimalPoint"
    :height="chart.height"
    :yAxis="chart.yAxis"
    :xAxis="chart.xAxis"
    :series="chart.series"
    :crosshair="chart.crosshair"
    :customStyles="chart.customStyles"
    :plotOptions="chart.plotOptions"
  />
</template>

<script>
import { ColumnChart } from 'vuejs-highcharts'

export default {
  // name: 'ColumnChartSample',
  components: {
    ColumnChart
  },
  data () {
    return {
      chart: {
        // title: 'Column chart title',
        // subtitle: 'Column chart subtitle',
        backgroundColor: '#fff',
        // gridLineColor: '#ccd6eb',
        thousandsSep: '.',
        decimalPoint: ',',
        height: 350,
        xAxis: {
          // title: {
          //   text: 'xAxis title'
          // },
          categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec",]
          
        },
        // yAxis: {
        //   title: {
        //     text: 'yAxis title'
        //   }
        // },
        series: [
          {
            name: 'Unit Wise Emp. Salary',
            color: '#2fa95e',
            data: [160, 129, 120, 129, 144, 148, 150, 156, 163, 151, 143, 134,]            
          },
          {
            // name: 'Outgoing',
            // color: '#f41127',
            // data: [63.6, 68.8, 70.0, 90.4, 106.0, 110.0, 115, 120, 125, 132, 142, 150,]
            // data: [23, 29, 15, 38, 22, 60,]
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
        // plotOptions: {
        //   series: {
        //     borderWidth: 2,
        //     dataLabels: {
        //       enabled: true,
        //       format: '{point.y:.1f}%'
        //     }
        //   }
        // }
      }
    }
  }
}
</script>