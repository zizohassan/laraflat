/**
 * ChartJS chart page
 */
(function($) {
  'use strict';

  //Global defaults
  Chart.defaults.global.responsive = true;
  Chart.defaults.global.defaultFontFamily = $.constants.font;
  Chart.defaults.global.defaultFontSize = 12;
  //Title
  Chart.defaults.global.title.fontFamily = $.constants.font;
  Chart.defaults.global.title.fontStyle = 'normal';
  //Tooltip
  Chart.defaults.global.tooltips.FontFamily = $.constants.font;
  Chart.defaults.global.tooltips.FontSize = 12;
  Chart.defaults.global.elements.arc.borderWidth = 1;
  Chart.defaults.global.elements.line.borderWidth = 1;

  var randomData = function() {
    return Math.round(Math.random() * 100);
  };

  //Bar chart data
  var randomScalingFactor = function() {
    return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
  };
  var barChartData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
      label: 'Dataset 1',
      backgroundColor: $.constants.primary,
      data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
    }, {
      label: 'Dataset 2',
      backgroundColor: $.constants.success,
      data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
    }, {
      label: 'Dataset 3',
      backgroundColor: $.constants.info,
      data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
    }]
  };

  //Line chart data
  var lineChartData = {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
      label: 'My dataset',
      data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()],
      yAxisID: 'y-axis-1',
      pointRadius: 0,
      borderColor: $.constants.primary,
      backgroundColor: $.constants.primary,
      pointBorderWidth: 0.5
    }]
  };

  //Doughnut chart data
  var doughnutData = {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [
          randomData(),
          randomData(),
          randomData(),
          randomData(),
          randomData()
        ],
        backgroundColor: [
          $.constants.primary,
          $.constants.success,
          $.constants.info,
          $.constants.danger,
          $.constants.default
        ],
        label: 'Dataset 1'
      }, {
        hidden: true,
        data: [
          randomData(),
          randomData(),
          randomData(),
          randomData(),
          randomData()
        ],
        backgroundColor: [
          $.constants.primary,
          $.constants.success,
          $.constants.info,
          $.constants.danger,
          $.constants.default
        ],
        label: 'Dataset 2'
      }, {
        data: [
          randomData(),
          randomData(),
          randomData(),
          randomData(),
          randomData()
        ],
        backgroundColor: [
          $.constants.primary,
          $.constants.success,
          $.constants.info,
          $.constants.danger,
          $.constants.default
        ],
        label: 'Dataset 3'
      }],
      labels: [
        'Primary',
        'Success',
        'Info',
        'Danger',
        'Default'
      ]
    },
    options: {
      legend: {
        position: 'top'
      },
      title: {
        display: true,
        text: 'Chart.js Doughnut Chart'
      },
      animation: {
        animateScale: true,
        animateRotate: true
      }
    }
  };

  //Radar chart data
  var radarData = {
    type: 'radar',
    data: {
      labels: ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
      datasets: [{
        label: 'My First dataset',
        backgroundColor: 'rgba(76, 127, 240, .2)',
        pointBackgroundColor: 'rgba(76, 127, 240, 1)',
        data: [randomData(), randomData(), randomData(), randomData(), randomData(), randomData(), randomData()]
      }, {
        label: 'Hidden dataset',
        hidden: true,
        data: [randomData(), randomData(), randomData(), randomData(), randomData(), randomData(), randomData()]
      }, {
        label: 'My Second dataset',
        backgroundColor: 'rgba(127, 195, 92, .2)',
        pointBackgroundColor: 'rgba(127, 195, 92, 1)',
        hoverPointBackgroundColor: '#fff',
        pointHighlightStroke: 'rgba(151,187,205,1)',
        data: [randomData(), randomData(), randomData(), randomData(), randomData(), randomData(), randomData()]
      }]
    },
    options: {
      legend: {
        position: 'top'
      },
      title: {
        display: true,
        text: 'Chart.js Radar Chart'
      },
      scale: {
        reverse: false,
        ticks: {
          beginAtZero: true
        }
      }
    }
  };

  //Pie chart data
  var pieData = {
    type: 'pie',
    data: {
      datasets: [{
        data: [
          randomData(),
          randomData(),
          randomData(),
          randomData(),
          randomData()
        ],
        backgroundColor: [
          $.constants.primary,
          $.constants.success,
          $.constants.info,
          $.constants.danger,
          $.constants.default
        ]
      }, {
        data: [
          randomData(),
          randomData(),
          randomData(),
          randomData(),
          randomData()
        ],
        backgroundColor: [
          $.constants.primary,
          $.constants.success,
          $.constants.info,
          $.constants.danger,
          $.constants.default
        ]
      }, {
        data: [
          randomData(),
          randomData(),
          randomData(),
          randomData(),
          randomData()
        ],
        backgroundColor: [
          $.constants.primary,
          $.constants.success,
          $.constants.info,
          $.constants.danger,
          $.constants.default
        ]
      }],
      labels: [
        'Primary',
        'Success',
        'Info',
        'Danger',
        'Default'
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Chart.js Pie Chart'
      }
    }
  };

  //Polar chart data
  var polarData = {
    data: {
      datasets: [{
        data: [
          randomData(),
          randomData(),
          randomData(),
          randomData(),
          randomData()
        ],
        backgroundColor: [
          $.constants.primary,
          $.constants.success,
          $.constants.info,
          $.constants.danger,
          $.constants.default
        ],
        label: 'My dataset' // for legend
      }],
      labels: [
        'Primary',
        'Success',
        'Info',
        'Danger',
        'Default'
      ]
    },
    options: {
      legend: {
        position: 'top'
      },
      title: {
        display: true,
        text: 'Chart.js Polar Area Chart'
      },
      scale: {
        ticks: {
          beginAtZero: true
        },
        reverse: false
      },
      animation: {
        animateRotate: false
      }
    }
  };

  //Render charts
  window.onload = function() {
    //Polar chart
    var polar = document.getElementById('polar');
    window.myPolarArea = Chart.PolarArea(polar, polarData);
    //Pie chart
    var pie = document.getElementById('pie').getContext('2d');
    window.myPie = new Chart(pie, pieData);
    //Radar chart
    window.myRadar = new Chart(document.getElementById('radar'), radarData);
    //Doughnut chart
    var doughnut = document.getElementById('doughnut').getContext('2d');
    window.myDoughnut = new Chart(doughnut, doughnutData);
    //Bar chart
    var bar = document.getElementById('bar').getContext('2d');
    window.myBar = new Chart(bar, {
      type: 'bar',
      data: barChartData,
      options: {
        title: {
          display: true,
          text: 'Chart.js Bar Chart - Stacked'
        },
        tooltips: {
          mode: 'label'
        },
        scales: {
          xAxes: [{
            stacked: true
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }
    });
    //Line chart
    var ctx = document.getElementById('line').getContext('2d');
    console.log(lineChartData);
    window.myLine = Chart.Line(ctx, {
      data: lineChartData,
      options: {
        hoverMode: 'label',
        stacked: false,
        title: {
          display: true,
          text: 'Chart.js Line Chart - Multi Axis'
        },
        scales: {
          xAxes: [{
            display: true,
            gridLines: {
              offsetGridLines: false
            }
          }],
          yAxes: [{
            type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
            display: true,
            position: 'left',
            id: 'y-axis-1'
          }, {
            // grid line settings
            gridLines: {
              drawOnChartArea: false // only want the grid lines for one axis to show up
            }
          }]
        }
      }
    });
  };
})(jQuery);
