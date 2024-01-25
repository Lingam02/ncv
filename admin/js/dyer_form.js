document.getElementById('update').style.display = 'none';
    document.getElementById('to_loc_div').style.display = 'none';
    document.getElementById('from_loc').style.display = 'block';

document.getElementById("txn_nam").addEventListener("change", function () {
  var selectedValue = this.value;
  if (selectedValue === "KORA_ISS") {
    document.getElementById('return_div').style.display = 'NONE';
    document.getElementById('to_loc_div').style.display = 'none';
    document.getElementById('from_loc').style.display = 'block';
    const from_loc = document.getElementById('fromloc');

    from_loc.required = true;
    
  }
  if (selectedValue === "SILK_RET") {
    document.getElementById('return_div').style.display = 'BLOCK';
    document.getElementById('issue_div').style.display = 'BLOCK';
    document.getElementById('to_loc_div').style.display = 'block';
    document.getElementById('from_loc').style.display = 'none';

    document.getElementById('modal').style.display = 'BLOCK';
    // Access the input element
    const issdateInput = document.getElementById('iss_date');
    const issTimeInput = document.getElementById('iss_time');
    const retdateInput = document.getElementById('ret_date');
    const retTimeInput = document.getElementById('ret_time');
    const to_loc = document.getElementById('to_loc');
    const from_loc = document.getElementById('fromloc');

    from_loc.required = false;
    // Set the input field as read-only

    to_loc.required = true;
    issdateInput.readOnly = true;
    issTimeInput.readOnly = true;
    retdateInput.readOnly = true;
    retTimeInput.readOnly = true;
    document.getElementById('color_div').style.visibility = 'visible'; // Show element with ID 'color_div'
   

  }

  if (selectedValue === "EDIT") {
    document.getElementById("return_div").style.display = "BLOCK";
    document.getElementById('issue_div').style.display = 'block';
    document.getElementById('modaledit').style.display = 'block';
    document.getElementById('save').style.display = 'none';
    document.getElementById('update').style.display = 'block';
    console.log(selectedValue);
    document.getElementById('color_div').style.visibility = 'visible'; // Show element with ID 'color_div'
    document.getElementById('to_loc_div').style.display = 'block';

  }

});

// function ret_col_div_show() {
//   var txn_nam_value = document.getElementById("txn_nam").value;
//   var col_nam_value = document.getElementById('col_nam').value;
// console.log(col_nam_value);
//   if (txn_nam_value === 'SILK_RET' && col_nam_value !== "") {
//       document.getElementById('color_div').style.visibility = 'visible';
//   } else {
//       document.getElementById('color_div').style.visibility = 'hidden';
//   }
// }

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



//============ script for date set default in input field visible starts===============
window.onload = function () {
  var currentDate = new Date();
  var day = currentDate.getDate();
  var month = currentDate.getMonth() + 1; // Month is zero-based
  var year = currentDate.getFullYear();

  // Format the date as YYYY-MM-DD (ISO format)
  var formattedDate = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');

  // Set the value attribute of the input field
  document.getElementById('iss_date').value = formattedDate;
  document.getElementById('ret_date').value = formattedDate;

};

//=============== script for date ends ================= 
// Get the current time
const currentTime = new Date();

// Format the time to HH:MM AM/PM (12-hour format)
let hours = currentTime.getHours();
const minutes = String(currentTime.getMinutes()).padStart(2, '0');
const ampm = hours >= 12 ? 'PM' : 'AM';
hours = hours % 12 || 12; // Convert hours to 12-hour format

// Set the formatted time as the value for the input field
const formattedTime = `${hours}:${minutes} ${ampm}`;
document.getElementById('iss_time').value = formattedTime;
document.getElementById('ret_time').value = formattedTime;




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
//ret dyer id get 
const ret_dyername = document.getElementById('ret_dyer_nam');

ret_dyername.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('twisterlist1');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-grpid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("ret_dyer_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("ret_dyer_id").value;

  console.log("dyer id-->", selectedAcid);
  console.log("ret_dyername value-->", ret_dyername.value);
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
//modal dyer id EDIT get 
const modal_dyer3 = document.getElementById('dyer_nam_modal3');

modal_dyer3.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('twisterlists3');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-grpid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("hidden_dyer_id3").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("hidden_dyer_id3").value;

  console.log("dyer id-->", selectedAcid);
  console.log("modal_dyer3 EDIT value-->", modal_dyer3.value);


});

//iss item id get 
const iss_item = document.getElementById('iss_itm_nam');

iss_item.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('item_list');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-grpid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("iss_itm_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("iss_itm_id").value;

  console.log("dyer id-->", selectedAcid);
  console.log("iss_item value-->", iss_item.value);
});

//ret item id get 
const ret_item = document.getElementById('ret_itm_nam');

ret_item.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('ret_item_list');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-grpid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("ret_itm_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("ret_itm_id").value;

  console.log("dyer id-->", selectedAcid);
  console.log("ret_item value-->", ret_item.value);
});

//ret col_id id get 
const col_nam = document.getElementById('col_nam');

