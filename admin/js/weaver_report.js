//============ script for date set default in input field visible starts===============
window.onload = function () {
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1; // Month is zero-based
    var year = currentDate.getFullYear();
  
    // Format the date as YYYY-MM-DD (ISO format)
    var formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');
  
    // Set the value attribute of the input field
  
    document.getElementById('start_date').value = formattedDate;
    document.getElementById('end_date').value = formattedDate;
  
  };
  
  
