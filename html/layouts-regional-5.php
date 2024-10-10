<!DOCTYPE html>
<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================
* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)
=========================================================
 -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Upload Excel Data | Sneat Admin Template</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    
    <!-- Script for handling Excel uploads -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f7fa; /* Background yang lebih terang dan lembut */
        }

        h1 {
            color: #146db0; /* Warna biru Bootstrap */
            font-weight: 700;
            text-align: center; /* Menempatkan teks di tengah */
            font-size: 2.5rem; /* Membuat teks lebih besar */
            margin-bottom: 30px; /* Memberi jarak bawah */
            letter-spacing: 2px; /* Memberi jarak antar huruf */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan halus untuk efek cantik */
        }

        /* Styles for the upload section and table */
        .upload-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .upload-section input[type="file"] {
            flex: 1;
            margin-right: 10px;
        }

        .upload-section button {
            flex-shrink: 0;
        }

        table {
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #007bff; /* Warna biru Bootstrap */
            color: black; /* Warna teks putih */
            text-align: center; /* Teks rata tengah */
            padding: 15px; /* Padding lebih besar */
            position: sticky; /* Sticky header */
            top: 0;
            z-index: 1;
            border-bottom: 3px solid #0056b3; /* Garis bawah yang lebih gelap untuk kontras */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan halus untuk efek 3D */
            text-transform: uppercase; /* Huruf kapital untuk header */
            letter-spacing: 1px; /* Spasi antar huruf */
            font-weight: 600; /* Menegaskan ketebalan teks */
            transition: background-color 0.3s ease; /* Animasi transisi halus untuk background */
        }

        th:hover {
            background-color: #0056b3; /* Warna berubah saat hover */
        }

        td {
            text-align: center; /* Teks rata tengah */
            padding: 12px; /* Sedikit lebih besar untuk ruang lebih luas */
            border: 1px solid #dee2e6; /* Border halus untuk pemisahan data */
            background-color: #f8f9fa; /* Warna background yang lembut */
            font-size: 14px; /* Ukuran font yang pas */
            color: #495057; /* Warna teks yang lembut dan mudah dibaca */
            transition: background-color 0.3s ease, transform 0.3s ease; /* Transisi halus untuk interaksi hover */
        }

        td:hover {
            background-color: #e2e6ea; /* Warna latar lebih gelap saat di-hover */
            transform: scale(1.02); /* Sedikit memperbesar ukuran untuk efek hover */
            cursor: pointer; /* Menambahkan kursor pointer saat di-hover */
        }

        tr:nth-child(even) td {
            background-color: #e9ecef; /* Warna background berbeda untuk baris genap */
        }

        tr:hover td {
            background-color: #d1ecf1; /* Warna background biru muda saat baris di-hover */
        }

        .btn {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
  </head>
  
  <body>
    <div class="container">
      <button id="backButton" class="btn btn-secondary" style="margin-top: 20px;">Back to Home</button>
      <h1 class="mb-4">Upload and Display Excel Data</h1>

      <div class="upload-section">
          <input type="file" id="uploadExcel" accept=".xlsx, .xls" class="form-control" />
          <button id="uploadButton" class="btn btn-primary">Upload</button>
      </div>

      <table id="excelTable" class="table table-bordered table-hover">
          <!-- Excel data will be displayed here -->
      </table>

      <button id="saveButton" class="btn btn-success">Save Data</button>
    </div>

    <script>
        // Handle the Back button click
        document.getElementById('backButton').addEventListener('click', function () {
            window.location.href = '../html/index.html'; // Redirects to index.html
        });
    document.getElementById('uploadButton').addEventListener('click', function () {
        var fileInput = document.getElementById('uploadExcel');
        if (fileInput.files.length === 0) {
            alert("Please choose a file to upload.");
            return;
        }

        var file = fileInput.files[0];
        var reader = new FileReader();
        
        reader.onload = function (e) {
            var data = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, { type: 'array' });
            
            var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            
            var excelData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

            var table = document.getElementById('excelTable');
            table.innerHTML = ""; 
            
            excelData.forEach(function (row, rowIndex) {
                var rowElement = table.insertRow(-1);
                
                if (rowIndex === 0) {
                    row.forEach(function (cell) {
                        var headerCell = document.createElement("th");
                        headerCell.textContent = cell;
                        rowElement.appendChild(headerCell);
                    });
                } else {
                    row.forEach(function (cell, cellIndex) {
                        var cellElement = rowElement.insertCell(-1);

                        if (cellIndex === 4) { // Kolom tanggal dan waktu
                            var cellValue = cell;
                            var date;

                            if (typeof cellValue === 'number') {
                                // Pisahkan bagian tanggal dan waktu dari serial number
                                var serialDate = Math.floor(cellValue); // bagian tanggal
                                var serialTime = cellValue - serialDate; // bagian waktu (desimal)
                                
                                // Konversi serialDate menjadi objek Date
                                date = XLSX.SSF.parse_date_code(serialDate);
                                var parsedDate = new Date(date.y, date.m - 1, date.d);

                                // Konversi serialTime menjadi jam, menit, dan detik
                                var totalSeconds = Math.round(serialTime * 24 * 3600);
                                var hours = Math.floor(totalSeconds / 3600);
                                var minutes = Math.floor((totalSeconds % 3600) / 60);
                                var seconds = totalSeconds % 60;

                                // Gabungkan tanggal dan waktu
                                parsedDate.setHours(hours);
                                parsedDate.setMinutes(minutes);
                                parsedDate.setSeconds(seconds);

                                // Format output tanggal dan waktu
                                var formattedDate = 
                                    parsedDate.getFullYear() + '/' + 
                                    ('0' + (parsedDate.getMonth() + 1)).slice(-2) + '/' + 
                                    ('0' + parsedDate.getDate()).slice(-2) + ' ' + 
                                    ('0' + parsedDate.getHours()).slice(-2) + ':' + 
                                    ('0' + parsedDate.getMinutes()).slice(-2) + ':' + 
                                    ('0' + parsedDate.getSeconds()).slice(-2);
                                
                                cellElement.textContent = formattedDate;
                            } else if (typeof cellValue === 'string') {
                                date = new Date(cellValue);
                                if (!isNaN(date.getTime())) {
                                    var formattedDateString = 
                                        date.getFullYear() + '/' + 
                                        ('0' + (date.getMonth() + 1)).slice(-2) + '/' + 
                                        ('0' + date.getDate()).slice(-2) + ' ' + 
                                        ('0' + date.getHours()).slice(-2) + ':' + 
                                        ('0' + date.getMinutes()).slice(-2) + ':' + 
                                        ('0' + date.getSeconds()).slice(-2);
                                    cellElement.textContent = formattedDateString;
                                } else {
                                    cellElement.textContent = "Invalid date";
                                }
                            } else {
                                cellElement.textContent = "Invalid data";
                            }
                        } else {
                            cellElement.textContent = cell;
                        }
                    });
                }
            });
        };

        reader.readAsArrayBuffer(file);
    });

    document.getElementById('saveButton').addEventListener('click', function () {
        var table = document.getElementById('excelTable');
        var excelData = [];

        for (var i = 1; i < table.rows.length; i++) { 
            var row = table.rows[i];
            var rowData = [];

            for (var j = 0; j < row.cells.length; j++) {
                var cellContent = row.cells[j].textContent;

                if (j === 4) { 
                    var date = new Date(cellContent);
                    if (!isNaN(date.getTime())) {
                        var formattedDate = date.getFullYear() + '-' + 
                                            ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                                            ('0' + date.getDate()).slice(-2) + ' ' + 
                                            ('0' + date.getHours()).slice(-2) + ':' + 
                                            ('0' + date.getMinutes()).slice(-2) + ':' + 
                                            ('0' + date.getSeconds()).slice(-2);
                        rowData.push(formattedDate);
                    } else {
                        rowData.push('Invalid Date');
                    }
                } else {
                    rowData.push(cellContent);
                }
            }
            excelData.push(rowData);
        }

        fetch('save_data5.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(excelData),
        })
        .then(response => response.text())
        .then(result => {
            console.log(result);
            alert("Data saved successfully!");
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    </script>
  </body>
</html>
