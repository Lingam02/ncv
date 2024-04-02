/* -------------------   color exits function --------------------*/
const fromlocto = document.getElementById('fromlocto');

fromlocto.addEventListener('change', function (event) {
    const selectedOption = event.target.value;
    const datalistOptions = document.getElementById('fromloctos');
    
    const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

            document.getElementById("hidden_fromlocto").value = selectedAcid;

            break;
        }
    }
    var id = document.getElementById("hidden_fromlocto").value;

    console.log("fromlocto id-->",selectedAcid);
    console.log("fromlocto value-->",fromlocto.value);
});
/* -------------------   color exits function --------------------*/

/*---------------------AJAX STARTS-------------------------- */

function funfetch() {
  var id = document.getElementById("workname").value;
  //console.log(id);

  $.ajax({
    url: 'fetch.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      var myData = work.work_nam;
      //  console.log(myData);

      // Update your HTML elements with fetched data
      document.getElementById("unit").value = work.dept;
      document.getElementById("itemopb").value = work.opb_wght;
      document.getElementById("bobin_qty").value = work.no_bobins;

      // Show the modal
      showModal();
      funfetch2();
    }
  });
}
/* ------------------------------------------------------------------------------------------------------------------------------  */

function funfetch2() {
  var id = document.getElementById("workname").value;
  //console.log(id);

  $.ajax({
    url: 'bobinfetch.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      const tableBody = document.getElementById("tbody");
      const maxrec = work.length;
      
      // Remove all rows except the last one
      while (tableBody.rows.length > 1) {
        tableBody.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
       

        const table = document.getElementById("modaltable"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Gmodaltableet the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='bobins[]']").value = invoice.bobin_no;
        lastRow.querySelector("[name='items[]']").value = invoice.itm_nam;
        lastRow.querySelector("[name='colors[]']").value = invoice.col_nam;
        // lastRow.querySelector("[name='wept_wghts[]']").value = "";

        if (index < maxrec - 1) {
          addRow();
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
/* ------------------------------------------------------------------------------------------------------------------------------  */

function showModal() {
  // Get the modal element
  const modal = document.getElementById("modal_bobin");
  modal.style.display = "block";
}

/* ------------------------------------------------------------------------------------------------------------------------------  */

function hideModal() {
  // Get the modal element
  const modal = document.getElementById("modal_bobin");
  // Hide the modal
  modal.style.display = "none";
}

// Event listener to close the modal
const closeBtn = document.querySelector(".close");
closeBtn.addEventListener("click", hideModal);

// Close the modal if the user clicks outside of it

/* ------------------------------------------------------------------------------------------------------------------------------  */

// Select the input field where you want to display the sum
const returnWeightInput = document.getElementById('ttlweight');

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
calculateTotalSum();

/* ------------------------------------------------------------------------------------------------------------------------------  */

document.getElementById('bln_wght_hnd').addEventListener("input",function calculateblnc() {
  
    // Get the values of itemopb and bln_wght_hnd inputs
    var itemopbValue = parseFloat(document.getElementById('itemopb').value) || 0;
    var bln_wght_hndValue = parseFloat(document.getElementById('bln_wght_hnd').value) || 0;
  
    // Perform the calculation
    var used_inbobinValue = itemopbValue - bln_wght_hndValue;
  
    // Set the result in the used_inbobin input
    document.getElementById('used_inbobin').value = used_inbobinValue;
  
});

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

  
  document.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
    }
});