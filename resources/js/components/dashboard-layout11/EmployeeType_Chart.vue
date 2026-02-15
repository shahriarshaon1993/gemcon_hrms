<!-- innerRadius='40%' -->
<template>
  <div id="app">
       <ejs-accumulationchart id="container1" :tooltip='tooltip' :tooltipRender='tooltipRender'>
          <e-accumulation-series-collection>
              <e-accumulation-series :dataSource='seriesData' xName='x' yName='y' :dataLabel='datalabel' :pointColorMapping=' pointColorMapping' radius='70%' innerRadius='40%'> </e-accumulation-series>
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
              { x: 'Permanent', y: 1243, fill: '#2fa95e', text: 'Per' },
              { x: 'Probationary', y: 1222, fill: '#9399ff', text: 'Pro' }, 
              { x: 'Cotractual', y: 1210, fill: '#fd7e14', text:'Cot' },
              { x: 'Casual', y: 320, fill: '#ffc107', text:'Cas' },
              { x: 'Temporary', y: 410, fill: '#ee14e0', text:'Tem' },
              { x: 'Intern', y: 330, fill: '#0fcfa5', text:'Int' },
          ],
          tooltip:{ enable: true },
          datalabel: { visible: true, name: 'text' },
          pointColorMapping: 'fill',

      };
},
provide: {
   accumulationchart: [PieSeries, AccumulationDataLabel, AccumulationTooltip]
},
created() {
  this.employeesType();
},
methods: {
  //   tooltipRender: function(args) {
  //  if (args.point.index === 2) {
  //           args.text = args.point.x + '' + ':' + args.point.y + '' + ' ' +'customtext';
  //           args.textStyle.color = '#f48042';
  //     }
  // }

  employeesType(){
       // this.page_loading = false;
    let uri = URL.baseUrl("home_dashboard/emp_type");
    axios.get(uri)
    .then((res) => {
       this.seriesData = res.data.employee_by_type;
       // this.page_loading = true;
    })
      .catch((error) => {
        this.showToster({ status: 0, message: "opps! something went wrong" });
         // this.page_loading = true;
      });
  },

}
};
</script>
<style>
#container1 {
   height: 240px;
   /*width: 250px;*/
   width: 120%;
   margin-left: -10%;
   margin-top: -120px !important;
   margin-bottom: -40px !important;     
}
#container1_border{
  fill: transparent !important;
}

</style>