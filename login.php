<?php
session_start();

if(isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// ... rest of your login.php code ...


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN ADMIN</title>
    <link href="assets/img/hero-bg.jpg" rel="icon">

    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ecf0f3;
        }

        .wrapper {
            max-width: 350px;
            min-height: 500px;
            margin: 80px auto;
            padding: 40px 30px 30px 30px;
            background-color: #ecf0f3;
            border-radius: 15px;
            box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
        }

        .logo {
            width: 80px;
            margin: auto;
        }

        .logo img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0px 0px 3px #5f5f5f,
                0px 0px 0px 5px #ecf0f3,
                8px 8px 15px #a7aaa7,
                -8px -8px 15px #fff;
        }

        .wrapper .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 1.3px;
            padding-left: 10px;
            color: #555;
        }

        .wrapper .form-field input {
            width: 100%;
            display: block;
            border: none;
            outline: none;
            background: none;
            font-size: 1.2rem;
            color: #666;
            padding: 10px 15px 10px 10px;
        }

        .wrapper .form-field {
            padding-left: 10px;
            margin-bottom: 20px;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px #c3d2e0, inset -8px -8px 8px #fff;
        }

        .wrapper .form-field .fas {
            color: #555;
        }

        .wrapper .btn {
            box-shadow: none;
            width: 100%;
            height: 40px;
            background-color: rgba(12, 77, 161, 0.959);
            color: #fff;
            border-radius: 25px;
            box-shadow: 3px 3px 3px #b1b1b1,
                -3px -3px 3px #fff;
            letter-spacing: 1.3px;
        }

        .wrapper .btn:hover {
            background-color: #039BE5;
        }

        .wrapper a {
            text-decoration: none;
            font-size: 0.8rem;
            color: #03A9F4;
        }

        .wrapper a:hover {
            color: #039BE5;
        }

        @media(max-width: 380px) {
            .wrapper {
                margin: 30px 20px;
                padding: 40px 15px 15px 15px;
            }
        }

        .gmabar {
            margin-top: -70px;
            margin-left: 10px;
            position: fixed;
            height: 40px;
        }
    </style>
</head>

<body>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                alert("Selamat datang ibu \nUsername: prayoga\nPassword: prayoga");
            }, 1); // 5000 milidetik atau 5 detik
        });
    </script>
    <div class="wrapper">

        <div class="back"> <a href="home.php"><img class="gmabar" src="assets/img/back.png" alt=""></a></div>

        <div class="logo">
            <img src="assets/img/rsa.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            Login Admin
        </div>


        <form class="p-3 mt-3" action="" method="post">
            <?php

            function redirectToIndex() {
                header("Location: index.php");
                exit();
            }
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $input_username = isset($_POST['username']) ? $_POST['username'] : '';
                $input_password = isset($_POST['password']) ? $_POST['password'] : '';

                // Logika login, Anda harus menyimpan informasi login di session atau cookie.
                $koneksi = new mysqli("localhost", "root", "", "unggulprayoga");

                if($koneksi->connect_error) {
                    $response = array('status' => 'error', 'message' => 'Koneksi Gagal: '.$koneksi->connect_error);
                } else {
                    // Gunakan prepared statement untuk mencegah SQL injection
                    $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
                    $stmt->bind_param('ss', $input_username, $input_password);
                    $stmt->execute();

                    // Dapatkan hasil query
                    $result = $stmt->get_result();

                    // Periksa apakah user ditemukan
                    // Inside the block where login is successful
                    if($result->num_rows > 0) {
                        // Login successful
                        $_SESSION['username'] = $input_username;
                        $stmt->close();
                        $koneksi->close();
                        header('Location: index.php');
                        exit();
                    } else {
                        // Login failed
                        echo '<p>Login failed. Invalid username or password.</p>';
                    }



                    $stmt->close();
                    $koneksi->close();
                }
            }
            ?>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <button type="submit" class="btn mt-3">Login</button>
        </form>
        <div class="text-center fs-6">
        </div>
    </div>
  

</body>

</html>