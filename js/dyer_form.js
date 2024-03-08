
var closeModal = document.getElementsByClassName("close")[0];

closeModal.addEventListener("click", function () {
  modal.style.display = "none";
});
var closeModal2 = document.getElementById("close2");

closeModal2.addEventListener("click", function () {
  document.getElementById('modaledit').style.display = "none";

});
document.getElementById('form_1').addEventListener('keypress', function (e) {
  // Check if the Enter key (key code 13) is pressed
  if (e.key === 'Enter' || e.keyCode === 13) {
    e.preventDefault(); // Prevent default form submission
    // You can add additional custom functionality here if needed
    // For example, trigger a function or perform an action
  }
});


function handleEnterKey(event, nextElementId) {
  if (event.key === 'Enter') {
    event.preventDefault();
    const nextElement = document.getElementById(nextElementId);
    nextElement.focus();
  }
}


//fromloc id get 
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
      //console.log('ok',selectedAcid);

      document.getElementById("fromloc_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("fromloc_id").value;

  console.log("fromloc id-->", selectedAcid);
  console.log("fromloc value-->", fromloc.value);
});

//to_loc id get 
const to_loc_name = document.getElementById('to_loc');

to_loc_name.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('to_locs');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("to_loc_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("to_loc_id").value;

  console.log("to_loc_id-->", id);
  console.log("to_loc_name value-->",to_loc_name.value);
});
//get warp_tag_no id
const warp_tag_no = document.getElementById('warp_tag_no');

warp_tag_no.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('warp_tagids');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("warp_tagid").value = selectedAcid;

      break;
    }
  }
  
  var id = document.getElementById("warp_tagid").value;
  get_sep_retdetails();
  
  console.log("warp_tagid-->", id);
  console.log("warp_tag_no value-->",warp_tag_no.value);
});

//dyer id get 
const dyername = document.getElementById('dyer_nam');

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

      document.getElementById("dyer_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("dyer_id").value;

  console.log("dyer id-->", selectedAcid);
  console.log("dyername value-->", dyername.value);
});

//modal dyer id get 
const modal_dyer = document.getElementById('dyer_nam_modal');

modal_dyer.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('twisterlists');

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
  document.getElementById("dyerissid").value = selectedAcid;
  console.log("dyer id-->", selectedAcid);
  console.log("modal_dyer_RETURN value-->", modal_dyer.value);


});


function get_sep_retdetails() {
var id = document.getElementById('warp_tagid').value;  
$.ajax({
  url: 'fetch/warp_tag_todyer.php',
  method: 'POST',
  data: { id: id },
  dataType: 'json',
  success: function (work) {
    console.log('work',work);
  

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


       document.getElementById("hidden_saree_no").value = invoice.no_saree;
       document.getElementById("hidden_loom_id").value = invoice.loom_id;
    
      //  document.getElementById("booking_id").value = invoice.new_warp_no;
      //  const totalWght = work.reduce((sum, invoice) => sum + parseFloat(invoice.wght), 0);
      //  document.getElementById("iss_wght").value = invoice.totalWght;
      
      // Populate the last row with your data
      lastRow.querySelector("[name='warp_no2[]']").value = invoice.warp_no;
      lastRow.querySelector("[name='border_nam2[]']").value = invoice.typ;
      // 
      lastRow.querySelector("[name='yard2[]']").value = invoice.yard;
      lastRow.querySelector("[name='no_saree2[]']").value = invoice.no_saree;
      lastRow.querySelector("[name='muzham2[]']").value = invoice.muzham;
      lastRow.querySelector("[name='one_section2[]']").value = invoice.one_section;
      lastRow.querySelector("[name='s_count2[]']").value = invoice.s_count;
      //
      lastRow.querySelector("[name='ply2[]']").value = invoice.ply;
      lastRow.querySelector("[name='section2[]']").value = invoice.iss_section;
      lastRow.querySelector("[name='wght2[]']").value = invoice.iss_wght;
      lastRow.querySelector("[name='section3[]']").value = invoice.section;
      lastRow.querySelector("[name='wght3[]']").value = invoice.wght;
   
      // 
      // Calculate total weight
let totalWght = work.reduce((sum, invoice) => sum + parseFloat(invoice.wght), 0);

// Set the value of the element with id "iss_wght" to the total weight
document.getElementById("iss_wght").value = totalWght;


      lastRow.querySelector("[name='section4[]']").value = invoice.bal_section;
      lastRow.querySelector("[name='wght4[]']").value = invoice.bal_wght;
// Assuming 'work' is an array of invoice objects

      // document.getElementById("entry_table2").style.Display = 'block';
      if (index < maxrec0 - 1) {
        addRow();
      }      
      //-------------------------
    });  
    show_coldiv();
//-------------------------------------------------------------uuuu---  
  }      
});
}

function addRow() {
  const tableBody = document.getElementById("sep_iss_body2");
  const firstRow = tableBody.querySelector(".trow2");
  const newRow = firstRow.cloneNode(true);
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));
  tableBody.appendChild(newRow);
}
function show_coldiv() {
  // Reset any previously added color inputs
  var colorInputs = document.querySelectorAll('.color-input');
  colorInputs.forEach(function(input) {
      input.parentNode.removeChild(input);
  });

  if (document.getElementById('hidden_saree_no').value > 0) {
      document.getElementById('col_div').style.display = 'block';
      document.getElementById('col_divopen').setAttribute('checked', 'checked');

      var numrows = document.getElementById('hidden_saree_no').value;
      for (let i = 1; i < numrows; i++) {
          addcolor_input();
      }
  } else {
      document.getElementById('col_div').style.display = 'none';
      document.getElementById('col_divopen').removeAttribute('checked');
  }
}

function addcolor_input() {
  const tableBody = document.getElementById("tbl_body_col");
  const firstRow = tableBody.querySelector("tr");
  const newRow = firstRow.cloneNode(true);

  // Clear the input fields in the new row
  const addinginputs = newRow.querySelectorAll("input[type='text'], input[type='number']");
  addinginputs.forEach((input) => (input.value = ""));

  // Add class to the new inputs
  addinginputs.forEach((input) => input.classList.add("color-input"));

  // Append the new row to the table body
  tableBody.appendChild(newRow);
}



function toggleDiv() {
  var checkbox = document.getElementById("col_divopen");
  var div = document.getElementById("col_div");
  
  if (checkbox.checked) {
      div.style.display = "block";
  } else {
      div.style.display = "none";
  }
}