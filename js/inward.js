
//---------------------------------------------------------------------------------------

function openSection() {
  var selectedValue = document.getElementById('tbl_type').value;
  var i, contentSections;
  // Hide all content sections
  contentSections = document.getElementsByClassName('content-section');
  for (i = 0; i < contentSections.length; i++) {
    contentSections[i].style.display = 'none';
  }
  // Show the selected content section
  document.getElementById(selectedValue).style.display = 'block';

  if (selectedValue === 'section1') {
    document.getElementById('zari_bill').style.display = 'none';
    document.getElementById('kora_bill').style.display = 'block';
    document.getElementById('weft_bill').style.display = 'none';
  }
  if (selectedValue === 'section2') {
    document.getElementById('zari_bill').style.display = 'none';
    document.getElementById('weft_bill').style.display = 'block';
    document.getElementById('kora_bill').style.display = 'none';
  }
  if (selectedValue === 'section3') {
    document.getElementById('kora_bill').style.display = 'none';
    document.getElementById('zari_bill').style.display = 'block';
    document.getElementById('weft_bill').style.display = 'none';
  }
}
document.getElementById('kora_bill').style.display = 'none';
document.getElementById('zari_bill').style.display = 'none';
document.getElementById('weft_bill').style.display = 'none';
//---------------------------------------------------------------------------------------

const bill_no_input = document.getElementById('bill_no');

bill_no_input.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('pur_bill');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("pur_bill_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("pur_bill_id").value;

  console.log("pur_bill_id-->", selectedAcid);
  console.log("bill_no_input value-->", bill_no_input.value);
  fetch_bill_id();
});

const bill_no_input2 = document.getElementById('bill_no2');

bill_no_input2.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('pur_bill2');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("pur_bill_id2").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("pur_bill_id2").value;

  console.log("pur_bill_id-->", selectedAcid);
  console.log("bill_no_input2 value-->", bill_no_input2.value);
  fetch_bill_id2();
});

const bill_no_input3 = document.getElementById('bill_no3');

bill_no_input3.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('pur_bill3');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("pur_bill_id3").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("pur_bill_id3").value;

  console.log("pur_bill_id 3-->", selectedAcid);
  console.log("bill_no_input3 value-->", bill_no_input3.value);
  fetch_bill_id3();
});

const location_input = document.getElementById('location');

location_input.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('locations');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("hidden_location_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("hidden_location_id").value;

  console.log("hidden_location_id-->", selectedAcid);
  console.log("location_input value-->", location_input.value);
});

function fetch_bill_id() {

  var id = document.getElementById("pur_bill_id").value;
  console.log(id);
  $.ajax({
    url: 'fetch_inward_warp.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      document.getElementById('remarks').value = work.remarks;
      document.getElementById('sup_id').value = work.ac_id;
      document.getElementById('pur_tot_wght').value = work.tot_qty;
      document.getElementById('pur_acname').value = work.ac_nam;
      document.getElementById('pur_date').value = work.dat;
    }
  });
}
function fetch_bill_id2() {

  var id = document.getElementById("pur_bill_id2").value;
  console.log(id);
  $.ajax({
    url: 'fetch_inward.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      document.getElementById('remarks').value = work.remarks;
      document.getElementById('pur_tot_wght').value = work.tot_qty;
      document.getElementById('pur_acname').value = work.ac_nam;
      document.getElementById('pur_date').value = work.dat;
    }
  });
}
function fetch_bill_id3() {

  var id = document.getElementById("pur_bill_id3").value;
  console.log(id);
  $.ajax({
    url: 'fetch_inward_weft.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      console.table(work);
      document.getElementById('remarks').value = work.remarks;
      document.getElementById('pur_tot_wght').value = work.tot_qty;
      document.getElementById('pur_acname').value = work.ac_nam;
      document.getElementById('pur_date').value = work.dat;
    }
  });
}


//---------------------
function multiply_section() {
  var sections = document.getElementsByName('section[]');
  var one_sections = document.getElementsByName('one_section[]');
  var counts = document.getElementsByName('count[]');

  for (var i = 0; i < sections.length; i++) {
    var section_value = parseFloat(sections[i].value);
    var one_section_value = parseFloat(one_sections[i].value);

    if (!isNaN(section_value) && !isNaN(one_section_value)) {
      counts[i].value = section_value * one_section_value;
    } else {

    }
  }
  calculateTotalSum3();
}
//---------------------
function clearpage() {
  location.reload();
}



