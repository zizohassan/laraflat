/**
 * Calendar app page
 */
(function($) {
  'use strict';

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  var eventsData = [{
    title: 'All Day Event',
    start: new Date(y, m, 1),
    listColor: 'danger',
    className: ['bg-danger']
  }, {
    title: 'Long Event',
    start: new Date(y, m, d - 5),
    end: new Date(y, m, d - 2),
    listColor: 'success',
    className: ['bg-success']
  }, {
    id: 999,
    title: 'Repeating Event',
    start: new Date(y, m, d - 3, 16, 0),
    allDay: false,
    listColor: 'info',
    className: ['bg-info']
  }, {
    id: 999,
    title: 'Repeating Event',
    start: new Date(y, m, d + 4, 16, 0),
    allDay: false,
    listColor: 'primary',
    className: ['bg-primary']
  }, {
    title: 'Birthday Party',
    start: new Date(y, m, d + 1, 19, 0),
    end: new Date(y, m, d + 1, 22, 30),
    allDay: false,
    listColor: 'default',
    className: ['bg-default']
  }, {
    title: 'Click for Google',
    start: new Date(y, m, 28),
    end: new Date(y, m, 29),
    url: 'http://google.com/',
    listColor: 'warning',
    className: ['bg-warning']
  }];

  $('.fullcalendar').fullCalendar({
    editable: true,
    contentHeight: 520,
    header: {
      left: 'title',
      center: 'month,agendaWeek,agendaDay',
      right: 'today prev,next'
    },
    buttonIcons: {
      prev: ' fa fa-caret-left',
      next: ' fa fa-caret-right'
    },
    droppable: true,
    axisFormat: 'h:mm',
    columnFormat: {
      month: 'dddd',
      week: 'ddd M/D',
      day: 'dddd M/d',
      agendaDay: 'dddd D'
    },
    allDaySlot: false,
    drop: function() {
      var originalEventObject = $(this).data('eventObject');
      var copiedEventObject = $.extend({}, originalEventObject);
      copiedEventObject.start = date;
      $('.fullcalendar').fullCalendar('renderEvent', copiedEventObject, true);
      if ($('#drop-remove').is(':checked')) {
        $(this).remove();
      }
    },
    defaultDate: moment().format('YYYY-MM-DD'),
    viewRender: function() {
      $('.fc-button-group').addClass('btn-group');
      $('.fc-button').addClass('btn');
    },
    events: eventsData
  });
})(jQuery);
