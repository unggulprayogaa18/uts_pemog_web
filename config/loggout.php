<?php
session_start();

// Assuming you have a PDO connection in koneksi.php
include 'koneksi.php';

// Clear user-related session data
$_SESSION = array();

// Destroy the session
session_destroy();

$response = array('status' => 'success', 'message' => 'Logout successful');

header('Content-Type: application/json');
echo json_encode($response);
?>
