import * as paginate from './paginate.js';

const dataContainer = document.getElementById('apply-leave-table-body');
$(document).ready(function() {
  $.ajax({
    type: 'GET',
    url: `${router}`,
    data: {
      user_id: '',
      role_id: ''
    },
    success: function(response) {
      $('#pagination-container').pagination({
              dataSource: response,
              pageSize: 10,
              showPrevious: false,
              showNext: false,
              callback: function(data, pagination) {
                  var html = simpleTempesting(data);
                  $('#data-container').html(html);
              }
            })
    },
    error: function(error) {
      console.error(error);
    }
  });

  $('select').change(function() {
    const selectUser = $('#user-select').val();
    const selectRole = $('#role-select').val();
    $.ajax({
      type: 'GET',
      url: `${router}`,
      data: {
        user_id: selectUser ? selectUser : '',
        role_id: selectRole ? selectRole : ''
      },
      success: function(response) {
        $('#pagination-container').pagination({
                dataSource: response,
                pageSize: 10,
                showPrevious: false,
                showNext: false,
                callback: function(data, pagination) {
                    var html = simpleTempesting(data);
                    $('#data-container').html(html);
                }
              })
      },
      error: function(error) {
        console.error(error);
      }
      });
  })

function simpleTempesting(data) {
   const html = data.map(item => 
      `<tr> 
          <td> ${item.name} </td>
          <td> ${item.phone} </td>
          <td> ${item.address} </td>
          <td> ${formatDateTime(item.start_date)} </td>
          <td> ${formatDateTime(item.end_date)} </td>
          <td>  ${parseFloat(calculatorHour(item.start_date,item.end_date).toFixed(2)) } H </td>
       </tr>`).join('');
    dataContainer.innerHTML = html;
}

function formatDateTime(date){
  const dateFormat = new Date(date);
  const options = { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'numeric', 
    day: 'numeric', 
    hour: 'numeric', 
    minute: 'numeric', 
    second: 'numeric' 
  };
  return dateFormat.toLocaleDateString('vi-VN', options);
}})

function calculatorHour(startDate,endDate){
  const start = new Date(startDate);
  const end = new Date(endDate);
  const diff = end - start;
  return  diff / 1000 / 60 / 60;
}

