<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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


        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #eaf5ff;
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
    <h1 class="mb-4">Upload and Display Excel Data</h1>

    <div class="upload-section">
        <input type="file" id="uploadExcel" accept=".xlsx, .xls" class="form-control" />
        <button id="uploadButton" class="btn btn-primary">Upload</button>
    </div>

    <table id="excelTable" class="table table-bordered table-hover">
        <!-- Excel data will be displayed here -->
    </table>

    <button id="saveButton" class="btn btn-success">Save Data</button>

    <script>
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
            
            // Mengambil sheet pertama
            var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            
            // Mengonversi sheet menjadi JSON
            var excelData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

            // Menampilkan data ke tabel
            var table = document.getElementById('excelTable');
            table.innerHTML = ""; // Kosongkan tabel sebelum menambahkan data baru
            
            excelData.forEach(function (row, rowIndex) {
                var rowElement = table.insertRow(-1);
                
                // Jika baris pertama, buat sebagai header (th)
                if (rowIndex === 0) {
                    row.forEach(function (cell) {
                        var headerCell = document.createElement("th");
                        headerCell.textContent = cell;
                        rowElement.appendChild(headerCell);
                    });
                } else {
                    // Baris berikutnya buat sebagai data (td)
                    row.forEach(function (cell, cellIndex) {
                        var cellElement = rowElement.insertCell(-1);

                        // Format tanggal dan waktu untuk kolom ke-4
                        if (cellIndex === 4) { // Kolom tanggal dan waktu
                            var cellValue = cell; // Nilai dari Excel
                            var date;

                            // Jika cellValue berupa angka (serial Excel date)
                            if (typeof cellValue === 'number') {
                                date = XLSX.SSF.parse_date_code(cellValue);
                                date = new Date(date.y, date.m - 1, date.d, date.h || 0, date.M || 0, date.s || 0);
                            } else if (typeof cellValue === 'string') {
                                // Cek jika format sudah berupa string
                                date = new Date(cellValue);
                            } else {
                                date = cellValue instanceof Date ? cellValue : null;
                            }

                            if (date) {
                                // Format waktu seperti "MM/DD/YYYY HH:MM:SS AM/PM"
                                var formattedDate = 
                                    (date.getMonth() + 1) + "/" + 
                                    date.getDate() + "/" + 
                                    date.getFullYear() + " " + 
                                    date.toLocaleTimeString('en-US'); // Format AM/PM
                                
                                cellElement.textContent = formattedDate;
                            } else {
                                cellElement.textContent = "Invalid date";
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

        // Mengambil data dari tabel
        for (var i = 1; i < table.rows.length; i++) { // Mulai dari 1 untuk melewati header
            var row = table.rows[i];
            var rowData = [];

            for (var j = 0; j < row.cells.length; j++) {
                var cellContent = row.cells[j].textContent;

                // Format tanggal untuk kolom ke-4 sesuai dengan format MySQL DATETIME
                if (j === 4) { // Assuming column 4 is the date column
                    var date = new Date(cellContent); // Parsing date
                    if (!isNaN(date.getTime())) { // Check if date is valid
                        // Format date as YYYY-MM-DD HH:MM:SS
                        var formattedDate = date.getFullYear() + '-' + 
                                            ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                                            ('0' + date.getDate()).slice(-2) + ' ' + 
                                            ('0' + date.getHours()).slice(-2) + ':' + 
                                            ('0' + date.getMinutes()).slice(-2) + ':' + 
                                            ('0' + date.getSeconds()).slice(-2);
                        rowData.push(formattedDate);
                    } else {
                        rowData.push('Invalid Date'); // Handle invalid date case
                    }
                } else {
                    rowData.push(cellContent);
                }
            }
            excelData.push(rowData);
        }

        // Kirim data ke backend menggunakan fetch
        fetch('save_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(excelData),
        })
        .then(response => response.text())
        .then(data => {
            alert("Data saved successfully!");
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });

    </script>
</body>
</html>
