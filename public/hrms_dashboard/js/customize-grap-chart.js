// Recruitment Outgoing Status start
Highcharts.chart('recruitmentOutgoingStatus', {
    chart: {
        type: 'column'
    },
    // title: {
    //     text: 'Browser market shares. January, 2015 to May, 2015'
    // },
    // subtitle: {
    //     text: 'Click the columns to view versions. Source: <a href="http://netmarketshare.com">netmarketshare.com</a>.'
    // },
    xAxis: {
        type: 'category'
    },
    // yAxis: {
    //     title: {
    //         text: 'Total percent market share'
    //     }

    // },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                // format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        // pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
    },

    series: [{
        name: 'Recruitment & Outgoing',
        colorByPoint: true,
        data: [{
            name: 'Jan',
            y: 58,
            drilldown: 'Jan'
        },
        {
            name: 'Feb',
            y: 69,
            drilldown: 'Feb'
        }, {
            name: 'Mar',
            y: 60,
            drilldown: 'Mar'
        }, {
            name: 'Apr',
            y: 31,
            drilldown: 'Apr'
        }, {
            name: 'May',
            y: 42,
            drilldown: 'May'
        }, {
            name: 'Jun',
            y: 49,
            drilldown: 'Jun'
        }]
    }],    
  
});
// Recruitment Outgoing Status end  


// Employee Type chart start  
(function(d3) {
  function getLabel(item) {
    return Object.keys(item)[0];
  }

  function getSeries(item) {
    return item[Object.keys(item)[0]];
  }

  var data = [{
      "Per": 704
    }, {
      "Con": 97
    }, 
    // {
    //   "Cas": 5400
    // }, 
    // {
    //   "Zelfstudie": 36
    // },
    {
      "Cas": 540
    }],
    dataLabels = data.map(getLabel),
    dataSeries = data.map(getSeries);

  var width = 960,
    height = 400,
    radius = height / 3 - 10
  thickness = 80;

  var arc = d3.arc()
    .innerRadius(radius - thickness / 2)
    .outerRadius(radius + thickness / 2),
    innerLabelArc = d3.arc()
    .outerRadius(radius)
    .innerRadius(radius),
    outerLabelArc = d3.arc()
    .outerRadius(radius + thickness * .8)
    .innerRadius(radius + thickness * .8);

  var pie = d3.pie()
    .padAngle(.02)
    .startAngle(-Math.PI / 2)
    .endAngle(Math.PI / 2)
    .sort(null);

  // var colors = ["#2fa95e", "#BC0", "#17a2b8", "#0AC", "#777", "#AAA", "#DDD", "#000"];
  var colors = ["#2fa95e", "#BC0", "#17a2b8"];

  var svg = d3.select("#js-pie-chart")
    .append("svg")
      .attr("class", "c-chart")
      .attr("height", "100%")
      // .attr("style", "border: 1px solid #DDD")
      .attr("viewBox", "315 30 350 300")
      .attr("width", "100%")
    .append("g")
     .attr("transform", "translate(" + width / 2 + "," + height * 5 / 8 + ")");

  svg.selectAll("path")
    .data(pie(dataSeries))
    .enter()
      .append("path")
      .style("fill", function(d, i) {
        return colors[i];
      })
      .attr("d", arc);

  var arcs = pie(dataSeries);
  arcs.forEach(function(d, i) {
    var iC = innerLabelArc.centroid(d);
    var oC = outerLabelArc.centroid(d);
    svg.append("text")
      .text(dataLabels[i])
      .style("fill", function() {
        return colors[i];
      })
      .attr("class", "c-chart__label c-chart__label--outer")
      .attr("x", function() {
        if (((d.startAngle + d.endAngle) / 2) < 0) {
          return oC[0] - this.getComputedTextLength();
        } else {
          return oC[0];
        }
      })
      .attr("y", function() {
        return oC[1] + this.getBBox().height / 2;
      });

    var angle = (d.endAngle - d.startAngle) * 180 / Math.PI;
    
    if (angle >= 6) {
      svg.append("text")
        .attr("class", "c-chart__label c-chart__label--inner")
        // .text(dataSeries[i] + " u.")
        .text(dataSeries[i])
        .attr("x", function() {
          return iC[0] - this.getBBox().width / 2;
        })
        .attr("y", function() {
          return iC[1] + this.getBBox().height / 2 - 3;
        });
    }
  });
  svg.append("text")
    .attr("class", "c-chart__label c-chart__label--center")
    // .text(dataSeries.reduce(function(a, b) {
    //   return a + b;
    // }) + " uur")

    // .text("Gemcon group corporate")

    .attr("x", function() {
      return -this.getBBox().width / 2;
    })
    .attr("y", function() {
      return -this.getBBox().height / 2;
    });

})(d3);
// Employee Type chart end 


