<?php
header('Content-Type: application/json');

// Include PDO connection setup from koneksi.php
include 'koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idpasien = $_POST['idpasien'];

        $stmt = $koneksi->prepare("SELECT * FROM pasien WHERE idpasien = :idpasien");
        $stmt->bindParam(':idpasien', $idpasien, PDO::PARAM_INT);
        $stmt->execute();
        
        // Set fetch mode to fetch results as an associative array
        $row = $stmt->fetch();
        

        if ($row) {
            $data_pasien = array(
                'idpasien' => $row['idpasien'],
                'nama' => $row['nama'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'ciri_ciri' => $row['ciri_ciri'],
                'status_pasien' => $row['status_pasien'],
                'id_kamar' => $row['id_kamar']
            );

            $response = array('status' => 'success', 'data_pasien' => $data_pasien);
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal mengambil data');
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $idpasien = $_GET['idpasien'];
        $nama = $_GET['nama'];
        $jenis_kelamin = $_GET['jenis_kelamin'];
        $ciri_ciri = $_GET['ciri_ciri'];
        $status_pasien = $_GET['status_pasien'];
        $id_kamar = $_GET['id_kamar'];

        $stmt = $koneksi->prepare("UPDATE pasien SET 
            nama = :nama,
            jenis_kelamin = :jenis_kelamin,
            ciri_ciri = :ciri_ciri,
            status_pasien = :status_pasien,
            id_kamar = :id_kamar
            WHERE idpasien = :idpasien");

        $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
        $stmt->bindParam(':jenis_kelamin', $jenis_kelamin, PDO::PARAM_STR);
        $stmt->bindParam(':ciri_ciri', $ciri_ciri, PDO::PARAM_STR);
        $stmt->bindParam(':status_pasien', $status_pasien, PDO::PARAM_STR);
        $stmt->bindParam(':id_kamar', $id_kamar, PDO::PARAM_INT);
        $stmt->bindParam(':idpasien', $idpasien, PDO::PARAM_INT);

        $result = $stmt->execute();

        if ($result) {
            $response = array('status' => 'success', 'message' => 'Perubahan berhasil disimpan.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menyimpan perubahan: ' . $stmt->errorInfo()[2]);
        }
    }
} catch (PDOException $e) {
    // Handle PDO errors
    $response = array('status' => 'error', 'message' => 'Gagal melakukan operasi: ' . $e->getMessage());
} finally {
    // Always close the connection, regardless of success or failure
    $koneksi = null;
}

echo json_encode($response);
?>
