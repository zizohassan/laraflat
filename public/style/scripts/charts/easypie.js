/**
 * Easypie chart page
 */
(function($) {
  'use strict';

  $('.bounce').easyPieChart({
    size: 180,
    lineWidth: 8,
    barColor: $.constants.success,
    trackColor: 'rgba(0,0,0,.1)',
    lineCap: 'butt',
    easing: 'easeOutBounce',
    onStep: function(from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });

  $('.visitor').easyPieChart({
    size: 180,
    lineWidth: 15,
    barColor: $.constants.success,
    trackColor: false,
    lineCap: 'round',
    easing: 'easeOutBounce',
    onStep: function(from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });

  $('.newvisitor').easyPieChart({
    size: 180,
    lineWidth: 15,
    barColor: $.constants.success,
    trackColor: 'rgba(0,0,0,.1)',
    lineCap: 'butt',
    easing: 'easeOutBounce',
    onStep: function(from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });

  $('.signup').easyPieChart({
    size: 180,
    lineWidth: 8,
    barColor: $.constants.success,
    trackColor: 'rgba(0,0,0,.1)',
    lineCap: 'butt',
    easing: 'easeOutBounce',
    onStep: function(from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });

  $('.downtime').easyPieChart({
    size: 180,
    lineWidth: 8,
    barColor: $.constants.success,
    trackColor: 'rgba(0,0,0,.1)',
    lineCap: 'round',
    easing: 'easeOutBounce',
    scaleColor: false,
    onStep: function(from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });

  $('.purge').easyPieChart({
    size: 180,
    lineWidth: 2,
    barColor: $.constants.success,
    trackColor: 'rgba(0,0,0,.1)',
    lineCap: 'round',
    easing: 'easeOutBounce',
    scaleColor: false,
    onStep: function(from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });

  $('.piechart').each(function() {
    var canvas = $(this).find('canvas');
    $(this).css({
      'width': canvas.width(),
      'height': canvas.height()
    });
  });

})(jQuery);
