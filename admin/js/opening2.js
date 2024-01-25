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

    console.log("location id-->",selectedAcid);
    console.log("location value-->",fromloc.value);
});


  function getitemcolor(rid){
    const rrow = rid.closest("tr");
    const rowname = rrow.querySelector("[name='wept_colours[]']");
    //console.log(rowname);
    const rowid = rrow.querySelector("[name='hidden_weft_id[]']");
    const datalistOptions = document.getElementById('colornamess');
    
    const options = datalistOptions.getElementsByTagName('option');
      for (let i = 0; i < options.length; i++) {
          const option = options[i];
          const optionValue = option.value;
  
          if (optionValue === rowname.value) {
              var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
  
             rowid.value = selectedAcid;
           
            console.log("weft id-->",selectedAcid);
            console.log("weft value-->",rowname.value);
              break;
          }
      }
  }
  
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
             console.log("zari id-->",selectedAcid);
             console.log("zari value-->",rowname.value);
              break;
          }
      }
  }
  
  
function bobinid(rid){
    const rrow = rid.closest("tr");
    const rowname = rrow.querySelector("[name='bobins[]']");
    const rowid = rrow.querySelector("[name='hidden_bobins_id[]']");
    const datalistOptions = document.getElementById('bobin_options');
    
    const options = datalistOptions.getElementsByTagName('option');
      for (let i = 0; i < options.length; i++) {
          const option = options[i];
          const optionValue = option.value;
  
          if (optionValue === rowname.value) {
              var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
  
             rowid.value = selectedAcid;
             console.log("bobins id-->",selectedAcid);
             console.log("bobins value-->",rowname.value);
              break;
          }
      }
  }
  
function bobinid2(rid){
    const rrow = rid.closest("tr");
    const rowname = rrow.querySelector("[name='bobins2[]']");
    const rowid = rrow.querySelector("[name='hidden_bobins_id2[]']");
    const datalistOptions = document.getElementById('bobin_options2');
    
    const options = datalistOptions.getElementsByTagName('option');
      for (let i = 0; i < options.length; i++) {
          const option = options[i];
          const optionValue = option.value;
  
          if (optionValue === rowname.value) {
              var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
  
             rowid.value = selectedAcid;
             console.log("bobins id-->",selectedAcid);
             console.log("bobins value-->",rowname.value);
              break;
          }
      }
  }
  
  //---------------------------------------------------------------------------------------



  // /* --------------------- ADD ROW FOR ( WEPT DYEDSILKS TBL2 ) ----------------------------------- */

function addweptRow() {
  const tableBody = document.getElementById("tbody_bs_wept");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

 // newRow.cells[2].innerText = '1';
  
  // Append the new row to the table body
  tableBody.appendChild(newRow);
}


// /* --------------------- ADD ROW FOR ( WEPT DYEDSILKS TBL2 ) ENDS----------------------------------- */

// /* --------------------- ADD ROW FOR ( ZARI DYEDSILKS TBL3 )  STARTS-------------------------------- */

function addzariRow() {
  const tableBody = document.getElementById("tbody_bs_zari");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

 // newRow.cells[2].innerText = '1';
  
  // Append the new row to the table body
  tableBody.appendChild(newRow);
}

/* --------------------- ADD ROW FOR (  ZARI DYEDSILKS TBL3 )  ENDS -------------------------------- */

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
    
     
      const tableBody3 = document.getElementById("tbody_bs_wept");
      const maxrec3 = work.length;
      
      // Remove all rows except the last one
      while (tableBody3.rows.length > 1) {
        tableBody3.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log('inv',invoice);

        if(invoice.tbl_type == "WEFTBS" && invoice.itm_type == "BS" && invoice.wght > 0){
          const table = document.getElementById("wept_tbl"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='bobins[]']").value = invoice.reff_nam;
        lastRow.querySelector("[name='hidden_bobins_id[]']").value = invoice.reff_id;
        lastRow.querySelector("[name='wept_colours[]']").value = invoice.col_nam;
        lastRow.querySelector("[name='hidden_weft_id[]']").value = invoice.col_id;
        lastRow.querySelector("[name='wghts[]']").value = invoice.wght;
        // lastRow.querySelector("[name='qtys[]']").value = invoice.qty;

        if (index < maxrec3 - 1) {
          addweptRow();
        }
        }
        
      });  

      const tableBody2 = document.getElementById("tbody_bs_zari");
      const maxrec2 = work.length;
      
      // Remove all rows except the last one
      while (tableBody2.rows.length > 1) {
        tableBody2.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log('inv',invoice);

        if(invoice.tbl_type == "ZARIBS" && invoice.itm_type == "BS" && invoice.wght > 0){
          const table = document.getElementById("zari_tbl"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='bobins2[]']").value = invoice.reff_nam;
        lastRow.querySelector("[name='hidden_bobins_id2[]']").value = invoice.reff_id;
        lastRow.querySelector("[name='zarinames[]']").value = invoice.itm_nam;
        lastRow.querySelector("[name='hidden_zari_id[]']").value = invoice.itm_id;
        lastRow.querySelector("[name='wghts2[]']").value = invoice.wght;
        // lastRow.querySelector("[name='qtys2[]']").value = invoice.qty;

        if (index < maxrec2 - 1) {
          addzariRow();
        }
        }
        
      });  
      

    }
  });
});

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

// function scrollToBottom() {
//   // Scroll to the bottom of the page
//   window.scrollTo(0, document.body.scrollHeight);
// }
document.getElementById('scroll').innerHTML = 'Fast Scroll'
function toggleScroll() {
  var currentPosition = window.scrollY || document.documentElement.scrollTop;

  if (currentPosition === 0) {
    // If at the top, scroll to the bottom
    window.scrollTo(0, document.body.scrollHeight);
  } else {
    // If at the bottom, scroll to the top
    window.scrollTo(0, 0);

  }
}