// Employee Age Group Start
Highcharts.chart('employeeAgeGroup', {
    chart: {
        type: 'column'
    },
    // title: {
    //     text: 'Stacked column chart'
    // },
    xAxis: {
        categories: ['18-25Y', '26-35Y', '36-45Y', '46-55Y', '56-60Y', '60+Y']
    },
    yAxis: {
        min: 0,
        // title: {
        //     text: 'Total fruit consumption'
        // },
        stackLabels: {
            enabled: true,
            style: {
                // fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'center',
        // x: -30,
        verticalAlign: 'top',
        // y: 25,
        // floating: true,
        // backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        // borderColor: '#CCC',
        // borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b>',
        // pointFormat: '{series.name}: {point.y}%<br/>Total: {point.stackTotal}'
        // pointFormat: '{series.name}: {point.y}%<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                // enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }

    },

    // series: {
    //         borderWidth: 0,
    //         dataLabels: {
    //             enabled: true,
    //             format: '{point.y}%',
    //         }
    //     }

    series: [{
        name: '',
        data: [5, 3, 4, 7, 2, 6]
    }
    , 
    // {
    //     name: '',
    //     data: [2, 2, 3, 2, 1, 2, 4]
    // }, 
    {
        name: '',
        data: [3, 4, 4, 2, 5, 3, 5]
    }
    ]
});
// Employee Age Group End


// Unit Wise Employee Salary Start
Highcharts.chart('unitWiseEmployeeSalary', {
    chart: {
        type: 'column'
    },
    // title: {
    //     text: 'Stacked column chart'
    // },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']
    },
    yAxis: {
        min: 0,
        // title: {
        //     text: 'Total fruit consumption'
        // },
        stackLabels: {
            enabled: true,
            style: {
                // fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'center',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        // borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b>',
        // pointFormat: '{series.name}: {point.y}%<br/>Total: {point.stackTotal}'
        // pointFormat: '{series.name}: {point.y}%<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                // enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }

    },

    series: [{
        name: '',
        data: [5, 3, 4, 7, 2, 6, 8,]
    }, 
    // {
    //     name: 'Jane',
    //     data: [2, 2, 3, 2, 1]
    // }, {
    //     name: 'Joe',
    //     data: [3, 4, 4, 2, 5]
    // }
    ]
});
// Unit Wise Employee Salary End



(async () => {

    const topology = await fetch(
        'https://code.highcharts.com/mapdata/countries/bd/bd-all.topo.json'
    ).then(response => response.json());

    // Prepare demo data. The data is joined to map using value of 'hc-key'
    // property by default. See API docs for 'joinBy' for more info on linking
    // data and map.
    const data = [
        ['bd-da', 20], ['bd-kh', 11], ['bd-ba', 12], ['bd-cg', 13],
        ['bd-sy', 14], ['bd-rj', 15], ['bd-rp', 16]
    ];

    // Create the chart
    Highcharts.mapChart('container', {
        chart: {
            map: topology
        },

        // title: {
        //     text: 'Highcharts Maps basic demo'
        // },

        // subtitle: {
        //     text: 'Source map: <a href="http://code.highcharts.com/mapdata/countries/bd/bd-all.topo.json">Bangladesh</a>'
        // },

        // mapNavigation: {
        //     enabled: true,
        //     buttonOptions: {
        //         verticalAlign: 'bottom'
        //     }
        // },

        colorAxis: {
            min: 0
        },

        series: [{
            data: data,
            name: 'Random data',
            states: {
                hover: {
                    color: '#BADA55'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }]
    });

})();



