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
  props: ['seriesData'],
data() {
  return {
    sbu_id: 0,
    // tooltipRender: '',
    seriesData: [
        { x: 'Permanent', y: 0, fill: '#2fa95e', text: 'Perm.' },
        { x: 'Probationary', y: 0, fill: '#9399ff', text: 'Prob.' }, 
        { x: 'Cotractual', y: 0, fill: '#fd7e14', text:'Cotr.' },
        { x: 'Casual', y: 0, fill: '#ffc107', text:'Casu.' },
        { x: 'Temporary', y: 0, fill: '#ee14e0', text:'Temp.' },
        { x: 'Intern', y: 0, fill: '#0fcfa5', text:'Intern' },
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
  // this.employeesType(this.sbu_id);
},
methods: {
    tooltipRender: function(args) {
      if (args.point.index === 2) {
        args.text = args.point.x + '' + ':' + args.point.y + '' + ' ' +'customtext';
        args.textStyle.color = '#f48042';
      }
    },

  employeesType(sbu_id = null){
       // this.page_loading = false;
    let uri = URL.baseUrl("dashboard_emp_type/"+sbu_id);
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