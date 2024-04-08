  
  // Get the necessary elements
const box = document.getElementById('box');

box.addEventListener('change', function (event) {
    const selectedOption = event.target.value;
    const datalistOptions = document.getElementById('box_nos');
    
    const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
            var selectedid = option.getAttribute('data-id'); // Assign value to selectedAcid

            document.getElementById("hidden_box_id").value = selectedAcid;
            document.getElementById("hidden_txn_id").value = selectedid;

            break;
        }
    }
    // var id = document.getElementById("hidden_box_id").value;

    console.log("txn id-->",selectedid);
    console.log("box id-->",selectedAcid);
    console.log("box value-->",box.value);
    funfetch3();
});
  


function funfetch3() {
  var id = document.getElementById("hidden_txn_id").value;
 console.log(id);

  $.ajax({
    url: 'fetch/get_txn_idpirntrans.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      console.table('txn_id',work);
      const tableBody = document.getElementById("tbody");
      const maxrec = work.length;
      
      // Remove all rows except the last one
      while (tableBody.rows.length > 1) {
        tableBody.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log(invoice);
        const table = document.getElementById("modaltable"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='box_nos[]']").value = invoice.box_no;
        lastRow.querySelector("[name='items[]']").value = 0;
        lastRow.querySelector("[name='colors[]']").value = invoice.box_col_nam;
        lastRow.querySelector("[name='wghts[]']").value = 0;
        lastRow.querySelector("[name='hide_id[]']").value = invoice.id;

        if (index < maxrec - 1) {
          addRow();
          showModal();
        //  calculateTotalSum2();
        }
      });
    }
    
  });
  
}

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
  
  
  
  
  // Get the necessary elements
  var selectElement = document.getElementById('wevname');
  var hiddenInput = document.getElementById('selectedName');
  // Add an event listener to the select element
  selectElement.addEventListener('change', function() {
    // Get the selected option
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    
    // Get the ID and Name of the selected option
    var selectedId = selectedOption.value;
    var selectedName = selectedOption.text;
    console.log(selectedId);
    console.log(selectedName);
    // Update the hidden input field with the selected name
    hiddenInput.value = selectedName;
  });

  // Get the necessary elements
  var selectUnit = document.getElementById('loomnam');
  var hiddenUnit = document.getElementById('selectedUnit');
  // Add an event listener to the select element
  selectUnit.addEventListener('change', function() {
    var selectedunits = selectUnit.options[selectUnit.selectedIndex].text;
    console.log(selectedunits);
    document.getElementById('selectedunit').value=selectedunits;
  });

  var selectItem = document.getElementById('silk_nam');
  var hiddenItem = document.getElementById('selecteditem');
  selectItem.addEventListener('change', function() {
    var selectedItems = selectItem.options[selectItem.selectedIndex].text;
    console.log(selectedItems);
    document.getElementById('selecteditem').value=selectedItems;
  });

  var selectColor = document.getElementById('col_nam');
  var hiddenColor = document.getElementById('selectedcolor');
  selectColor.addEventListener('change', function() {
    var selectedColors = selectColor.options[selectColor.selectedIndex].text;
    console.log(selectedColors);
    document.getElementById('selectedcolor').value=selectedColors;
  });

  var selectzari = document.getElementById('zari_nam');
  var hiddenzari= document.getElementById('selectedzari');
  selectzari.addEventListener('change', function() {
    var selectedzari= selectzari.options[selectzari.selectedIndex].text;
    console.log(selectedzari);
    document.getElementById('selectedzari').value=selectedzari;
  });

  
  var fromloc = document.getElementById('fromloc');
  var hiddenColor = document.getElementById('selectedloc');
  fromloc.addEventListener('change', function() {
    var selectedloc = fromloc.options[fromloc.selectedIndex].text;
    console.log(selectedloc);
    document.getElementById('selectedloc').value=selectedloc;
  });

//   function postData() {
//     var table = document.getElementById('modaltable');
//     var rows = table.getElementsByTagName('tr');
//     var formData = new FormData();

//     for (var i = 1; i < rows.length; i++) { // Start from index 1 to skip header row
//         var checkbox = rows[i].querySelector('input[type="checkbox"]');
//         if (checkbox.checked) {
//             var boxId = rows[i].querySelector('input[name="box_nos[]"]').value;
//             var items = rows[i].querySelector('input[name="items[]"]').value;
//             var colors = rows[i].querySelector('input[name="colors[]"]').value;
//             var weight = rows[i].querySelector('input[name="wghts[]"]').value;

//             formData.append('boxIds[]', boxId);
//             formData.append('items[]', items);
//             formData.append('colors[]', colors);
//             formData.append('weights[]', weight);
//         }
//     }

//     // Now, you can post formData to your server using fetch or XMLHttpRequest
//     // Example using fetch:
//     fetch('save_trans/save_wev_det.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => {
//         // Handle response
//         console.log(response);
//     })
//     .catch(error => {
//         // Handle error
//         console.error('Error:', error);
//     });
// }
function postData() {
  var form = document.getElementById('wev_form');
  var formData = new FormData(form);

  fetch('save_trans/save_wev_det.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text())
  .then(data => {
      console.log(data); // Log the response from the server
  })
  .catch(error => {
      console.error('Error:', error);
  });
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