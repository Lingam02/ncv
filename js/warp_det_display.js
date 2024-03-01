
const bill_no_input4 = document.getElementById('bill_no4');

bill_no_input4.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('pur_bill4');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("pur_bill_id4").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("pur_bill_id4").value;

  console.log("pur_bill_id4-->", selectedAcid);
  console.log("bill_no_input4 value-->", bill_no_input4.value);

//   display_details();
});

// function display_details() {
//     var id = document.getElementById("pur_bill_id4").value;
//     console.log(id);
//     $.ajax({
//         url: 'fetch/fetch_det_warptbl.php',
//         method: 'POST',
//         data: { id: id },
//         dataType: 'json',
//         success: function (work) {
//             console.log('Received work array:', work);
//             var numrows = work.length;
//             let S_NO = 2; // Start with 2 to avoid leading '1'
//             for (let i = 0; i < numrows - 1; i++) {
//               addRow_warp(S_NO);
//               S_NO++;
//             }
//             // Loop through each invoice object in the work array
//             work.forEach(function(invoice, index) {
//                 // Populate input fields with data from the current invoice
//                 var row = index + 1; // Add 1 to the index to match table row index
//                 document.querySelector("#tbody_ds_warp tr:nth-child(" + row + ") [name='mozham[]']").value = invoice.muzham;
//                 document.querySelector("#tbody_ds_warp tr:nth-child(" + row + ") [name='no_of_saree[]']").value = invoice.no_saree;
//                 document.querySelector("#tbody_ds_warp tr:nth-child(" + row + ") [name='one_section[]']").value = invoice.one_section;
//                 document.querySelector("#tbody_ds_warp tr:nth-child(" + row + ") [name='count[]']").value = invoice.s_count;
//                 document.querySelector("#tbody_ds_warp tr:nth-child(" + row + ") [name='section[]']").value = invoice.section;
//                 document.querySelector("#tbody_ds_warp tr:nth-child(" + row + ") [name='warp_wghts[]']").value = invoice.silk_wght;
//                 document.querySelector("#tbody_ds_warp tr:nth-child(" + row + ") [name='yard[]']").value = invoice.yard;
//                 document.querySelector("#tbody_ds_warp tr:nth-child(" + row + ") [name='warpsrl[]']").value = invoice.warp_no;

            
//             });
//         }
//     });
 
// }
$(document).ready(function() {
    $("#bill_no4").change(function() {
        var id = document.getElementById("pur_bill_id4").value;
            console.log(id);
        // console.log('ok');
     
        // Make AJAX request
        $.ajax({
            url: 'fetch/fetch_det_warptbl.php',
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
document.getElementById('tag_reports').style.display = 'none';

function populateTable(data) {
    // Clear existing table rows
    $("#warp_report_tbl tbody").empty();


    // Check if data is an array
    if (Array.isArray(data)) {
        // Loop through data and append rows to table
        data.forEach(function(item) {
            console.log("Item:", item);
            var row = "<tr class ='t_row'>" +
                "<td>" + item.warp_no + "</td>" +
                "<td>" + item.silk_wght + "</td>" +
                "<td>" + item.yard + "</td>" +
                "<td>" + item.no_saree + "</td>" +
                "<td>" + item.muzham + "</td>" +
                "<td>" + item.section + "</td>" +
                "<td>" + item.one_section + "</td>" +
                "<td>" + item.s_count + "</td>" +
                "</tr>";
            $("#warp_report_tbl tbody").append(row);
            
        });


    } else {
        console.log("Data is not an array:", data);
    }
}

// Get the selected element
var selectedElement = document.getElementById('tbl_type');

// Add event listener to the selected element
selectedElement.addEventListener('change', function() {
    // Check if the selected value is 'section4'
    if (selectedElement.value === 'section4') {
        // If yes, display the 'tag_reports' element
        document.getElementById('tag_reports').style.display = 'block';
    } else {
        // Otherwise, hide the 'tag_reports' element
        document.getElementById('tag_reports').style.display = 'none';
    }
});














   // //---------------------------------------------------------------------------------------
    // // Function to add a new row to the table
    


    // document.getElementById("no_of_marc").addEventListener('change', function() {
    //   var numrows_marc = document.getElementById("no_of_marc").value;
    //   // deleteRowsExceptLast();
    //   for (let i = 1; i < numrows_marc; i++) {
    //     addRow_marc(i);
    //   }
    // });
    // document.getElementById("reel_no").addEventListener('change', function() {
    //   var numrows_reel = document.getElementById("reel_no").value;
    //   deleteRowsExceptLast();
    //   for (let i = 1; i < numrows_reel; i++) {
    //     addRow_reel();
    //   }
    // });

    // /* ------------------------------------------------------------------------------------------------------------------------------  */

    // function addRow_marc(i) {
    //   // alert('ok')


    //   const tableBody = document.getElementById("t_one");
    //   const firstRow = tableBody.querySelector(".t_class");
    //   const newRow = firstRow.cloneNode(true);

    //   // Clear the input fields in the new row
    //   const addinginputs = newRow.querySelectorAll(".tbl_adding");
    //   addinginputs.forEach((input) => (input.value = ""));

    //   // Append the new row to the table body
    //   tableBody.appendChild(newRow);
    // }

    // function addRow_reel() {
    //   // alert('ok')
    //   const tableBody = document.getElementById("sub");
    //   const firstRow = tableBody.querySelector(".zari_row");
    //   const newRow = firstRow.cloneNode(true);

    //   // Clear the input fields in the new row
    //   const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
    //   addinginputs.forEach((input) => (input.value = ""));

    //   // Append the new row to the table body
    //   tableBody.appendChild(newRow);
    // }

  
 