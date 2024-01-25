
//============ script for date set default in input field visible starts===============
window.onload = function () {
  var currentDate = new Date();
  var day = currentDate.getDate();
  var month = currentDate.getMonth() + 1; // Month is zero-based
  var year = currentDate.getFullYear();

  // Format the date as YYYY-MM-DD (ISO format)
  var formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');

  // Set the value attribute of the input field
  document.getElementById('doc_date').value = formattedDate;
  document.getElementById('reff_date').value = formattedDate;

};

//=============== script for date ends ================= 

//--------- script for display model starts-------------
document.getElementById("txn_nam").addEventListener("change", function () {
  var selectedValue = this.value;

  // Check if the selected value is "Silk Return" or "Kora Return"
  if (selectedValue === "KORA_ISS") {
    // Display the modal or perform any other action
    document.getElementById("reff_none").style.display = "none";
  } else {
    // Hide the modal if the selected value is not "Silk Return" or "Kora Return"
    document.getElementById("reff_none").style.display = "block";
  }
  if (selectedValue === "SILK_RET") {
    // Display the modal or perform any other action
    document.getElementById("modal").style.display = "block";
  } else {
    // Hide the modal if the selected value is not "Silk Return" or "Kora Return"
    document.getElementById("modal").style.display = "none";
  }
  // if (selectedValue === "KORA_RET") {
  //   // Display the modal or perform any other action
  //   document.getElementById("raw_return").style.display = "block";
  // } else {
  //   // Hide the raw_return if the selected value is not "Silk Return" or "Kora Return"
  //   document.getElementById("raw_return").style.display = "none";
  // }
});

var closeModal = document.getElementsByClassName("close")[0];

closeModal.addEventListener("click", function () {
  modal.style.display = "none";
});

// var closeModal = document.getElementsByClassName("close")[1];

// closeModal.addEventListener("click", function () {
//   document.getElementById("raw_return").style.display = "none";

// });
//--------- script for display model ends-------------

// to get dyer id
const dyername = document.getElementById('to_from');

dyername.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('twisterlist');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-grpid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("hidden_dyer_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("hidden_dyer_id").value;

  console.log("dyer id-->", selectedAcid);
  console.log("dyername value-->", dyername.value);
});
const dyername2 = document.getElementById('dyer_nam_modal');

dyername2.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('twisterlist');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-grpid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("hidden_dyer_id2").value = selectedAcid;
      break;
    }
  }
  var id = document.getElementById("hidden_dyer_id2").value;

  console.log("dyer id-->", selectedAcid);
  console.log("dyername2 value-->", dyername2.value);
  document.getElementById("hidden_dyer_id").value = selectedAcid;
  document.getElementById('to_from').value = dyername2.value;

});

// // dyer id gets ends .....
// const dyername5 = document.getElementById('dyer_nam_modal2');

// dyername5.addEventListener('change', function (event) {
//   const selectedOption = event.target.value;
//   const datalistOptions = document.getElementById('twisterlist');

//   const options = datalistOptions.getElementsByTagName('option');
//   for (let i = 0; i < options.length; i++) {
//     const option = options[i];
//     const optionValue = option.value;

//     if (optionValue === selectedOption) {
//       var selectedAcid = option.getAttribute('data-grpid'); // Assign value to selectedAcid
//       //console.log('ok',selectedAcid);

//       document.getElementById("hidden_dyer_id3").value = selectedAcid;
//       break;
//     }
//   }
//   var id = document.getElementById("hidden_dyer_id3").value;

//   console.log("dyer id-->", selectedAcid);
//   console.log("dyername5 value-->", dyername5.value);
//   document.getElementById("hidden_dyer_id").value = selectedAcid;
//   document.getElementById('dyer_nam_modal2').value = dyername5.value;

// });

// dyer id gets ends .....

