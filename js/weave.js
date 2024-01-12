  
  // Get the necessary elements
const box = document.getElementById('box');

box.addEventListener('change', function (event) {
    const selectedOption = event.target.value;
    const datalistOptions = document.getElementById('box_nos');
    
    const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

            document.getElementById("hidden_box_id").value = selectedAcid;

            break;
        }
    }
    var id = document.getElementById("hidden_box_id").value;

    console.log("box id-->",selectedAcid);
    console.log("box value-->",box.value);
});
  
  
  
  
  
  // Get the necessary elements
  var selectElement = document.getElementById('wevname');
  var hiddenInput = document.getElementById('selectedName');
  // Add an event listener to the select element
  selectElement.addEventListener('change', function() {
    // Get the selected option
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    
    // Get the ID and Name of the selected option
    var selectedId = selectedOption.value;
    var selectedName = selectedOption.text;
    console.log(selectedId);
    console.log(selectedName);
    // Update the hidden input field with the selected name
    hiddenInput.value = selectedName;
  });

  // Get the necessary elements
  var selectUnit = document.getElementById('loomnam');
  var hiddenUnit = document.getElementById('selectedUnit');
  // Add an event listener to the select element
  selectUnit.addEventListener('change', function() {
    var selectedunits = selectUnit.options[selectUnit.selectedIndex].text;
    console.log(selectedunits);
    document.getElementById('selectedunit').value=selectedunits;
  });

  var selectItem = document.getElementById('silk_nam');
  var hiddenItem = document.getElementById('selecteditem');
  selectItem.addEventListener('change', function() {
    var selectedItems = selectItem.options[selectItem.selectedIndex].text;
    console.log(selectedItems);
    document.getElementById('selecteditem').value=selectedItems;
  });

  var selectColor = document.getElementById('col_nam');
  var hiddenColor = document.getElementById('selectedcolor');
  selectColor.addEventListener('change', function() {
    var selectedColors = selectColor.options[selectColor.selectedIndex].text;
    console.log(selectedColors);
    document.getElementById('selectedcolor').value=selectedColors;
  });

  var selectzari = document.getElementById('zari_nam');
  var hiddenzari= document.getElementById('selectedzari');
  selectzari.addEventListener('change', function() {
    var selectedzari= selectzari.options[selectzari.selectedIndex].text;
    console.log(selectedzari);
    document.getElementById('selectedzari').value=selectedzari;
  });

  
  var fromloc = document.getElementById('fromloc');
  var hiddenColor = document.getElementById('selectedloc');
  fromloc.addEventListener('change', function() {
    var selectedloc = fromloc.options[fromloc.selectedIndex].text;
    console.log(selectedloc);
    document.getElementById('selectedloc').value=selectedloc;
  });
