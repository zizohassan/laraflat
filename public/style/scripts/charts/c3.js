/**
 * C3 charts page
 */
(function() {
  'use strict';

  /******** Chart 1 ********/

  var chart = c3.generate({
    data: {
      columns: [
        ['data1', 30, 200, 100, 400, 150, 250, 50, 100, 250],
        ['data2', 50, 20, 10, 40, 15, 25, 50, 30, 40]
      ]
    }
  });
  setTimeout(function() {
    chart.load({
      columns: [
        ['data1', 230, 190, 300, 500, 300, 400, 300, 200, 250]
      ]
    });
  }, 1000);
  setTimeout(function() {
    chart.load({
      columns: [
        ['data3', 130, 150, 200, 300, 200, 100, 150, 160, 100]
      ]
    });
  }, 1500);
  setTimeout(function() {
    chart.unload({
      ids: 'data1'
    });
  }, 2000);

  /******** Chart 2 ********/

  c3.generate({
    bindto: '#chart2',
    data: {
      columns: [
        ['data1', 30, 200, 100, 400, 150, 250, 50, 100, 250],
        ['data2', 130, 100, 140, 200, 150, 50, 120, 80, 60]
      ],
      type: 'bar'
    },
    bar: {
      width: {
        ratio: 0.5
      }
    }
  });
})();
