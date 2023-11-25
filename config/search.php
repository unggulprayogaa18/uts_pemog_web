<?php
header('Content-Type: application/json');

// Include PDO connection setup from koneksi.php
include 'koneksi.php';

try {
    // Gunakan prepared statement untuk mencegah SQL injection
    $keyword = '%' . $_GET['keyword'] . '%';

    $query = "SELECT * FROM pasien WHERE 
              nama LIKE :keyword OR
              jenis_kelamin LIKE :keyword OR
              ciri_ciri LIKE :keyword OR
              status_pasien LIKE :keyword OR
              id_kamar LIKE :keyword";
    $stmt = $koneksi->prepare($query);
    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $stmt->execute();

    // Set fetch mode to fetch results as an associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $data_pasien = array();
    while ($row = $stmt->fetch()) {
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
} catch (PDOException $e) {
    // Handle PDO errors
    $response = array('status' => 'error', 'message' => 'Gagal melakukan pencarian: ' . $e->getMessage());
} finally {
    // Always close the connection, regardless of success or failure
    $koneksi = null;
}

echo json_encode($response);
?>
