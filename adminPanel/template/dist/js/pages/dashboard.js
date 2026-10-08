
$(function () {

  'use strict';

  if ($('.connectedSortable').length) {

    $('.connectedSortable').sortable({
      placeholder: 'sort-highlight',
      connectWith: '.connectedSortable',
      handle: '.box-header, .nav-tabs',
      forcePlaceholderSize: true,
      zIndex: 999999
    });

    $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom')
      .css('cursor', 'move');
  }

  if ($('.todo-list').length) {

    $('.todo-list').sortable({
      placeholder: 'sort-highlight',
      handle: '.handle',
      forcePlaceholderSize: true,
      zIndex: 999999
    });

  }

  if ($('.knob').length && $.fn.knob) {
    $('.knob').knob();
  }
  if ($('#world-map').length && $.fn.vectorMap) {

    var visitorsData = {
      US: 398,
      SA: 400,
      CA: 1000,
      DE: 500,
      FR: 760,
      CN: 300,
      AU: 700,
      BR: 600,
      IN: 800,
      GB: 320,
      RU: 3000
    };

    $('#world-map').vectorMap({
      map: 'world_mill_en',
      backgroundColor: 'transparent',

      regionStyle: {
        initial: {
          fill: '#e4e4e4',
          'fill-opacity': 1,
          stroke: 'none',
          'stroke-width': 0,
          'stroke-opacity': 1
        }
      },

      series: {
        regions: [
          {
            values: visitorsData,
            scale: ['#92c1dc', '#ebf4f9'],
            normalizeFunction: 'polynomial'
          }
        ]
      },

      onRegionLabelShow: function (e, el, code) {

        if (typeof visitorsData[code] !== 'undefined') {
          el.html(
            el.html() +
            ': ' +
            visitorsData[code] +
            ' new visitors'
          );
        }

      }
    });

  }

  if ($.fn.sparkline) {

    if ($('#sparkline-1').length) {

      var myvalues1 = [
        1000, 1200, 920, 927,
        931, 1027, 819, 930, 1021
      ];

      $('#sparkline-1').sparkline(myvalues1, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: '#ebf4f9',
        height: '50',
        width: '80'
      });

    }


    if ($('#sparkline-2').length) {

      var myvalues2 = [
        515, 519, 520, 522,
        652, 810, 370, 627,
        319, 630, 921
      ];

      $('#sparkline-2').sparkline(myvalues2, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: '#ebf4f9',
        height: '50',
        width: '80'
      });

    }


    if ($('#sparkline-3').length) {

      var myvalues3 = [
        15, 19, 20, 22,
        33, 27, 31, 27,
        19, 30, 21
      ];

      $('#sparkline-3').sparkline(myvalues3, {
        type: 'line',
        lineColor: '#92c1dc',
        fillColor: '#ebf4f9',
        height: '50',
        width: '80'
      });

    }

  }

  if ($('#calendar').length && $.fn.datepicker) {
    $('#calendar').datepicker();
  }

  if ($('#chat-box').length && $.fn.slimScroll) {

    $('#chat-box').slimScroll({
      height: '250px'
    });

  }

  var area = null;
  var line = null;
  var donut = null;

  if ($('#revenue-chart').length && typeof Morris !== 'undefined') {

    area = new Morris.Area({

      element: 'revenue-chart',

      resize: true,

      data: [
        {
          y: '2011 Q1',
          item1: 2666,
          item2: 2666
        },
        {
          y: '2011 Q2',
          item1: 2778,
          item2: 2294
        },
        {
          y: '2011 Q3',
          item1: 4912,
          item2: 1969
        },
        {
          y: '2011 Q4',
          item1: 3767,
          item2: 3597
        },
        {
          y: '2012 Q1',
          item1: 6810,
          item2: 1914
        },
        {
          y: '2012 Q2',
          item1: 5670,
          item2: 4293
        },
        {
          y: '2012 Q3',
          item1: 4820,
          item2: 3795
        },
        {
          y: '2012 Q4',
          item1: 15073,
          item2: 5967
        },
        {
          y: '2013 Q1',
          item1: 10687,
          item2: 4460
        },
        {
          y: '2013 Q2',
          item1: 8432,
          item2: 5713
        }
      ],

      xkey: 'y',

      ykeys: [
        'item1',
        'item2'
      ],

      labels: [
        'محصول ۱',
        'محصول ۲'
      ],

      lineColors: [
        '#a0d0e0',
        '#3c8dbc'
      ],

      hideHover: 'auto'

    });

  }

  if ($('#line-chart').length && typeof Morris !== 'undefined') {

    line = new Morris.Line({

      element: 'line-chart',

      resize: true,

      data: [
        {
          y: '2011 Q1',
          item1: 2666
        },
        {
          y: '2011 Q2',
          item1: 2778
        },
        {
          y: '2011 Q3',
          item1: 4912
        },
        {
          y: '2011 Q4',
          item1: 3767
        },
        {
          y: '2012 Q1',
          item1: 6810
        },
        {
          y: '2012 Q2',
          item1: 5670
        },
        {
          y: '2012 Q3',
          item1: 4820
        },
        {
          y: '2012 Q4',
          item1: 15073
        },
        {
          y: '2013 Q1',
          item1: 8432
        },
        {
          y: '2013 Q2',
          item1: 8432
        }
      ],

      xkey: 'y',

      ykeys: [
        'item1'
      ],

      labels: [
        'Item 1'
      ],

      lineColors: [
        '#efefef'
      ],

      lineWidth: 2,

      hideHover: 'auto',

      gridTextColor: '#fff',

      gridStrokeWidth: 0.4,

      pointSize: 4,

      pointStrokeColors: [
        '#efefef'
      ],

      gridLineColor: '#efefef',

      gridTextFamily: 'Open Sans',

      gridTextSize: 10

    });

  }

  if ($('#sales-chart').length && typeof Morris !== 'undefined') {

    donut = new Morris.Donut({

      element: 'sales-chart',

      resize: true,

      colors: [
        '#3c8dbc',
        '#f56954',
        '#00a65a'
      ],

      data: [
        {
          label: 'فروش دانلودی',
          value: 12
        },
        {
          label: 'فروش فیزیکی',
          value: 30
        },
        {
          label: 'فروش ایمیلی',
          value: 20
        }
      ],

      hideHover: 'auto'

    });

  }

  $('.box ul.nav a').on('shown.bs.tab', function () {

    if (area !== null) {
      area.redraw();
    }

    if (donut !== null) {
      donut.redraw();
    }

    if (line !== null) {
      line.redraw();
    }

  });

  if ($('.todo-list').length && $.fn.todoList) {

    $('.todo-list').todoList({

      onCheck: function () {

        window.console.log(
          $(this),
          'انجام شد'
        );

      },

      onUnCheck: function () {

        window.console.log(
          $(this),
          'انجام نشده'
        );

      }

    });

  }

});