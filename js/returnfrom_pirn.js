 
 
 const fromloc = document.getElementById('fromloc');

 fromloc.addEventListener('change', function (event) {
     const selectedOption = event.target.value;
     const datalistOptions = document.getElementById('fromlocs');
     
     const options = datalistOptions.getElementsByTagName('option');
     for (let i = 0; i < options.length; i++) {
         const option = options[i];
         const optionValue = option.value;
 
         if (optionValue === selectedOption) {
             var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
 
             document.getElementById("hidden_id_unitid").value = selectedAcid;
 
             break;
         }
     }
     var id = document.getElementById("hidden_id_unitid").value;
 
     console.log("fromloc id-->",selectedAcid);
     console.log("fromloc value-->",fromloc.value);
 });

function funfetch() {
var id = document.getElementById("workname").value;
//console.log("con7");

$.ajax({
url: 'fetch.php',
method: 'POST',
data: { id: id },
dataType: 'json',
success: function (work) {
  var myData = work.work_nam;
  console.log('f1',work);
  document.getElementById("unit").value = work.dept;
  document.getElementById("no_ofbobin_issued").value = work.no_bobins;
  // document.getElementById("itemname").value = work.it_nam;
  // document.getElementById("itemopb").value = work.opb_wght;
  // document.getElementById("itemopb_bobinqty").value = work.opb_qty;
  // document.getElementById("colorname").value = work.col_nam;

  showModal();
  funfetch2();
  funfetch3();
  // toggleColorDropdown()
}
});
}

//------------------------------------------------------------------------------------------------------------
// var inputElement = document.getElementById("fin_date");
// var specificDate = new Date("2023-08-18T13:49:06");
// var formattedDate = specificDate.toISOString().substring(0, 16);
// inputElement.value = formattedDate;

// ------------------------------------------------------------------------------------------------------------


function funfetch2() {
  var id = document.getElementById("workname").value;
 console.log('f2',id);

  $.ajax({
    url: 'fetch_pirnret2.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      console.log('f2',work);
      const tableBody = document.getElementById("tbody");
      const maxrec = work.length;
      
      // Remove all rows except the last one
      while (tableBody.rows.length > 1) {
        tableBody.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
       

        const table = document.getElementById("modaltable"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='bobins_id[]']").value = invoice.bobin_id;
        lastRow.querySelector("[name='bobins_emty[]']").value = invoice.empty_wt;
        lastRow.querySelector("[name='bobins[]']").value = invoice.bobin_no;
        lastRow.querySelector("[name='wghts[]']").value = 0;

        if (index < maxrec - 1) {
          addRow();
        }
      });
    }
  });
 
}

function funfetch3() {
  var id = document.getElementById("workname").value;
 // console.log(id);

  $.ajax({
    url: 'fetch_pirnret.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      console.log('f3',work);
      const tableBody = document.getElementById("tbody2");
      const maxrec = work.length;
      
      // Remove all rows except the last one
      while (tableBody.rows.length > 1) {
        tableBody.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log(invoice);
        const table = document.getElementById("modaltable2"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='boxes[]']").value = invoice.box_no;
        lastRow.querySelector("[name='p_nos[]']").value = 0;
        lastRow.querySelector("[name='colors[]']").value = invoice.box_col_nam;
        lastRow.querySelector("[name='box_empty[]']").value = invoice.empty_wght;
        lastRow.querySelector("[name='p_wghts[]']").value = 0;

        if (index < maxrec - 1) {
          addRow2();
         calculateTotalSum2();
        }
      });
    }
    
  });
  
}


/* ------------------------------------------------------------------------------------------------------------------------------  */

function addRow() {
  const tableBody = document.getElementById("tbody");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  //<td><input type="text" name="bobins[]" value="bobin02"readonly></td>
  // <td><input type="text" name="wght[]"  oninput="calculateTotalSum()"></td>

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

  // Append the new row to the table body
  tableBody.appendChild(newRow);
}
function addRow2() {
  const tableBody = document.getElementById("tbody2");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  //<td><input type="text" name="bobins[]" value="bobin02"readonly></td>
  // <td><input type="text" name="wght[]"  oninput="calculateTotalSum()"></td>

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

  // Append the new row to the table body
  tableBody.appendChild(newRow);
   
}
/* ------------------------------------------------------------------------------------------------------------------------------  */

function showModal() {
  // Get the modal element
  const modal = document.getElementById("modal_bobin");
  modal.style.display = "block";
}
// function showModal2() {
//   // Get the modal element
//   const modal2 = document.getElementById("modal_bobin2");
//   modal2.style.display = "block";
// }

/* ------------------------------------------------------------------------------------------------------------------------------  */

function hideModal() {
  // Get the modal element
  const modal = document.getElementById("modal_bobin");
  // Hide the modal
  modal.style.display = "none";
}
// function hideModal2() {
//   // Get the modal element
//   const modal2 = document.getElementById("modal_bobin2");
//   // Hide the modal
//   modal2.style.display = "none";
// }