// item id gets starts.
function getitemid(rid) {
  const rrow = rid.closest("tr");
  const rowname = rrow.querySelector("[name='itm_name[]']");
  //console.log(rowname);
  const rowid = rrow.querySelector("[name='it_id[]']");
  const datalistOptions = document.getElementById('dyerlist');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === rowname.value) {
      var selectedAcid = option.getAttribute('data-grpid'); // Assign value to selectedAcid

      rowid.value = selectedAcid;
      console.log(rowid.value);
      console.log("item id-->", selectedAcid);
      console.log("item value-->", rowname.value);
      break;
    }
  }
}
// item id gets ends.

function addRow() {
  //alert('ok')
  const tableBody = document.getElementById("table-body");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

 // newRow.cells[2].innerText = '1';
  
  // Append the new row to the table body
  tableBody.appendChild(newRow);
}

function addRow2() {
  //alert('ok')
  const tableBody = document.getElementById("table-body2");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

 // newRow.cells[2].innerText = '1';
  
  // Append the new row to the table body
  tableBody.appendChild(newRow);
}
// function addRow3() {
//   //alert('ok')
//   const tableBody = document.getElementById("table-body3");
//   const firstRow = tableBody.querySelector("tr");
//   const newRow = firstRow.cloneNode(true);

//   // Clear the input fields in the new row
//   const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
//   addinginputs.forEach((input) => (input.value = ""));

//  // newRow.cells[2].innerText = '1';
  
//   // Append the new row to the table body
//   tableBody.appendChild(newRow);
// }


// dyer ajax geting id, displaying details
const dyername3 = document.getElementById('dyer_nam_modal');

dyername3.addEventListener('change',function fetch_dyer() {

//------------------------------------------------------------------------

  // const tableBody = document.getElementById("table-body2");
  // const firstRow = tableBody.querySelector("tr");
  // const newRow = firstRow.cloneNode(true);

  // // Clear the input fields in the new row
  // const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  // addinginputs.forEach((input) => (input.value = ""));
//------------------------------------------------------------------------
  var id = document.getElementById("hidden_dyer_id2").value;
  console.log(id);

  $.ajax({
    url: 'fetch_dyer_id.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      console.log('work', work);
      const tableBody = document.getElementById("table-body2");
      const maxrec = work.length;

      // Remove all rows except the last one
      while (tableBody.rows.length > 1) {
        tableBody.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log('inv', invoice);
        document.getElementById('reff_no').value = invoice.iss_no;
        document.getElementById('reff_date').value = invoice.iss_date;
        document.getElementById('doc_no').value = invoice.ret_no;

        if (invoice.wght > 0) {
          const table = document.getElementById("raw_table2"); // Replace with your table ID
          const lastRow = table.rows[table.rows.length - 1]; // Get the last row

          // Populate the last row with your data
          lastRow.querySelector("[name='iss_date2[]']").value = invoice.iss_date;
          lastRow.querySelector("[name='iss_no2[]']").value = invoice.iss_no;
          lastRow.querySelector("[name='it_id2[]']").value = invoice.itm_id;
          lastRow.querySelector("[name='itm_name2[]']").value = invoice.itm_nam;
          lastRow.querySelector("[name='remarks2[]']").value = invoice.remarks;
          lastRow.querySelector("[name='qty2[]']").value = invoice.wght;

          if (index < maxrec - 1) {
            addRow2();
          }
        }

      });

    }
  });
});

//---------------------------------------//------------------------------//---------------------------------



// // dyer ajax geting id, displaying details
// const dyername4 = document.getElementById('dyer_nam_modal2');

// dyername4.addEventListener('change',function fetch_dyer() {
//   var id = document.getElementById("hidden_dyer_id3").value;
//   console.log(id);

//   $.ajax({
//     url: 'fetch_dyer_id.php',
//     method: 'POST',
//     data: { id: id },
//     dataType: 'json',
//     success: function (work) {
//       console.log('work', work);
//       const tableBody = document.getElementById("table-body3");
//       const maxrec = work.length;

//       // Remove all rows except the last one
//       while (tableBody.rows.length > 1) {
//         tableBody.deleteRow(0);
//       }

//       work.forEach(function (invoice, index) {
//         console.log('inv', invoice);
//         document.getElementById('reff_no').value = invoice.iss_no;
//         document.getElementById('reff_date').value = invoice.iss_date;

