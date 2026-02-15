<!-- innerRadius='40%' -->
<template>
    <div id="app">
         <ejs-accumulationchart id="container" :tooltip='tooltip' :tooltipRender='tooltipRender'>
            <e-accumulation-series-collection>
                <e-accumulation-series :dataSource='seriesData' xName='x' yName='y' :dataLabel='datalabel' :pointColorMapping=' pointColorMapping' radius='70%'> </e-accumulation-series>
            </e-accumulation-series-collection>
        </ejs-accumulationchart>
    </div>
</template>
<script>
import Vue from "vue";
import { AccumulationChartPlugin, PieSeries, AccumulationDataLabel, AccumulationTooltip } from "@syncfusion/ej2-vue-charts";

Vue.use(AccumulationChartPlugin);

export default {
  data() {
    return {
      seriesData: [
                { x: 'Late', y: 1243, fill: '#ffc107', text: 'L' },
                { x: 'Absent', y: 1222, fill: '#f41127', text: 'A' }, 
                { x: 'Present', y: 1230, fill: '#2fa95e', text:'P' },
            ],
            tooltip:{ enable: true },
            datalabel: { visible: true, name: 'text' },
            pointColorMapping: 'fill'
        };
  },
  provide: {
     accumulationchart: [PieSeries, AccumulationDataLabel, AccumulationTooltip]
  },
  methods: {
      tooltipRender: function(args) {
     if (args.point.index === 3) {
              args.text = args.point.x + '' + ':' + args.point.y + '' + ' ' +'customtext';
              args.textStyle.color = '#f48042';
        }
    }
  }
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