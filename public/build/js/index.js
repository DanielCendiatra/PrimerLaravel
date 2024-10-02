

$(function () {
  "use strict";


  // // chart 1

  // var options = {
  //   series: [{
  //     name: "Net Sales",
  //     data: [4, 10, 25, 12, 25, 18, 40, 22, 7]
  //   }],
  //   chart: {
  //     //width:150,
  //     height: 105,
  //     type: 'area',
  //     sparkline: {
  //       enabled: !0
  //     },
  //     zoom: {
  //       enabled: false
  //     }
  //   },
  //   dataLabels: {
  //     enabled: false
  //   },
  //   stroke: {
  //     width: 1.7,
  //     curve: 'smooth'
  //   },
  //   fill: {
  //     type: 'gradient',
  //     gradient: {
  //       shade: 'dark',
  //       gradientToColors: ['#02c27a'],
  //       shadeIntensity: 1,
  //       type: 'vertical',
  //       opacityFrom: 0.5,
  //       opacityTo: 0.0,
  //       //stops: [0, 100, 100, 100]
  //     },
  //   },

  //   colors: ["#02c27a"],
  //   tooltip: {
  //     theme: "dark",
  //     fixed: {
  //       enabled: !1
  //     },
  //     x: {
  //       show: !1
  //     },
  //     y: {
  //       title: {
  //         formatter: function (e) {
  //           return ""
  //         }
  //       }
  //     },
  //     marker: {
  //       show: !1
  //     }
  //   },
  //   xaxis: {
  //     categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
  //   }
  // };

  // var chart = new ApexCharts(document.querySelector("#chart1"), options);
  // chart.render();





  // // chart 2

  // var options = {
  //   series: [78],
  //   chart: {
  //     height: 180,
  //     type: 'radialBar',
  //     toolbar: {
  //       show: false
  //     }
  //   },
  //   plotOptions: {
  //     radialBar: {
  //        startAngle: -115,
  //        endAngle: 115,
  //       hollow: {
  //         margin: 0,
  //         size: '80%',
  //         background: 'transparent',
  //         image: undefined,
  //         imageOffsetX: 0,
  //         imageOffsetY: 0,
  //         position: 'front',
  //         dropShadow: {
  //           enabled: false,
  //           top: 3,
  //           left: 0,
  //           blur: 4,
  //           opacity: 0.24
  //         }
  //       },
  //       track: {
  //         background: 'rgba(0, 0, 0, 0.1)',
  //         strokeWidth: '67%',
  //         margin: 0, // margin is in pixels
  //         dropShadow: {
  //           enabled: false,
  //           top: -3,
  //           left: 0,
  //           blur: 4,
  //           opacity: 0.35
  //         }
  //       },

  //       dataLabels: {
  //         show: true,
  //         name: {
  //           offsetY: -10,
  //           show: false,
  //           color: '#888',
  //           fontSize: '17px'
  //         },
  //         value: {
  //           offsetY: 10,
  //           color: '#111',
  //           fontSize: '24px',
  //           show: true,
  //         }
  //       }
  //     }
  //   },
  //   fill: {
  //     type: 'gradient',
  //     gradient: {
  //       shade: 'dark',
  //       type: 'horizontal',
  //       shadeIntensity: 0.5,
  //       gradientToColors: ['#0866ff'],
  //       inverseColors: true,
  //       opacityFrom: 1,
  //       opacityTo: 1,
  //       stops: [0, 100]
  //     }
  //   },
  //   colors: ["#fc185a"],
  //   stroke: {
  //     lineCap: 'round'
  //   },
  //   labels: ['Total Orders'],
  // };

  // var chart = new ApexCharts(document.querySelector("#chart2"), options);
  // chart.render();



  // chart 3

  // var options = {
  //   series: [{
  //     name: "Net Sales",
  //     data: [8, 10, 25, 18, 38, 24, 20, 16, 7]
  //   }],
  //   chart: {
  //     //width:150,
  //     height: 120,
  //     type: 'bar',
  //     sparkline: {
  //       enabled: !0
  //     },
  //     zoom: {
  //       enabled: false
  //     }
  //   },
  //   dataLabels: {
  //     enabled: false
  //   },
  //   stroke: {
  //     width: 1,
  //     curve: 'smooth',
  //     color: ['transparent']
  //   },
  //   fill: {
  //     type: 'gradient',
  //     gradient: {
  //       shade: 'dark',
  //       gradientToColors: ['#fc6718'],
  //       shadeIntensity: 1,
  //       type: 'vertical',
  //       //opacityFrom: 0.8,
  //       //opacityTo: 0.1,
  //       //stops: [0, 100, 100, 100]
  //     },
  //   },
  //   colors: ["#fc185a"],
  //   plotOptions: {
  //     bar: {
  //       horizontal: false,
  //       borderRadius: 4,
  //       borderRadiusApplication: 'around',
  //       borderRadiusWhenStacked: 'last',
  //       columnWidth: '45%',
  //     }
  //   },

  //   tooltip: {
  //     theme: "dark",
  //     fixed: {
  //       enabled: !1
  //     },
  //     x: {
  //       show: !1
  //     },
  //     y: {
  //       title: {
  //         formatter: function (e) {
  //           return ""
  //         }
  //       }
  //     },
  //     marker: {
  //       show: !1
  //     }
  //   },
  //   xaxis: {
  //     categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
  //   }
  // };

  // var chart = new ApexCharts(document.querySelector("#chart3"), options);
  // chart.render();

  // chart 4

  fetch('/tasks/chart-data')
  .then(response => response.json())
  .then(data => {
    var options = {
      series: data.series, // Datos traídos desde el controlador
      chart: {
        foreColor: "#9ba7b2",
        height: 235,
        type: 'bar',
        toolbar: {
          show: false,
        },
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 4,
        curve: 'smooth',
        colors: ['transparent']
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          gradientToColors: ['#0d6efd', '#6f42c1', '#20c997', '#ffc107', '#0dcaf0', '#dc3545', '#198754', '#fd7e14', '#d63384'],
          shadeIntensity: 1,
          type: 'vertical',
          stops: [0, 100, 100, 100]
        },
      },
      colors: ['#0d6efd', '#6f42c1', '#20c997', '#ffc107', '#0dcaf0', '#dc3545', '#198754', '#fd7e14', '#d63384'],
      plotOptions: {
        bar: {
          horizontal: false,
          borderRadius: 4,
          columnWidth: '95%',
        }
      },
      grid: {
        show: false,
        borderColor: 'rgba(0, 0, 0, 0.15)',
        strokeDashArray: 4,
      },
      tooltip: {
        theme: "dark",
        x: {
          show: true
        },
      },
      xaxis: {
        categories: data.categories, // Meses traídos desde el controlador
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart4"), options);
    chart.render();
  });

  
  // chart 5

  // var options = {
  //   series: [{
  //     name: "Net Sales",
  //     data: [4, 10, 25, 12, 25, 18, 40, 22, 7]
  //   }],
  //   chart: {
  //     //width:150,
  //     height: 115,
  //     type: 'area',
  //     sparkline: {
  //       enabled: !0
  //     },
  //     zoom: {
  //       enabled: false
  //     }
  //   },
  //   dataLabels: {
  //     enabled: false
  //   },
  //   stroke: {
  //     width: 1.7,
  //     curve: 'smooth'
  //   },
  //   fill: {
  //     type: 'gradient',
  //     gradient: {
  //       shade: 'dark',
  //       gradientToColors: ['#6610f2'],
  //       shadeIntensity: 1,
  //       type: 'vertical',
  //       opacityFrom: 0.5,
  //       opacityTo: 0.0,
  //       //stops: [0, 100, 100, 100]
  //     },
  //   },

  //   colors: ["#6610f2"],
  //   tooltip: {
  //     theme: "dark",
  //     fixed: {
  //       enabled: !1
  //     },
  //     x: {
  //       show: !1
  //     },
  //     y: {
  //       title: {
  //         formatter: function (e) {
  //           return ""
  //         }
  //       }
  //     },
  //     marker: {
  //       show: !1
  //     }
  //   },
  //   xaxis: {
  //     categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
  //   }
  // };

  // var chart = new ApexCharts(document.querySelector("#chart5"), options);
  // chart.render();





});