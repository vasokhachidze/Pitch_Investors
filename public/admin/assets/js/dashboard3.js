/* global Chart:false */

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true
  
  $.ajax({
    url: $("#ajax_premium_call_url").val(),
    type: "POST",
    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
    data: {
    },
    success: function(response) { 
      $('#premium_total_sale').html('KES '+response.data.total);
      if(response.data.growth > 0) {
        $('#premium_growth_class').removeClass('text-danger');
        $('#premium_growth_class').addClass('text-success');

        $('#premium_growth_icon').removeClass('fa-arrow-down');
        $('#premium_growth_icon').addClass('fa-arrow-up');
      } else {
        $('#premium_growth_class').addClass('text-danger');
        $('#premium_growth_class').removeClass('text-success');

        $('#premium_growth_icon').addClass('fa-arrow-down');
        $('#premium_growth_icon').removeClass('fa-arrow-up');
        
        
      }
      $('#premium_growth_value').html(response.data.growth+'%');
      var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
   var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: response.data.label_1,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: response.data.data_1,
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: response.data.data_2,
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return  value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })   
    }
});  
  
  $.ajax({
    url: $("#ajax_call_url").val(),
    type: "POST",
    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
    data: {
    },
    success: function(response) { 
      $('#total_sale').html(response.data.total);
      if(response.data.growth > 0) {
        $('#growth_class').removeClass('text-danger');
        $('#growth_class').addClass('text-success');

        $('#growth_icon').removeClass('fa-arrow-down');
        $('#growth_icon').addClass('fa-arrow-up');
      } else {
        $('#growth_class').addClass('text-danger');
        $('#growth_class').removeClass('text-success');

        $('#growth_icon').addClass('fa-arrow-down');
        $('#growth_icon').removeClass('fa-arrow-up');
      }
      $('#growth_value').html(response.data.growth+'%');
      var $visitorsChart = $('#visitors-chart')

      // eslint-disable-next-line no-unused-vars
      var visitorsChart = new Chart($visitorsChart, {
        data: {
          labels: response.data.label_1,
          datasets: [{
            type: 'line',
            data: response.data.data_1,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
            // pointHoverBackgroundColor: '#007bff',
            // pointHoverBorderColor    : '#007bff'
          },
          {
            type: 'line',
            data: response.data.data_2,
            backgroundColor: 'tansparent',
            borderColor: '#ced4da',
            pointBorderColor: '#ced4da',
            pointBackgroundColor: '#ced4da',
            fill: false
            // pointHoverBackgroundColor: '#ced4da',
            // pointHoverBorderColor    : '#ced4da'
          }]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })     
    }
});  
})

// lgtm [js/unused-local-variable]
