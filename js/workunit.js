const input = document.getElementById('category');
  
input.addEventListener('input', function (event) {
   
    const selectedOption = event.target.value;
    const datalistOptions = document.getElementById('cat_options');
    const options = datalistOptions.getElementsByTagName('option');
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        const optionValue = option.value;

        if (optionValue === selectedOption) {
            var selectedAcid = option.getAttribute('data-acid'); // Assign value to selectedAcid

            document.getElementById("blockid").value = selectedAcid;

            break;
        }
    }
    console.log(selectedAcid);
    document.getElementById("blockid").value = selectedAcid;
    
    // Get a reference to the radio buttons
const radioButtons = document.getElementsByName("unittype");
console.log(radioButtons);
// Initialize a variable to store the selected value
let selectedValue;

// Loop through the radio buttons to find the selected one
for (const radioButton of radioButtons) {
    if (radioButton.checked) {
        selectedValue = radioButton.value;
        document.getElementById("loomval").value=selectedValue;
        break; // No need to continue looping once found
    }
}

// Check if a value was selected and display it
if (selectedValue) {
    console.log("Selected value:", selectedValue);
    
} else {
    document.getElementById("loomval").value="";
    console.log("No value selected");
    alert('"PLEASE SELECT ANY ONE OF THE UNIT TYPE!"');
}


});