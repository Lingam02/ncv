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
      var selectedAcid = option.getAttribute('data-id'); // Assign value to selectedAcid
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
function fetch_splitted_kora() {

    var id = document.getElementById("hidden_iss_warp").value;
    console.log('ok',id);
    $.ajax({
      url: 'fetch/fetch_splitted_kora.php',
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
          lastRow.querySelector("[name='ply[]']").value = invoice.warp_ply;
          lastRow.querySelector("[name='warp_wghts[]']").value = invoice.warp_wght;
          lastRow.querySelector("[name='sections[]']").value = invoice.section;
          lastRow.querySelector("[name='count[]']").value = invoice.count;
          // lastRow.querySelector("[name='wept_wghts[]']").value = "";
  
          if (index < maxrec - 1) {
            addRow();
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


$(document).ready(function() {
  $("#iss_warp").change(function() {
      var id = document.getElementById("hidden_iss_warp").value;
          console.log(id);
      // console.log('ok');
   
      // Make AJAX request
      $.ajax({
          url: 'fetch/fetch_tag_pop.php',
          method: "POST",
          data: { id: id },
          success: function(data) {
              console.log(data);
              // Populate table with data and calculate totals
              populateTable(data);
          }
      });
  });
});
// document.getElementById('tag_reports').style.display = 'none';

function populateTable(data) {
  // Clear existing table rows
  $("#tag_pop tbody").empty();


  // Check if data is an array
  if (Array.isArray(data)) {
      // Loop through data and append rows to table
      data.forEach(function(item) {
          console.log("Item:", item);
          var row = "<tr class ='t_row'>" +
          "<td>" + item.pur_invno + "</td>" +
          "<td>" + item.warp_no + "</td>" +
          "<td>" + item.wght + "</td>" +
          "<td>" + item.ply + "</td>" +
          "<td>" + item.yard + "</td>" +
          "<td>" + item.no_saree + "</td>" +
          "<td>" + item.muzham + "</td>" +
          "<td>" + item.section + "</td>" +
          "<td>" + item.one_section + "</td>" +
          "<td>" + item.s_count + "</td>" +
          "<td>" + item.silk_wght + "</td>" +
          "</tr>";
$("#tag_pop tbody").append(row);

      });


  } else {
      console.log("Data is not an array:", data);
  }
}
