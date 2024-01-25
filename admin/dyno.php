<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Example</title>
    <style>
        /* CSS styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .modal-content {
            background-color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            text-align: center;
            max-height: 80%;
            /* Set a maximum height for the modal content */
            overflow-y: auto;
            /* Enable vertical scrollbar if needed */
        }
        label{
            background-color: yellowgreen;
            border-radius: 50%;
            padding: 10px;
            color:#fff;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }

        .modal input[type="text"] {
            border: 1px solid #000;
            margin: 5px;
            height: 22px;
            width: 300px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <input type="text" id="inputField" placeholder="Enter a number">
    <div id="modal_bobin" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p class="heading_modal">Select Bobin</p>
            <div id="inputContainer"></div>
        </div>
    </div>
    <script>
        // JavaScript code
        const inputField = document.getElementById("inputField");
        const modal = document.getElementById("modal_bobin");
        const closeBtn = document.querySelector(".close");
        const inputContainer = document.getElementById("inputContainer");

        // Function to show the modal
        function showModal() {
            const numberOfInputs = parseInt(inputField.value);
            if (!isNaN(numberOfInputs) && numberOfInputs > 0) {
                inputContainer.innerHTML = "";
                for (let i = 1; i <= numberOfInputs; i++) {
                    const inputDiv = document.createElement("div");
                    inputDiv.classList.add("input-div");
                    inputDiv.innerHTML = `
                        <label class="sno" for="">${i}</label>
                        <input type="text" list="bobin_options" name="bobins[]" class='text-uppercase' placeholder="Type to select category...">
                        <datalist id="bobin_options">
                            <?php
                            $sql = "SELECT bobin_id,id FROM bobin ORDER BY bobin_id";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option class='text-uppercase' value='" . $row['bobin_id'] . "' data-acid='" . $row['id'] . "'></option>";
                                }
                            }
                            ?>
                        </datalist>
                    `;
                    inputContainer.appendChild(inputDiv);
                }
                modal.style.display = "block";
            }
        }

        // Function to hide the modal
        function hideModal() {
            modal.style.display = "none";
        }

        // Event listener for the input field blur
        inputField.addEventListener("blur", showModal);

        // Event listener to close the modal
        closeBtn.addEventListener("click", hideModal);

        // Close the modal if the user clicks outside of it
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                hideModal();
            }
        });
    </script>
</body>

</html>