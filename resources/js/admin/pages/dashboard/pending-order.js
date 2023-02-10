
const selectUser = document.getElementById('user-select');
const dataContainer = document.getElementById('apply-leave-table-body');
$(document).ready(function() {
const fetchData = async (selectedValue) => {
  try {
    let response;
    if (selectedValue === "") {
      response = await fetch(`${router}`);
    } else {
      response = await fetch(`https://api.example.com/data/${selectedValue}`);
    }
    const data = await response.json();
    console.log(data)
    // Render the data to the view
    const html = data.map(item => 
      `<tr> 
          <td> ${item.name} </td>
          <td> ${item.phone} </td>
          <td> ${item.address} </td>
          <td> ${formatDateTime(item.start_date)} </td>
          <td> ${formatDateTime(item.end_date)} </td>
          <td> ${calculatorHour(item.start_date,item.end_date)} </td>
       </tr>`).join('');
    dataContainer.innerHTML = html;
  } catch (error) {
    // Handle the error
    console.log(error);
  }
}
fetchData('');
selectUser.addEventListener('change', () => {
  const selectedValue = selectUser.value;
  fetchData(selectedValue);
});
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