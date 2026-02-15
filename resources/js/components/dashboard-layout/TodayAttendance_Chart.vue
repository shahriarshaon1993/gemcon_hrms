<!-- innerRadius='40%' -->
<template>
    <div id="app">
         <ejs-accumulationchart id="container" :tooltip='tooltip' :tooltipRender='tooltipRender'>
            <e-accumulation-series-collection>
                <e-accumulation-series :dataSource='seriesData_attendance' xName='x' yName='y' :dataLabel='datalabel' :pointColorMapping=' pointColorMapping' radius='70%'> </e-accumulation-series>
            </e-accumulation-series-collection>
        </ejs-accumulationchart>
    </div>
</template>
<script>
import Vue from "vue";
import { AccumulationChartPlugin, PieSeries, AccumulationDataLabel, AccumulationTooltip } from "@syncfusion/ej2-vue-charts";

Vue.use(AccumulationChartPlugin);

export default {
  props: ['seriesData_attendance'],
  data() {
    return {
      seriesData: [
      ],
      tooltip:{ enable: true },
      datalabel: { visible: true, name: 'text' },
      pointColorMapping: 'fill'
    };
  },
  provide: {
     accumulationchart: [PieSeries, AccumulationDataLabel, AccumulationTooltip]
  },
  created() {
    // this.todaysAttendance();
  },
  methods: {
    // tooltipRender: function(args) {
    //   if (args.point.index === 3) {
    //     args.text = args.point.x + '' + ':' + args.point.y + '' + ' ' +'customtext';
    //     args.textStyle.color = '#f48042';
    //   }
    // },
    // todaysAttendance(){
    //   let uri = URL.baseUrl("home_dashboard/emp_today_attendance");
    //   axios.get(uri)
    //   .then((res) => {
    //     this.seriesData = res.data.seriesData;
    //   })
    //   .catch((error) => {
    //     this.showToster({ status: 0, message: "opps! something went wrong" });
    //   });
    // },
  },
};
</script>
<style>
 #container {
     height: 330px;
     /*width: 250px;*/
     width: 120%;
     margin-left: -10%;
     margin-top: -120px !important;
     margin-bottom: -70px !important;     
 }
  #container_border{
    fill: transparent !important;
 }

</style>