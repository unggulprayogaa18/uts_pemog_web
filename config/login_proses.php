<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_username = isset($_POST['username']) ? $_POST['username'] : '';
    $input_password = isset($_POST['password']) ? $_POST['password'] : '';

    // Include PDO connection setup from koneksi.php
    include 'koneksi.php';

    try {
        // Gunakan prepared statement untuk mencegah SQL injection
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $input_username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $input_password, PDO::PARAM_STR);
        $stmt->execute();

        // Set fetch mode to fetch results as an associative array
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // Dapatkan hasil query
        $result = $stmt->fetch();

        // Periksa apakah user ditemukan
        if ($result) {
            // Jika login berhasil, simpan informasi di session
            $_SESSION['username'] = $input_username;
            header('Location: index.php');
            exit();
        } else {
            // Jika user tidak ditemukan, tampilkan pesan kesalahan
            echo '<p>Login failed. Invalid username or password.</p>';
        }
    } catch (PDOException $e) {
        // Handle PDO errors
        echo 'Error: ' . $e->getMessage();
    } finally {
        // Always close the connection, regardless of success or failure
        $koneksi = null;
    }
}
?>
