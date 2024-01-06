
document.getElementById("itemopb_bobinqty").addEventListener('change', function() {
    var numrows = document.getElementById("itemopb_bobinqty").value;
    deleteRowsExceptLast();
    for (let i = 1; i < numrows; i++) {
      addRow();
    }

    showModal();
});

document.getElementById("box_qty").addEventListener('change', function() {
    var numrows = document.getElementById("box_qty").value;
    deleteRowsExceptLast2();
    for (let i = 1; i < numrows; i++) {
      addRow2();
    }

   
});


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

function addRow2() {
    const tableBody = document.getElementById("tbody2");
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
  
  function deleteRowsExceptLast2() {
    const tableBody = document.getElementById("tbody2");
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