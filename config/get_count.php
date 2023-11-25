<?php
header('Content-Type: application/json');

include 'koneksi.php';

try {
    $stmtWaiting = $koneksi->prepare("SELECT COUNT(*) as waiting_count FROM pasien WHERE status_pasien = 'menunggu'");
    $stmtWaiting->execute();
    $stmtWaiting->setFetchMode(PDO::FETCH_ASSOC);
    $waitingCount = $stmtWaiting->fetch()['waiting_count'];

    $stmtHandled = $koneksi->prepare("SELECT COUNT(*) as handled_count FROM pasien WHERE status_pasien = 'ditangani'");
    $stmtHandled->execute();
    $stmtHandled->setFetchMode(PDO::FETCH_ASSOC);
    $handledCount = $stmtHandled->fetch()['handled_count'];

    $response = [
        'status' => 'success',
        'message' => 'Data berhasil diambil',
        'waiting_count' => $waitingCount,
        'handled_count' => $handledCount,
    ];

    echo json_encode($response);
} catch (PDOException $e) {
    $response = ['status' => 'error', 'message' => 'Koneksi Gagal: ' . $e->getMessage()];
    echo json_encode($response);
}
?>
