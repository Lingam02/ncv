<?php
include "config.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $response = array('message' => 'Data upload and processing failed.');

    if (isset($_FILES['excelFile']['name'])) {
        $file_name = $_FILES['excelFile']['name'];
        $file_tmp = $_FILES['excelFile']['tmp_name'];

        if (move_uploaded_file($file_tmp, $file_name)) {
            // Process the Excel data
            // You can use a library like PHPExcel or PhpSpreadsheet to read and process the Excel file.

            // Example code to read a CSV file using PHP
            $data = array_map('str_getcsv', file($file_name));

            // Process the data as needed
            // For this example, we'll just display the data
            $response = array('message' => 'Data uploaded and processed successfully.', 'data' => $data);
        }
    }

    echo json_encode($response);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel Data</title>
 
    <style>
        body {
    font-family: Arial, sans-serif;
}

.container {
    margin: 20px;
}

form {
    margin: 20px 0;
}

button {
    padding: 10px 20px;
}

    </style>
</head>
<body>
    <div class="container">
        <form id="excelUploadForm" action="process_excel.php" method="post" enctype="multipart/form-data">
            <input type="file" name="excelFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
            <button type="submit">Upload Excel</button>
        </form>
    </div>
    <div id="result" class="container"></div>
    <script>
        document.getElementById('excelUploadForm').addEventListener('submit', function (event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('process_excel.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('result').textContent = data.message;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

    </script>
</body>
</html>
