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