col_nam.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('ret_col_list');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("ret_col_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("ret_col_id").value;

  console.log("col id-->", selectedAcid);
  console.log("col_nam value-->", col_nam.value);
});
//ret col_id id get 
const col_nam2 = document.getElementById('col_nam2');

col_nam2.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('iss_col_list');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("iss_col_id2").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("iss_col_id2").value;

  console.log("col id-->", selectedAcid);
  console.log("col_nam2 value-->", col_nam2.value);
});

//show wept id ....
function checkForSubstring() {
  const value = document.getElementById('ret_itm_nam').value;
  var searchWord = "SILK WEPT"; // Word to search for

  if (value.toUpperCase().includes(searchWord)) {
    document.getElementById('color_div').style.visibility = 'visible'; // Show element with ID 'color_div'
  } else {
    document.getElementById('color_div').style.visibility = 'hidden'; // Hide element with ID 'color_div'
  }

}
//show wept id ....
function checkForSubstring2() {
  const value2 = document.getElementById('iss_itm_nam').value;
  var searchWord2 = "KORA WEPT"; // Word to search for

  if (value2.toUpperCase().includes(searchWord2)) {
    document.getElementById('color_div2').style.visibility = 'visible'; // Show element with ID 'color_div'
  } else {
    document.getElementById('color_div2').style.visibility = 'hidden'; // Hide element with ID 'color_div'
  }

}



// dyer ajax geting id, displaying details
function fetch_dyer() {
  var id = document.getElementById("dyerissid").value;
  var id_nam = document.getElementById("dyer_nam_modal").value;
  console.log(id_nam);
  console.log('id-->', id);
  $.ajax({
    url: 'fetch_dyer_id.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (cust) {
      var myData = cust.dyer_nam;
      console.log(cust);
      document.getElementById("id").value = cust.id;
      document.getElementById("iss_date").value = cust.iss_date;
      document.getElementById("iss_time").value = cust.iss_time;
      document.getElementById("dyer_id").value = cust.dyer_id;
      document.getElementById("dyer_nam").value = cust.dyer_nam;
      document.getElementById("ret_dyer_id").value = cust.dyer_id;
      document.getElementById("ret_dyer_nam").value = cust.dyer_nam;
      document.getElementById("iss_itm_nam").value = cust.iss_itm_nam;
      document.getElementById("iss_desc").value = cust.iss_desc;
      document.getElementById("ret_desc").value = cust.iss_desc;
      document.getElementById("ret_col_id").value = cust.col_id;
      document.getElementById("col_nam").value = cust.col_nam;

      document.getElementById("iss_wght").value = cust.iss_wght;

    }
  });
  document.getElementById('modal').style.display = "none";
  // ret_col_div_show() ;
}


function fetch_dyer_edit() {

  var id = document.getElementById("hidden_dyer_id3").value;
  console.log(id);

  $.ajax({
    url: 'dyer_fetch_edit.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (cust) {
      console.log('ok edit');

      console.log(cust);
      document.getElementById("id").value = cust.id;
      document.getElementById("iss_date").value = cust.iss_date;
      document.getElementById("iss_time").value = cust.iss_time;
      document.getElementById("dyer_id").value = cust.dyer_id;
      document.getElementById("dyer_nam").value = cust.dyer_nam;
      document.getElementById("iss_itm_id").value = cust.iss_itm_id;
      document.getElementById("iss_itm_nam").value = cust.iss_itm_nam;
      document.getElementById("iss_desc").value = cust.iss_desc;
      document.getElementById("iss_wght").value = cust.iss_wght;

      document.getElementById("ret_date").value = cust.ret_date;
      document.getElementById("ret_time").value = cust.ret_time;
      document.getElementById("ret_dyer_id").value = cust.dyer_id;
      document.getElementById("ret_dyer_nam").value = cust.dyer_nam;
      document.getElementById("ret_itm_id").value = cust.ret_itm_id;
      document.getElementById("ret_itm_nam").value = cust.ret_itm_nam;
      document.getElementById("ret_desc").value = cust.ret_desc;
      document.getElementById("ret_wght").value = cust.ret_wght;
      document.getElementById("waste_wght").value = cust.waste_wght;
      document.getElementById("ret_col_id").value = cust.col_id;
      document.getElementById("col_nam").value = cust.col_nam;
      document.getElementById("fromloc").value = cust.loc_nam;
      document.getElementById("fromloc_id").value = cust.loc_id;
      document.getElementById("to_loc").value = cust.to_loc_nam;
      document.getElementById("to_loc_id").value = cust.to_loc_id;
    }
  });
  document.getElementById('modaledit').style.display = "none";

}

document.getElementById('ret_wght').addEventListener('input', function () {
  calculate_waste_wght();
});
document.getElementById('waste_wght').addEventListener('input', function () {
  calculate_waste_wght();

});
document.getElementById('iss_wght').addEventListener('input', function () {
  calculate_waste_wght();

});

function calculate_waste_wght() {
  // document.getElementById('iss_wght')

  document.getElementById('waste_wght').value = document.getElementById('iss_wght').value - document.getElementById('ret_wght').value;

}