
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

  if (selectedValue === 'section1' || selectedValue === 'section2') {
    document.getElementById('zari_bill').style.display = 'none';
    document.getElementById('kora_bill').style.display = 'block';
  }
  if (selectedValue === 'section3') {
    document.getElementById('kora_bill').style.display = 'none';
    document.getElementById('zari_bill').style.display = 'block';

  }
}
document.getElementById('kora_bill').style.display = 'none';
document.getElementById('zari_bill').style.display = 'none';
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


// function fetch_bill_id() {
//     var id = document.getElementById("pur_bill_id").value;
//     //console.log(id);

//     $.ajax({
//       url: 'fetch_inward.php',
//       method: 'POST',
//       data: { id: id },
//       dataType: 'json',
//       success: function (work) {
//         //  console.log(myData);
//          console.log(work.id)

//         // Update your HTML elements with fetched data
//         // document.getElementById("unit").value = work.dept;
//         // document.getElementById("itemopb").value = work.opb_wght;
//         // document.getElementById("bobin_qty").value = work.no_bobins;


//       }
//     });
//   }

function fetch_bill_id() {

  var id = document.getElementById("pur_bill_id").value;
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
function clearpage(){
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


