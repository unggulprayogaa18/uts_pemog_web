<?php
header('Content-Type: application/json');

include 'koneksi.php';

try {
 

    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
    $ciri_ciri = isset($_POST['ciri_ciri']) ? $_POST['ciri_ciri'] : '';
    $status_pasien = isset($_POST['status_pasien']) ? $_POST['status_pasien'] : '';
    $id_kamar = isset($_POST['id_kamar']) ? $_POST['id_kamar'] : '';

    $stmt = $koneksi->prepare("INSERT INTO pasien (nama, jenis_kelamin, ciri_ciri, status_pasien, id_kamar) VALUES (:nama, :jenis_kelamin, :ciri_ciri, :status_pasien, :id_kamar)");

    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
    $stmt->bindParam(':ciri_ciri', $ciri_ciri);
    $stmt->bindParam(':status_pasien', $status_pasien);
    $stmt->bindParam(':id_kamar', $id_kamar);

    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Data Pasien berhasil disimpan');
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal menyimpan data: ' . $stmt->errorInfo()[2]);
    }

    $stmt->closeCursor();
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

echo json_encode($response);
?>
