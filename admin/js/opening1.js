
const fromloc = document.getElementById('location');

fromloc.addEventListener('change', function (event) {
    const selectedOption = event.target.value;
    const datalistOptions = document.getElementById('locations');
    
    const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

            document.getElementById("hidden_location_id").value = selectedAcid;

            break;
        }
    }
    var id = document.getElementById("hidden_location_id").value;

    console.log("fromloc id-->",selectedAcid);
    console.log("fromloc value-->",fromloc.value);
});

//-----------------------------------------------------------------------------------------------------
  function getitemcolor(rid){
    const rrow = rid.closest("tr");
    const rowname = rrow.querySelector("[name='wept_colours[]']");
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
           
            console.log("fromloc id-->",selectedAcid);
            console.log("fromloc value-->",rowname.value);
              break;
          }
      }
  }
  
//-----------------------------------------------------------------------------------------------------

  function getwitemcolor(rid){
    const rrow = rid.closest("tr");
    const rowname = rrow.querySelector("[name='w_warp_colours[]']");
    //console.log(rowname);
    const rowid = rrow.querySelector("[name='w_hidden_colorid[]']");
    const datalistOptions = document.getElementById('wcolornamess');
    
    const options = datalistOptions.getElementsByTagName('option');
      for (let i = 0; i < options.length; i++) {
          const option = options[i];
          const optionValue = option.value;
  
          if (optionValue === rowname.value) {
              var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
  
             rowid.value = selectedAcid;
           
            console.log("fromloc id-->",selectedAcid);
            console.log("fromloc value-->",rowname.value);
              break;
          }
      }
  }
//-----------------------------------------------------------------------------------------------------
  
function getitemname(rid){
    const rrow = rid.closest("tr");
    const rowname = rrow.querySelector("[name='zarinames[]']");
    const rowid = rrow.querySelector("[name='hidden_zari_id[]']");
    const datalistOptions = document.getElementById('itemnamess');
    
    const options = datalistOptions.getElementsByTagName('option');
      for (let i = 0; i < options.length; i++) {
          const option = options[i];
          const optionValue = option.value;
  
          if (optionValue === rowname.value) {
              var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
  
             rowid.value = selectedAcid;
             console.log("fromloc id-->",selectedAcid);
             console.log("fromloc value-->",rowname.value);
              break;
          }
      }
  }
  
//-----------------------------------------------------------------------------------------------------

  function addw_warpRow() {
    const tableBody = document.getElementById("tbody_dws_warp");
    const firstRow = tableBody.querySelector("tr");
    const newRow = firstRow.cloneNode(true);

    // Clear the input fields in the new row
    const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
    addinginputs.forEach((input) => (input.value = ""));

   // newRow.cells[2].innerText = '1';
    
    // Append the new row to the table body
    tableBody.appendChild(newRow);
  }
//-----------------------------------------------------------------------------------------------------

function addweptRow() {
  const tableBody = document.getElementById("tbody_ds_wept");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

 // newRow.cells[2].innerText = '1';
  
  // Append the new row to the table body
  tableBody.appendChild(newRow);
}
//-----------------------------------------------------------------------------------------------------

function addzariRow() {
  const tableBody = document.getElementById("tbody_ds_zari");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

 // newRow.cells[2].innerText = '1';
  
  // Append the new row to the table body
  tableBody.appendChild(newRow);
}
//-----------------------------------------------------------------------------------------------------

