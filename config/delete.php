<?php
header('Content-Type: application/json');

include 'koneksi.php';

try {
    if (!$koneksi) {
        $response = array('status' => 'error', 'message' => 'Koneksi Gagal');
    } else {
        $idPasien = $_GET['idpasien'];

        $deleteQuery = "DELETE FROM pasien WHERE idpasien = :idPasien";
        $stmt = $koneksi->prepare($deleteQuery);
        $stmt->bindParam(':idPasien', $idPasien, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response = array('status' => 'success', 'message' => 'Data berhasil dihapus' . $idPasien);
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menghapus data: ' . $stmt->errorInfo()[2]);
        }
    }
} catch (PDOException $e) {
    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage());
}

$koneksi = null; // Close the PDO connection

echo json_encode($response);
?>
