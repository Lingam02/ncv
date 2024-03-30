//---------------------------------------------------------------------------------------
const loom_nam = document.getElementById('loom_nam');

loom_nam.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('loom_nams');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("loom_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("loom_id").value;
  get_frm_loomid();
  console.log("hidden_loom_id-->", selectedAcid);
  console.log("loom_id value-->", loom_nam.value);
});
//---------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------
const iss_location = document.getElementById('iss_location');

iss_location.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('iss_locations');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("loc_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("loc_id").value;

  console.log("iss_location id-->", selectedAcid);
  console.log("iss_location value-->", iss_location.value);
});
//---------------------------------------------------------------------------------------
const iss_location2 = document.getElementById('iss_location2');

iss_location2.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('iss_location2s');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("loc_id2").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("loc_id2").value;

  console.log("iss_location2 id-->", selectedAcid);
  console.log("iss_location2 value-->", iss_location2.value);
});
//---------------------------------------------------------------------------------------

const iss_warp = document.getElementById('iss_warp');

iss_warp.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('iss_warps');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("hidden_iss_warp").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("hidden_iss_warp").value;

  console.log("hidden_iss_warp-->", selectedAcid);
  console.log("iss_warp value-->", iss_warp.value);
  fetch_splitted_kora();
});
//---------------------------------------------------------------------------------------

function fetch_splitted_kora() {

    var id = document.getElementById("hidden_iss_warp").value;
    console.log('ok',id);
    $.ajax({
      url: 'fetch/fetch_splitted_kora.php',
      method: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function (work) {
        console.log('we',work);
        document.getElementById("ply").value = work.ply;
        document.getElementById("section").value = work.section;
        document.getElementById("wght").value = work.silk_wght;
        document.getElementById("yard").value = work.yard;
        document.getElementById("no_saree").value = work.no_saree;
        document.getElementById("muzham").value = work.muzham;
        document.getElementById("one_section").value = work.one_section;
        document.getElementById("s_count").value = work.s_count;
        document.getElementById("reff_id").value = work.hd_id;
      }      
    });
  }
  function get_frm_loomid() {
    var id = document.getElementById("loom_id").value;
    $.ajax({
      url: 'fetch/get_frm_loomid.php',
      method: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function (work) {
        console.log('work',work);
        // document.getElementById("iss_location").value = work.loc_nam;
        // document.getElementById("loc_id").value = work.loc_id;
        // document.getElementById("iss_location2").value = work.loc_nam2;
        // document.getElementById("loc_id2").value = work.loc_id2;
        let tableBody0 = document.getElementById("sep_iss_body2");
        let maxrec0 = work.length;
        
        // Remove all rows except the last one
        while (tableBody0.rows.length > 1) {
          tableBody0.deleteRow(0);
        }
  //-------------------
  
        work.forEach(function (invoice, index) {
          console.log('inv',invoice);
         const table = document.getElementById("entry_table2"); // Replace with your table ID
         const lastRow = table.rows[table.rows.length - 1]; // Get the last row
  
          // Populate the last row with your data
          lastRow.querySelector("[name='yard2[]']").value = invoice.yard;
          lastRow.querySelector("[name='no_saree2[]']").value = invoice.no_saree;
          lastRow.querySelector("[name='muzham2[]']").value = invoice.muzham;
          lastRow.querySelector("[name='one_section2[]']").value = invoice.one_section;
          lastRow.querySelector("[name='s_count2[]']").value = invoice.s_count;
          // 
          lastRow.querySelector("[name='warp_no2[]']").value = invoice.warp_no;
          lastRow.querySelector("[name='border_nam2[]']").value = invoice.typ;
          lastRow.querySelector("[name='ply2[]']").value = invoice.ply;
          lastRow.querySelector("[name='section2[]']").value = invoice.section;
          lastRow.querySelector("[name='wght2[]']").value = invoice.wght;
          showlocnam();
          // document.getElementById("entry_table2").style.Display = 'block';
          if (index < maxrec0 - 1) {
            addRow();
          }
          
          //-------------------------
        });  
//-------------------------------------------------------------uuuu---  
        
      }      
    });
  }
function showlocnam() {

  var id = document.getElementById("loom_id").value;
  console.log('ok',id);
  $.ajax({
    url: 'fetch/get_frm_sep_locid.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      console.log('work',work);
      document.getElementById("iss_location").value = work.loc_nam;
      document.getElementById("loc_id").value = work.loc_id;
      document.getElementById("iss_location2").value = work.loc_nam2;
      document.getElementById("loc_id2").value = work.loc_id2;}
      
     } );  
}
//---------------------------------------------------------------------------------------
  
function addRow() {
  const tableBody = document.getElementById("sep_iss_body2");
  const firstRow = tableBody.querySelector(".trow2");
  const newRow = firstRow.cloneNode(true);
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));
  tableBody.appendChild(newRow);
}

//---------------------------------------------------------------------------------------
function handleEnterKey(event, nextElementId) {
  if (event.key === 'Enter') {
    event.preventDefault();
    const nextElement = document.getElementById(nextElementId);
    nextElement.focus();
    nextElement.select();
  }
}
//---------------------------------------------------------------------------------------

// $(document).ready(function() {
//   $("#iss_warp").change(function() {
//       var id = document.getElementById("hidden_iss_warp").value;
//           console.log(id);
//       $.ajax({
//           url: 'fetch/fetch_tag_pop.php',
//           method: "POST",
//           data: { id: id },
//           success: function(data) {
//               console.log(data);
//               populateTable(data);
//           }
//       });
//   });
// });
// //---------------------------------------------------------------------------------------
// function populateTable(data) {
//   // Clear existing table rows
//   $("#tag_pop tbody").empty();
//   // Check if data is an array
//   if (Array.isArray(data)) {
//       // Loop through data and append rows to table
//       data.forEach(function(item) {
//           console.log("Item:", item);
//           var row = "<tr class ='t_row'>" +
//           "<td>" + item.pur_invno + "</td>" +
//           "<td>" + item.warp_no + "</td>" +
//           "<td>" + item.wght + "</td>" +
//           "<td>" + item.ply + "</td>" +
//           "<td>" + item.yard + "</td>" +
//           "<td>" + item.no_saree + "</td>" +
//           "<td>" + item.muzham + "</td>" +
//           "<td>" + item.section + "</td>" +
//           "<td>" + item.one_section + "</td>" +
//           "<td>" + item.s_count + "</td>" +
//           "<td>" + item.silk_wght + "</td>" +
//           "</tr>";
//         $("#tag_pop tbody").append(row);
//       });
//   } else {
//       console.log("Data is not an array:", data);
//   }
// }
//---------------------------------------------------------------------------------------

// add_btn = document.getElementById('add_row');
// add_btn.addEventListener('click',function add() {
//   tbody = document.getElementById('sep_iss_body');

// trow = document.querySelector('.trow');
// newrow = trow.cloneNode(true);
// const addinginputs = newrow.querySelectorAll("input[type='text']");
// addinginputs.forEach((input) => (input.value = ""));

// // Append the new row to the table body
// tbody.appendChild(newrow);
// });
// //---------------------------------------------------------------------------------------

//  function cutss() {
//   tbody = document.getElementById('sep_iss_body');

//   // Select the first row with class 'trow'
//   trow = document.querySelector('.trow');

//   // Clone the selected row
//   newrow = trow.cloneNode(true);

//   // Remove the existing row from the table body
//   tbody.removeChild(trow);
// }

//---------------------------------------------------------------------------------------
