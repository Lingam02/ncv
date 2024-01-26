
//---------------------------------------------------------------------------------------

function openSection() {
  var selectedValue = document.getElementById('tabSelector').value;
  var i, contentSections;
  // Hide all content sections
  contentSections = document.getElementsByClassName('content-section');
  for (i = 0; i < contentSections.length; i++) {
    contentSections[i].style.display = 'none';
  }
  // Show the selected content section
  document.getElementById(selectedValue).style.display = 'block';
}

//---------------------------------------------------------------------------------------

const bill_no_input = document.getElementById('bill_no');

bill_no_input.addEventListener('change', function (event) {
  const selectedOption = event.target.value;
  const datalistOptions = document.getElementById('pur_bill');

  const options = datalistOptions.getElementsByTagName('option');
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const optionValue = option.value;

    if (optionValue === selectedOption) {
      var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
      //console.log('ok',selectedAcid);

      document.getElementById("pur_bill_id").value = selectedAcid;

      break;
    }
  }
  var id = document.getElementById("pur_bill_id").value;

  console.log("pur_bill_id-->", selectedAcid);
  console.log("bill_no_input value-->", bill_no_input.value);
});


// function fetch_bill_id() {
//     var id = document.getElementById("pur_bill_id").value;
//     //console.log(id);

//     $.ajax({
//       url: 'fetch_inward.php',
//       method: 'POST',
//       data: { id: id },
//       dataType: 'json',
//       success: function (work) {
//         //  console.log(myData);
//          console.log(work.id)

//         // Update your HTML elements with fetched data
//         // document.getElementById("unit").value = work.dept;
//         // document.getElementById("itemopb").value = work.opb_wght;
//         // document.getElementById("bobin_qty").value = work.no_bobins;


//       }
//     });
//   }

function fetch_bill_id() {
  var id = document.getElementById("pur_bill_id").value;

  $.ajax({
    url: 'fetch_inward.php',
    method: 'POST',
    data: { id: id },
    dataType: 'json',
    success: function (work) {
      console.log(work);

      // Check if data is not empty
      if (Object.keys(work).length > 0) {
        // Update your HTML elements with fetched data
        // Example:
        document.getElementById("remarks").value = work.remarks;
        // document.getElementById("itemopb").value = work.opb_wght;
        // document.getElementById("bobin_qty").value = work.no_bobins;
      } else {
        console.log("No data found for the provided ID");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error fetching data:", error);
    }
  });
}


//---------------------
function multiply_section() {
  var sections = document.getElementsByName('section[]');
  var one_sections = document.getElementsByName('one_section[]');
  var counts = document.getElementsByName('count[]');

  for (var i = 0; i < sections.length; i++) {
      var section_value = parseFloat(sections[i].value);
      var one_section_value = parseFloat(one_sections[i].value);

      if (!isNaN(section_value) && !isNaN(one_section_value)) {
          counts[i].value = section_value * one_section_value;
      } else {
         
      }
  }
}
//---------------------
function clearpage(){
  location.reload();  
}