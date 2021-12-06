<?php
// Set header type konten.
header("Content-Type: application/json; charset=UTF-8");

// Deklarasi variable untuk koneksi ke database.
$host     = "localhost";    // Server database
$username = "root";         // Username database
$password = "";             // Password database
$database = "sppdb"; // Nama database

// Koneksi ke database.
$conn = new mysqli($host, $username, $password, $database);

// Deklarasi variable keyword buah.
$nama = $_GET["query"];

// Query ke database.
$query  = $conn->query("SELECT * FROM penduduk WHERE nik LIKE '%$nama%' ORDER BY nik DESC");
$result = $query->fetch_all(MYSQLI_ASSOC);

// Format bentuk data untuk autocomplete.
foreach ($result as $data) {
    $output['suggestions'][] = [
        'value' => $data['nik'],
        'nik'  => $data['nik']
    ];
}

if (!empty($output)) {
    // Encode ke format JSON.
    echo json_encode($output);
}