document.getElementById("location").addEventListener('change',function fetchstock() {
  simulateAsyncDataFetching()
  var id = document.getElementById("hidden_location_id").value;
  console.log(id);
 
  $.ajax({
    url: 'fetch_opening1.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
    //console.log(work);
 
//-------------------
      let tableBody0 = document.getElementById("tbody_dws_warp");
      let maxrec0 = work.length;
      
      // Remove all rows except the last one
      while (tableBody0.rows.length > 1) {
        tableBody0.deleteRow(0);
      }
//-------------------

      work.forEach(function (invoice, index) {
        console.log('inv',invoice);
 if(invoice.tbl_type == "WARP" && invoice.itm_type == "DSS" && invoice.wght > 0 ){
          const table = document.getElementById("w_warp_tbl"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='warp_nos2[]']").value = invoice.warp_no;
        lastRow.querySelector("[name='w_warp_colours[]']").value = invoice.col_nam;
        lastRow.querySelector("[name='w_hidden_colorid[]']").value = invoice.col_id;
        lastRow.querySelector("[name='warp_wghts2[]']").value = invoice.wght;

        if (index < maxrec0 - 1) {
          addw_warpRow();
        }
        }
        //-------------------------
      });  

      const tableBody3 = document.getElementById("tbody_ds_wept");
      const maxrec3 = work.length;
      
      // Remove all rows except the last one
      while (tableBody3.rows.length > 1) {
        tableBody3.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log('inv',invoice);

        if(invoice.tbl_type == "WEFT" && invoice.itm_type == "DSS" && invoice.wght > 0){
          const table = document.getElementById("wept_tbl"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='wept_colours[]']").value = invoice.col_nam;
        lastRow.querySelector("[name='wept_wghts[]']").value = invoice.wght;
        lastRow.querySelector("[name='hidden_colorid[]']").value = invoice.col_id;
        if (index < maxrec3 - 1) {
          addweptRow();
        }
        }
        else if(invoice.tbl_type == "WEFT" && invoice.itm_type == "RS" && invoice.wght > 0){
          const table = document.getElementById("wept_tbl"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='wept_colours[]']").value = invoice.col_nam;
        lastRow.querySelector("[name='wept_wghts[]']").value = invoice.wght;
        lastRow.querySelector("[name='hidden_colorid[]']").value = invoice.col_id;
        if (index < maxrec3 - 1) {
          addweptRow();
        }
      
        }
        
      });  

      const tableBody2 = document.getElementById("tbody_ds_zari");
      const maxrec2 = work.length;
      
      // Remove all rows except the last one
      while (tableBody2.rows.length > 1) {
        tableBody2.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log('inv',invoice);

        if(invoice.tbl_type == "ZARI" && invoice.itm_type == "DSS" && invoice.wght > 0){
          const table = document.getElementById("zari_tbl"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='zarinames[]']").value = invoice.itm_nam;
        lastRow.querySelector("[name='zari_wghts[]']").value = invoice.wght;
        lastRow.querySelector("[name='hidden_zari_id[]']").value = invoice.itm_id;


        if (index < maxrec2 - 1) {
          addzariRow();
        }
        }
        else if(invoice.tbl_type == "ZARI" && invoice.itm_type == "RS" && invoice.wght > 0){
          const table = document.getElementById("zari_tbl"); // Replace with your table ID
          const lastRow = table.rows[table.rows.length - 1]; // Get the last row
  
          // Populate the last row with your data
          lastRow.querySelector("[name='zarinames[]']").value = invoice.itm_nam;
          lastRow.querySelector("[name='zari_wghts[]']").value = invoice.wght;
          lastRow.querySelector("[name='hidden_zari_id[]']").value = invoice.itm_id;
  
  
          if (index < maxrec2 - 1) {
            addzariRow();
          }
        }
        
      });  
      

    }
  });
});



function clearpage() {
  location.reload();
}

document.getElementById("location").addEventListener('input',function() {
if (document.getElementById("location").value == "") {
  location.reload();
} 

})


document.getElementById('loader').style.display = 'none';
function simulateAsyncDataFetching() {
  // Display the loader while data is being fetched
  document.getElementById('loader').style.display = 'block';

  // Simulate an Ajax request delay (replace this with your actual data fetching code)
  setTimeout(function () {
    // Hide the loader
    document.getElementById('loader').style.display = 'none';
  }, 500); // Simulated 2-second delay for data fetching
}