//         if (invoice.wght > 0) {
//           const table = document.getElementById("raw_table3"); // Replace with your table ID
//           const lastRow = table.rows[table.rows.length - 1]; // Get the last row

//           // Populate the last row with your data
//           lastRow.querySelector("[name='iss_date3[]']").value = invoice.iss_date;
//           lastRow.querySelector("[name='iss_no3[]']").value = invoice.iss_no;
//           lastRow.querySelector("[name='it_id3[]']").value = invoice.itm_id;
//           lastRow.querySelector("[name='itm_name3[]']").value = invoice.itm_nam;
//           lastRow.querySelector("[name='remarks3[]']").value = invoice.remarks;
//           lastRow.querySelector("[name='qty3[]']").value = invoice.wght;

//           if (index < maxrec - 1) {
//             addRow3();
//           }
//         }

//       });

//     }
//   });
// });



///--------------------------//-------------------//----------------------//---------------------------------

document.addEventListener('click', function (event) {

  if (event.target.classList.contains('delete-row')) {
    var row = event.target.parentNode.parentNode;
    row.parentNode.removeChild(row);
    calculateTotal();
    calculateTotal_modal();
  }
  // if (row<[1]) {
  //     deleteButtons.style.display = "none";
  // }
});

document.addEventListener('input', function (event) {
  if (event.target.classList.contains('qty')) {
    calculateTotal();
    calculateTotal_modal();
  }
});

function calculateTotal() {
  var total = 0;
  var quantityInputs = document.getElementsByClassName('qty');
  var totalInput = document.getElementById('tot_qty');

  for (var i = 0; i < quantityInputs.length; i++) {
    var qty = parseInt(quantityInputs[i].value) || 0;
    total += qty;
  }

  totalInput.value = total;
}
function calculateTotal_modal() {
  var total = 0;
  var quantityInputs = document.getElementsByClassName('qty2');
  var totalInput = document.getElementById('tot_qty2');

  for (var i = 0; i < quantityInputs.length; i++) {
    var qty = parseInt(quantityInputs[i].value) || 0;
    total += qty;
  }

  totalInput.value = total;
}


document.addEventListener('DOMContentLoaded', function() {
  document.querySelector('form').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
          e.preventDefault();
      }
  });
});



document.getElementById('dyerform').addEventListener('submit', function(event) {
  var selectedValue = document.getElementById('txn_nam').value;
  var otherValue = document.getElementById('to_from').value;

  if (selectedValue.trim() === '' && otherValue.trim() === "") {
    document.getElementById('txn_nam').classList.add('select-error');
    event.preventDefault(); // Prevent form submission
  } else {
    document.getElementById('txn_nam').classList.remove('select-error');
    document.getElementById('txn_nam').classList.remove('select-error1');
    // You might want to remove the error class from 'to_from' field if needed
    // document.getElementById('to_from').classList.remove('select-error');
    // Form will submit with valid selection(s)
  }
});

function transferValue(checkbox) {
  if (checkbox.checked) {
      // Get the parent row of the checkbox
      let parentRow = checkbox.closest('.item-row');
      
      // Find the corresponding row in the other table body
      let targetRow = document.querySelector('#table-body .item-row');

      // Select the input fields from both rows
      let sourceInputs = parentRow.querySelectorAll(' input[name^="itm_name2"], input[name^="remarks2"], input[name^="qty2"]');
      let targetInputs = targetRow.querySelectorAll(' input[name^="itm_name"], input[name^="remarks"], input[name^="qty"]');
      
      // Transfer values from source to target inputs
      sourceInputs.forEach((input, index) => {
          targetInputs[index].value = input.value;
      });
  document.getElementById("modal").style.display = "none";
  SHOWBTN();

  }

}

document.addEventListener('DOMContentLoaded', function() {
  var tname = document.getElementById("txn_nam").value;
  
  if (tname === "KORA_ISS" || tname === "") {
    document.getElementById("add-row").style.display = 'none';
  }
});

function SHOWBTN() {
  var tname = document.getElementById("txn_nam").value;

  if ( tname === "SILK_RET"){
    
    document.getElementById("add-row").style.display = 'block';
  }
}