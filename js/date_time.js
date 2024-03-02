function updateTime() {
    // Get the current time
    var currentTime = new Date();
  
    // Format the time as desired (e.g., HH:MM:SS)
    var formattedTime = currentTime.getHours() + ":" + currentTime.getMinutes() + ":" + currentTime.getSeconds();
  
    // Set the formatted time to the input field
    document.getElementById("currentTime").value = formattedTime;
  }
  
  // Call updateTime initially to set the time immediately
  updateTime();
  
  // Update the time every second (1000 milliseconds)
  setInterval(updateTime, 1000);

  
//============ script for date set default in input field visible starts===============
window.onload = function () {
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1; // Month is zero-based
    var year = currentDate.getFullYear();
  
    // Format the date as YYYY-MM-DD (ISO format)
    var formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');
  
    // Set the value attribute of the input field
    // document.getElementById('doc_date').value = formattedDate;
    // document.getElementById('reff_date').value = formattedDate;
    document.getElementById('iss_date').value = formattedDate;

  
  };
  
  //=============== script for date ends =================