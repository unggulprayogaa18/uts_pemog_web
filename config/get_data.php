<?php
header('Content-Type: application/json');

include 'koneksi.php';

try {
    // Continue with your PDO queries here
    $stmt = $koneksi->query("SELECT * FROM pasien");

    if ($stmt) {
        $data_pasien = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data_pasien[] = array(
                'idpasien' => $row['idpasien'],
                'nama' => $row['nama'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'ciri_ciri' => $row['ciri_ciri'],
                'status_pasien' => $row['status_pasien'],
                'id_kamar' => $row['id_kamar']
            );
        }
        $response = array('status' => 'success', 'data_pasien' => $data_pasien);
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal mengambil data');
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

// No need to close the connection here because it is already included in koneksi.php

echo json_encode($response);
?>