document.addEventListener("DOMContentLoaded", function () {

  function handleEnterKey(event, nextElementId) {
    if (event.key === 'Enter') {
      event.preventDefault();
      const nextElement = document.getElementById(nextElementId);
      nextElement.focus();
    }
  }
});
function handleEnterKeys(event, nextElementId) {
  if (event.key === 'Enter') {
    event.preventDefault();
    // console.log(nextElementId);
    if (nextElementId === 'warp_wghts') {
      const currentElement = event.target;
      const row = currentElement.closest('tr');
      const nextRow = row.nextElementSibling; // Get the next row
      if (nextRow && nextElementId) {
        const nextElement = nextRow.querySelector(`#${nextElementId}`);
        if (nextElement) {
          nextElement.focus();
        }
      }

    } else {
      const currentElement = event.target;
      const row = currentElement.closest('tr');
      const inputs = row.querySelectorAll('input[type="text"], input[type="number"]');
      const currentIndex = Array.from(inputs).indexOf(currentElement);
      if (currentIndex !== -1 && currentIndex < inputs.length - 1) {
        inputs[currentIndex + 1].focus();
      } else if (nextElementId) {
        const nextElement = document.getElementById(nextElementId);
        if (nextElement) {
          nextElement.focus();
        }
      }

    }
  }
}

//============ script for date set default in input field visible starts===============
window.onload = function () {
  var currentDate = new Date();
  var day = currentDate.getDate();
  var month = currentDate.getMonth() + 1; // Month is zero-based
  var year = currentDate.getFullYear();

  // Format the date as YYYY-MM-DD (ISO format)
  var formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');

  // Set the value attribute of the input field

  document.getElementById('warp_page_date').value = formattedDate;

};

//=============== script for date ends ================= 


// Select the input field where you want to display the sum
const returnWeightInput = document.getElementById('ttl_warp_wghts');

// Function to calculate and update the total sum
function calculateTotalSum() {
  const weightInputs = document.querySelectorAll('input[name="warp_wghts[]"]');
  let totalSum = 0;

  weightInputs.forEach((input) => {
    const value = input.value.trim();
    if (value) {
      const weight = parseFloat(value);
      if (!isNaN(weight)) {
        totalSum += weight;
      }
    }
  });

  // Update the "returnweight" input field with the calculated sum
  returnWeightInput.value = totalSum;
  //document.getElementById('returnweight').value = document.getElementById('itemopb').value - totalSum;
}
function calculateTotalSum2() {
  const weightInputs = document.querySelectorAll('input[name="section[]"]');
  let totalSum = 0;

  weightInputs.forEach((input) => {
    const value = input.value.trim();
    if (value) {
      const weight = parseFloat(value);
      if (!isNaN(weight)) {
        totalSum += weight;
      }
    }
  });

  // Update the "returnweight" input field with the calculated sum
  document.getElementById('ttl_section').value = totalSum;
  //document.getElementById('returnweight').value = document.getElementById('itemopb').value - totalSum;
}
function calculateTotalSum3() {
  const weightInputs = document.querySelectorAll('input[name="count[]"]');
  let totalSum = 0;

  weightInputs.forEach((input) => {
    const value = input.value.trim();
    if (value) {
      const weight = parseFloat(value);
      if (!isNaN(weight)) {
        totalSum += weight;
      }
    }
  });

  // Update the "returnweight" input field with the calculated sum
  document.getElementById('ttl_count').value = totalSum;
  //document.getElementById('returnweight').value = document.getElementById('itemopb').value - totalSum;
}

//----------------------------------------------------------------------
// function frmsave() {
//   var totsrl = document.getElementById('no_of_warp').value;
//   console.log(totsrl);
//   $.ajax({
//     url: 'getwarpno.php',
//     method: 'POST',
//     data: { totsrl: totsrl },
//     dataType: 'json',
//     success: function (work) {
//       console.table(work);

//       const tableBody3 = document.getElementById("tbody_ds_warp");
//       const maxrec3 = work.length;

//       work.forEach(function (warp_num, index) {
//         console.log('inv', warp_num);

//         const table = document.getElementById("warp_tbl"); // Replace with your table ID
//         const lastRow = table.rows[table.rows.length - 1]; // Get the last row

//         // Populate the last row with your data
//         // lastRow.querySelector("[name='warpsrl[]']").value = warp_num.warp_no;
//         lastRow.querySelector("[name='warpsrl[]']").value = warp_num;

//       });

//     }
//   });
// }
//-------------------------------------------

