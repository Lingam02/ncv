
function getbox_id(rid){
  const rrow = rid.closest("tr");
  const rowname = rrow.querySelector("[name='boxes[]']");
  const rowid = rrow.querySelector("[name='hidden_box_id[]']");
  const datalistOptions = document.getElementById('box_options');
  
  const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === rowname.value) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

           rowid.value = selectedAcid;
          // console.log(selectedAcid);
            break;
        }
    }
    console.log('value',rowname.value);
    console.log('value id',selectedAcid);
}

function getitemcolor(rid){
  const rrow = rid.closest("tr");
  const rowname = rrow.querySelector("[name='colornames[]']");
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
          // console.log( rowid.value);
            break;
        }
    }
    console.log('value',rowname.value);
    console.log('value id',selectedAcid);
}

      // Get the necessary elements
function getbobin_id(rid){
  const rrow = rid.closest("tr");
  const rowname = rrow.querySelector("[name='bobins[]']");
  const rowid = rrow.querySelector("[name='hidden_bobin_id[]']");
  const reff_id = rrow.querySelector("[name='hidden_reff_id[]']");
  const datalistOptions = document.getElementById('bobin_options');
  
  const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === rowname.value) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid
            var selectedAcid2 = option.getAttribute('data-acid2'); // Assign value to selectedAcid

           rowid.value = selectedAcid;
           reff_id.value = selectedAcid2;
          // console.log(selectedAcid);
            break;
        }
    }
    console.log('value',rowname.value);
    console.log('value id',selectedAcid);
    console.log('value reff_id',selectedAcid2);
    bobin_det(rid);
}
function bobin_det(rid) {
  const rrow = rid.closest("tr");
  const rowid = rrow.querySelector("[name='hidden_bobin_id[]']").value;
  var id = rowid;
  console.log('idididi',id);

  // Make AJAX request
  $.ajax({
    url: 'fetch/get_bobin_id_det.php',
    method: "POST",
    data: { id: id },
    success: function(data) {
      try {
        // Assuming data is an array with one object
        console.log("Received data:", data);
        if (data.length > 0) { // Check if data array is not empty
          console.log("Received col_nam:", data[0].col_nam); // Access col_nam property of the first object
    
          // Set the value of the element named 'color_display[]'
          rrow.querySelector("[name='color_display[]']").value = data[0].nam;
        } else {
          console.error("No data found");
        }
      } catch (error) {
        console.error("Error parsing or processing data:", error);
      }
    },
    
    
    
    error: function(xhr, status, error) {
      console.error("AJAX request failed:", status, error);
    }
  });
}





      // Get the necessary elements
      var selectElement = document.getElementById('workname');
      var hiddenInput = document.getElementById('selectedName');
      // Add an event listener to the select element
      selectElement.addEventListener('change', function() {
        // Get the selected option
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        
        // Get the ID and Name of the selected option
        var selectedId = selectedOption.value;
        var selectedName = selectedOption.text;
        
        // Update the hidden input field with the selected name
        hiddenInput.value = selectedName;
        console.log(selectedId);
      });
  
      // Get the necessary elements
      var selectUnit = document.getElementById('unitname');
      var hiddenUnit = document.getElementById('selectedunit');
      // Add an event listener to the select element
      selectUnit.addEventListener('change', function() {
        var selectedunits = selectUnit.options[selectUnit.selectedIndex].text;
        console.log(selectedunits);
        document.getElementById('selectedunit').value=selectedunits;
      });
  
    
      var fromloc = document.getElementById('fromloc');
      var hiddenloc = document.getElementById('selectedloc');
      fromloc.addEventListener('change', function() {
        var selectedloc = fromloc.options[fromloc.selectedIndex].text;
        console.log(selectedloc);
        document.getElementById('selectedloc').value=selectedloc;
      });
    
    // Function to handle Enter key for dynamically added inputs
document.getElementById('inputContainer').addEventListener('keydown', function(event) {
  if (event.key === 'Enter') {
    event.preventDefault();

    const inputs = document.querySelectorAll('#inputContainer input[type="text"]');
    const currentIndex = Array.from(inputs).indexOf(event.target);

    if (currentIndex !== -1 && currentIndex < inputs.length - 1) {
      inputs[currentIndex + 1].focus();
      inputs[currentIndex + 1].select();
    }
  }
});