// Event listener to close the modal
const closeBtn = document.querySelector(".close");
closeBtn.addEventListener("click", hideModal);
// const closeBtn2 = document.querySelector(".close2");
// closeBtn2.addEventListener("click", hideModal2);

// Close the modal if the user clicks outside of it

/* ------------------------------------------------------------------------------------------------------------------------------  */

/* ------------------------------------------------------------------------------------------------------------------------------  */

// Select the input field where you want to display the sum
const returnWeightInput = document.getElementById('ttl_retbobin_wght_inpirn');

// Function to calculate and update the total sum
function calculateTotalSum() {
  const weightInputs = document.querySelectorAll('input[name="wghts[]"]');
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
 // document.getElementById('returnweight').value = document.getElementById('itemopb').value-totalSum;
}

// Call the calculateTotalSum function whenever needed, e.g., when a new row is added



//----------------------------------------- 1----------ends
// Select the input field where you want to display the sum
const returnWeightInput2 = document.getElementById('no_ofpirns');

// Function to calculate and update the total sum
function calculateTotalSum2() {
  const weightInputs2 = document.querySelectorAll('input[name="p_nos[]"]');
  let totalSum2 = 0;

  weightInputs2.forEach((input) => {
    const value2 = input.value.trim();
    if (value2) {
      const weight2 = parseFloat(value2);
      if (!isNaN(weight2)) {
        totalSum2 += weight2;
      }             
    }
  });

  // Update the "returnweight" input field with the calculated sum
  returnWeightInput2.value = totalSum2;
 // document.getElementById('returnweight').value = document.getElementById('itemopb').value-totalSum;
}
calculateTotalSum2();

// Call the calculateTotalSum function whenever needed, e.g., when a new row is added

// --------------------------------------- 2  ------------- ends    
// Select the input field where you want to display the sum
const returnWeightInput3 = document.getElementById('wght_of_pirns');

// Function to calculate and update the total sum
function calculateTotalSum3() {
  const weightInputs3 = document.querySelectorAll('input[name="p_wghts[]"]');
  let totalSum3 = 0;

  weightInputs3.forEach((input) => {
    const value3 = input.value.trim();
    if (value3) {
      const weight3 = parseFloat(value3);
      if (!isNaN(weight3)) {
        totalSum3 += weight3;
      }             
    }
  });

  // Update the "returnweight" input field with the calculated sum
  returnWeightInput3.value = totalSum3;
 // document.getElementById('returnweight').value = document.getElementById('itemopb').value-totalSum;
}

// Call the calculateTotalSum function whenever needed, e.g., when a new row is added



  // Function to handle Enter key for dynamically added inputs
  document.getElementById('inputContainer').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
  
      const inputs = document.querySelectorAll('#inputContainer input[type="number"]');
      const currentIndex = Array.from(inputs).indexOf(event.target);
  
      if (currentIndex !== -1 && currentIndex < inputs.length - 1) {
        inputs[currentIndex + 1].focus();
        inputs[currentIndex + 1].select();  
      }
    }
  });
  // Function to handle Enter key for dynamically added inputs
  document.getElementById('inputContainer2').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
  
      const inputs = document.querySelectorAll('#inputContainer2 input[type="number"]');
      const currentIndex = Array.from(inputs).indexOf(event.target);
  
      if (currentIndex !== -1 && currentIndex < inputs.length - 1) {
        inputs[currentIndex + 1].focus();
        inputs[currentIndex + 1].select();  
      }
    }
  });



// Get references to the input fields
const pirnNoInput = document.getElementById('no_pirnss');
const emptyPirnWght = document.getElementById('empty_pirn_wght');
const emptybox_wght = document.getElementById('box_wght');
const ttlWght = document.getElementById('t_wght');
const pureWght = document.getElementById('pure_wght');

// Add an input event listener to each input field
pirnNoInput.addEventListener('input', calculatePureWeight);
emptyPirnWght.addEventListener('input', calculatePureWeight);
emptybox_wght.addEventListener('input', calculatePureWeight);
ttlWght.addEventListener('input', calculatePureWeight);

// Function to calculate pure weight based on input values
function calculatePureWeight() {
    const pirnNoValue = parseFloat(pirnNoInput.value) || 0;
    const emptyPirnValue = parseFloat(emptyPirnWght.value) || 0;
    const emptybox_wghtValue = parseFloat(emptybox_wght.value) || 0;
    const ttlWghtValue = parseFloat(ttlWght.value) || 0;

    // Perform the calculation
    const result =  ttlWghtValue - ((pirnNoValue * emptyPirnValue) + emptybox_wghtValue);

    // Update the value of pure_wght field
    pureWght.value = result;
}
