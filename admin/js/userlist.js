
// Your JavaScript code for searching users
function searchUsers() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchName");
    filter = input.value.toUpperCase();
    table = document.getElementById("userTable1");
    tr = table.getElementsByTagName("tr");

    var serialNumber = 1; // Reset serial number counter when filtering

    for (i = 0; i < tr.length; i++) {
        var found = false;
        var tdName = tr[i].getElementsByTagName("td")[2]; // Index for name column
        var tdUsername = tr[i].getElementsByTagName("td")[3]; // Index for username column

        if (tdName && tdUsername) {
            txtValueName = tdName.textContent || tdName.innerText;
            txtValueUsername = tdUsername.textContent || tdUsername.innerText;

            if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValueUsername.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                found = true;

                // Update the serial number for displayed rows
                var tdSerialNumber = tr[i].getElementsByTagName("td")[0]; // Index for serial number column
                if (tdSerialNumber) {
                    tdSerialNumber.innerText = serialNumber++;
                }
            }
        }

        if (!found) {
            tr[i].style.display = "none";
        }
    }
}

// Your JavaScript code for searching users
function filterUsersByType() {
    var select, table, tr, td, i, userType;
    select = document.getElementById("usertype");
    userType = select.value.toUpperCase();
    table = document.getElementById("userTable2");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        var found = false;
        var tdUserType = tr[i].getElementsByTagName("td")[4]; // Index for user type column

        if (tdUserType) {
            var txtValueUserType = tdUserType.textContent || tdUserType.innerText;

            if (userType === "SELECT" || txtValueUserType.toUpperCase() === userType) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


function printTableContainer() {
    var content = document.querySelector('.table-container').innerHTML;
    var printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print</title></head><body>' + content + '</body></html>');
    printWindow.document.close();
    printWindow.print();

     // Close the print window/tab after printing
     printWindow.setTimeout(function () {
        printWindow.close();
    }, 1000); // Adjust the delay if needed (in milliseconds)
}
