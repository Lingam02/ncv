function getbobin_id(rid){
  const rrow = rid.closest("tr");
  const rowname = rrow.querySelector("[name='bobins[]']");
  const rowid = rrow.querySelector("[name='hidden_bobin_id[]']");
  const datalistOptions = document.getElementById('bobin_options');
  
  const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === rowname.value) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

           rowid.value = selectedAcid;
          // console.log(selectedAcid);
            break;
        }
    }
    console.log('value',rowname.value);
    console.log('value id',selectedAcid);
}
function getitemname(rid){
  const rrow = rid.closest("tr");
  const rowname = rrow.querySelector("[name='itemnames[]']");
  const rowid = rrow.querySelector("[name='hidden_itemid[]']");
  const datalistOptions = document.getElementById('itemnamess');
  
  const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === rowname.value) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

           rowid.value = selectedAcid;
          console.log(selectedAcid);
            break;
        }
    }
}
function getitemcolor(rid){
  const rrow = rid.closest("tr");
  const rowname = rrow.querySelector("[name='colornames[]']");
  //console.log(rowname);
  const rowid = rrow.querySelector("[name='hidden_colorid[]']");
  const datalistOptions = document.getElementById('colornamess');
  
  const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === rowname.value) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

           rowid.value = selectedAcid;
          console.log( rowid.value);
            break;
        }
    }
}


//---------------------------------------------------------------------------------------
function limitToTwoDigits(input) {
  if (input.value.length > 2) {
    input.value = input.value.slice(0, 2); // Limit the input to the first two digits
  }
}
//---------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------
// Get the necessary elements
const workname = document.getElementById('workname');

workname.addEventListener('change', function (event) {
    const selectedOption = event.target.value;
    const datalistOptions = document.getElementById('workers');
    
    const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

            document.getElementById("hidden_workername").value = selectedAcid;

            break;
        }
    }
    var id = document.getElementById("hidden_workername").value;

    console.log("workname id-->",selectedAcid);
    console.log("workname value-->",workname.value);
});
//---------------------------------------------------------------------------------------
const unitname = document.getElementById('unitname');

unitname.addEventListener('change', function (event) {
    const selectedOption = event.target.value;
    const datalistOptions = document.getElementById('unitnames');
    
    const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-id'); // Corrected to 'data-id'

            document.getElementById("hidden_unitname").value = selectedAcid;

            break;
        }
    }

    console.log("unitname id-->", selectedAcid);
    console.log("unitname value-->", unitname.value);
});

//---------------------------------------------------------------------------------------
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

            document.getElementById("hidden_fromloc").value = selectedAcid;

            break;
        }
    }
    var id = document.getElementById("hidden_fromloc").value;

    console.log("fromloc id-->",selectedAcid);
    console.log("fromloc value-->",fromloc.value);
});
//---------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------



//---------------------------------------------------------------------------------------

  document.getElementById("no_bobins").addEventListener('change', function() {
    var numrows = document.getElementById("no_bobins").value;
    deleteRowsExceptLast();
    for (let i = 1; i < numrows; i++) {
      addRow();
    }

    showModal();
});
//======================================
// function checkselected() {
//   var zariRadio = document.getElementById('Zari');
//   var weftRadio = document.getElementById('Weft');
//   var bobinDiv = document.getElementById('bobin');
//   var itemTh = document.getElementById('itemth');
//   var itemTd = document.getElementById('itemtd');
//   var colorTh = document.getElementById('colorth');
//   var colorTd = document.getElementById('colortd');

//   if (zariRadio.checked) {
//     itemTh.style.display = "block";
//     itemTd.style.display = "block";
//     colorTh.style.display = "none";
//     colorTd.style.display = "none";
//     bobinDiv.style.display = 'block';
//   } else if (weftRadio.checked) {
//     colorTh.style.display = "block";
//     colorTd.style.display = "block";
//     itemTh.style.display = "none";
//     itemTd.style.display = "none";
//     bobinDiv.style.display = 'block';
//   } else {
//     itemTh.style.display = "none";
//     itemTd.style.display = "none";
//     colorTh.style.display = "none";
//     colorTd.style.display = "none";
//     bobinDiv.style.display = 'none';
//   }
// }
function checkselected() {
  const radioButtons = document.getElementsByName("Itmgroup");

  for (const radioButton of radioButtons) {
    if (radioButton.checked) {
      if (radioButton.id === "Zari") {
        document.getElementById("txnname").value='Zari'

        performZariFunction();
      } else if (radioButton.id === "Weft") {
        document.getElementById("txnname").value='Silk'
        performWeftFunction();
      }
    }
  }
}

function performZariFunction() {
  console.log("Zari function performed");
  // Add your Zari-specific logic here

  document.getElementById('itemth').style.display = "block";
  document.getElementById('itemtd').style.display = "block";

}

function performWeftFunction() {
  console.log("Weft function performed");
  // Add your Weft-specific logic here

  document.getElementById('colorth').style.display = "block";
  document.getElementById('colortd').style.display = "block";

}
/* ------------------------------------------------------------------------------------------------------------------------------  */

function addRow() {
  const tableBody = document.getElementById("tbody");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

  // Append the new row to the table body
  tableBody.appendChild(newRow);
}
//======================================

function deleteRowsExceptLast() {
  const tableBody = document.getElementById("tbody");
  const rows = tableBody.querySelectorAll("tr");

  // Keep the last row and remove the others
  for (let i = 0; i < rows.length - 1; i++) {
    rows[i].remove();
  }

  // Clear the input fields in the last row
  const lastRowInputs = rows[rows.length - 1].querySelectorAll("input[type='text'], input[type='number']");
  lastRowInputs.forEach((input) => (input.value = ""));
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
  //document.getElementById('returnweight').value = document.getElementById('itemopb').value - totalSum;
}

// Call the calculateTotalSum function whenever needed, e.g., when a new row is added
calculateTotalSum();

/* ------------------------------------------------------------------------------------------------------------------------------  */
  // Function to change the label text on double click
  document.getElementById('dynamicheading').ondblclick = function() {
    var newLabelText = prompt('Enter new label text:');
    if (newLabelText !== null) {
      document.getElementById('dynamicheading').innerText = newLabelText;
    }
  };

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