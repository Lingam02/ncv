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
    console.log("location2 id-->",document.getElementById("hidden_location_id").value);
    console.log("location value-->",fromloc.value);
});


  function getitembox(rid){
    const rrow = rid.closest("tr");
    const rowname = rrow.querySelector("[name='boxes[]']");
    //console.log(rowname);
    const rowid = rrow.querySelector("[name='hidden_box_id[]']");
    const datalistOptions = document.getElementById('box_nos');
    
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
  //---------------

  function getitembox2(rid){
    const rrow = rid.closest("tr");
    const rowname = rrow.querySelector("[name='boxes2[]']");
    //console.log(rowname);
    const rowid = rrow.querySelector("[name='hidden_box2_id[]']");
    const datalistOptions = document.getElementById('box_nos2');
    
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
  //-----------------

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
  
 


/* --------------------- ADD ROW FOR (PIRN STORE WEPT TBL1 )  STARTS-------------------------------- */

function addweptRow() {
  const tableBody = document.getElementById("tbody_ps_weft");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

 // newRow.cells[2].innerText = '1';
  
  // Append the new row to the table body
  tableBody.appendChild(newRow);
}


/* --------------------- ADD ROW FOR (PIRN STORE WEPT TBL1 )  ENDS -------------------------------- */

/* --------------------- ADD ROW FOR (PIRN STORE ZARI TBL2 )  STARTS-------------------------------- */

function addzariRow() {
  const tableBody = document.getElementById("tbody_ps_zari");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

 // newRow.cells[2].innerText = '1';
  
  // Append the new row to the table body
  tableBody.appendChild(newRow);
}
/* --------------------- ADD ROW FOR (PIRN STORE ZARI TBL2 )  ENDS -------------------------------- */

document.getElementById("location").addEventListener('change',function fetchstock() {
  var id = document.getElementById("hidden_location_id").value;
  console.log(id);

  $.ajax({
    url: 'fetch_opening1.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
    
     
      const tableBody3 = document.getElementById("tbody_ps_weft");
      const maxrec3 = work.length;
      
      // Remove all rows except the last one
      while (tableBody3.rows.length > 1) {
        tableBody3.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log('inv',invoice);

        if(invoice.tbl_type == "WEFTPS" && invoice.itm_type == "PS" && invoice.wght > 0){
          const table = document.getElementById("wept_tbl"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='hidden_box_id[]']").value = invoice.box_id;
        lastRow.querySelector("[name='boxes[]']").value = invoice.box_no;
        lastRow.querySelector("[name='hidden_weft_id[]']").value = invoice.col_id;
        lastRow.querySelector("[name='wept_colours[]']").value = invoice.col_nam;
        lastRow.querySelector("[name='wghts[]']").value = invoice.wght;
        lastRow.querySelector("[name='qtys[]']").value = invoice.qty;

        if (index < maxrec3 - 1) {
          addweptRow();
        }
        }
        
      });  

      const tableBody2 = document.getElementById("tbody_ps_zari");
      const maxrec2 = work.length;
      
      // Remove all rows except the last one
      while (tableBody2.rows.length > 1) {
        tableBody2.deleteRow(0);
      }

      work.forEach(function (invoice, index) {
        console.log('inv',invoice);

        if(invoice.tbl_type == "ZARIPS" && invoice.itm_type == "PS" && invoice.wght > 0){
          const table = document.getElementById("zari_tbl"); // Replace with your table ID
        const lastRow = table.rows[table.rows.length - 1]; // Get the last row

        // Populate the last row with your data
        lastRow.querySelector("[name='hidden_box2_id[]']").value = invoice.box_id;
        lastRow.querySelector("[name='boxes2[]']").value = invoice.box_no;
        lastRow.querySelector("[name='hidden_zari_id[]']").value = invoice.itm_id;
        lastRow.querySelector("[name='zarinames[]']").value = invoice.itm_nam;
        lastRow.querySelector("[name='wghts2[]']").value = invoice.wght;
        lastRow.querySelector("[name='qtys2[]']").value = invoice.qty;

        if (index < maxrec2 - 1) {
          addzariRow();
        }
        }
        
      });  
      

    }
  });
});