function frmsave() {
  // var totsrl = document.getElementById('no_of_warp').value;
  // console.log(totsrl);
  // $.ajax({
  //   url: 'getwarpno.php',
  //   method: 'POST',
  //   data: { totsrl: totsrl },
  //   dataType: 'json',
  //   success: function (work) {
  //     console.table(work);
  //     const table = document.getElementById("warp_tbl");
  //     // Loop through the input fields and populate their values
  //     for (let i = 0; i < work.length; i++) {
  //       const lastRow = table.rows[table.rows.length - i]; // Get the last row
  //       lastRow.querySelector("[name='warpsrl[]']").value = work[i] || "";
  //         console.log(work[i]);
  //     }

  //   }
  // });
  var totsrl = document.getElementById('no_of_warp').value;
  console.log(totsrl);
  $.ajax({
    url: 'getwarpno.php',
    method: 'POST',
    data: { totsrl: totsrl },
    dataType: 'json',
    success: function (work) {
      console.log('Received work array:', work);
  
      // Select all input fields with the name 'warpsrl[]' within the tbody
      var inputFields = document.querySelectorAll('#tbody_ds_warp input[name="warpsrl[]"]');
  
      // Loop through each input field and assign values from the array
      inputFields.forEach(function(input, index) {
        var valueIndex = index % work.length; // Use modulo operator to cycle through the values of the array
        // console.log('Assigning value:', work[valueIndex], 'to input field at index', index);
        input.setAttribute('value', work[valueIndex]); // Set the value attribute of the current input field
      });
    }

    // error: function(jqXHR, textStatus, errorThrown) {
    //   console.error('AJAX Error:', textStatus, errorThrown);
    // }
  });
 
if (document.getElementById('location').value == "" || document.getElementById('ply_type').value == "" || document.getElementById('tbl_type').value == "" || document.getElementById('ply_type').value == "" || document.getElementById('no_of_warp').value == "") {
alert('fill the required fields')
}
else{
  setTimeout(function() {
    document.getElementById('form1').submit();
  }, 1000);
}


}


//----------------------------------------
function addwarpRows() {
  const tableBody = document.getElementById("tbody_ds_warp");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Update the serial number in the new row
  // newRow.querySelector("td:first-child").textContent = S_NO;
  // newRow.querySelector("td:first-child").textContent = newRow.querySelector("input[type='hidden']").value;
  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  // addinginputs.forEach((input) => (input.value = ""));

  // Append the new row to the table body
  tableBody.appendChild(newRow);

  // Increment the serial number for the next row
  S_NO++;
}

//---------------------------------------------------------------------


// Function to add a new row to the table with a serial number
function addRow_warp(S_NO) {
  const tableBody = document.getElementById("tbody_ds_warp");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Update the serial number in the new row
  newRow.querySelector("td:first-child").textContent = S_NO;
  // newRow.querySelector("td:first-child").textContent = newRow.querySelector("input[type='hidden']").value;
  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  // addinginputs.forEach((input) => (input.value = ""));

  // Append the new row to the table bodyyes
  tableBody.appendChild(newRow);

  // Increment the serial number for the next row
  S_NO++;
}

// Event listener for the input field specifying the number of rows
document.getElementById("no_of_warp").addEventListener('change', function() {

  //----------------------------------
  var table = document.getElementById('tbody_ds_warp');

  // Iterate over rows starting from the second row (index 1)
  for (var i = table.rows.length - 1; i > 0; i--) {
    // Remove the row
    table.deleteRow(i);
  }

  //-----------------------------------
  var numrows = document.getElementById("no_of_warp").value;
  let S_NO = 2; // Start with 2 to avoid leading '1'
  for (let i = 0; i < numrows - 1; i++) {
    addRow_warp(S_NO);
    S_NO++;
  }
  
  // frmsave();
});
function deleteRowsExceptLast() {
  const tableBody = document.getElementById("tbody_ds_warp");
  const rows = tableBody.querySelectorAll("tr");

  // Keep the last row and remove the others
  for (let i = 0; i < rows.length - 1; i++) {
    rows[i].remove();
  }
  // Clear the input fields in the last row
  const lastRowInputs = rows[rows.length - 1].querySelectorAll("input[type='text'], input[type='number']");
  lastRowInputs.forEach((input) => (input.value = ""));
}

// function updateTime() {
//   // Get the current time
//   var currentTime = new Date();

//   // Format the time as desired (e.g., HH:MM:SS)
//   var formattedTime = currentTime.getHours() + ":" + currentTime.getMinutes() + ":" + currentTime.getSeconds();

//   // Set the formatted time to the input field
//   document.getElementById("currentTime").value = formattedTime;
// }

// // Call updateTime initially to set the time immediately
// updateTime();

// // Update the time every second (1000 milliseconds)
// setInterval(updateTime, 1000);