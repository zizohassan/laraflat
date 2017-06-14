/**
 * JVectormap demo page
 */
(function($) {
  'use strict';

  $('.world-map').vectorMap({
    map: 'world_mill_en',
    series: {
      regions: [{
        values: gdpData,
        scale: ['#efefef', '#c2c2c2'],
        normalizeFunction: 'polynomial'
      }]
    },
    onRegionTipShow: function(e, el, code) {
      el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
    },
    backgroundColor: 'transparent',
    zoomOnScroll: false,
    strokeWidth: 1,
    regionStyle: {
      initial: {
        fill: '#ccc',
        'fill-opacity': 0.7,
        stroke: '#c2c2c2',
        'stroke-width': 0.1,
        'stroke-opacity': 1
      },
      hover: {
        'fill-opacity': 0.3
      }
    }
  });

})(jQuery);
