<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "unggulprayoga";

try {
    $koneksi = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
