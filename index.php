<?php
// index.php
session_start();

function redirectToLogin() {
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['username'])) {
    redirectToLogin();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <title>RS Prayoga</title>
    <link href="assets/img/hero-bg.jpg" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono&display=swap" rel="stylesheet">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #106eea;">
        <div class="container">
            <a class="navbar-brand" href="#">RS Prayoga</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="logout()">logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="column-gap-1">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mb-4" style="font-family: 'Space Mono', monospace;">Pendaftaran Pasien</h2>
                <form id="pasienForm">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pasien:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ciri_ciri" class="form-label">Ciri-ciri:</label>
                        <textarea class="form-control" id="ciri_ciri" name="ciri_ciri"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status_pasien" class="form-label">Status Pasien:</label>
                        <select class="form-select" id="status_pasien" name="status_pasien" required>
                            <option value="Ditangani">Ditangani</option>
                            <option value="Menunggu">Menunggu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_kamar" class="form-label">ID Kamar:</label>
                        <input type="text" class="form-control" id="id_kamar" name="id_kamar" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" onclick="submitForm()" id="daftarkan"
                            style="margin-right: 10px; font-family: 'Space Mono', monospace;">Daftar</button>
                        <button type="button" class="btn btn-danger" onclick="batalin()" id="batalkan"
                            style="font-family: 'Space Mono', monospace;">Batal</button>
                    </div>
                </form>
            </div>

            <div class="col-md-12">
                <div class="card mt-5">
                    <h2 class="card-header text-center" style="font-family: 'Space Mono', monospace;">Daftar Pasien</h2>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari...">
                        </div>
                        <br>
                        <div class="table-responsive overflow-auto">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Pasien</th>
                                        <th scope="col">Nama Pasien</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Ciri-ciri</th>
                                        <th scope="col">Status Pasien</th>
                                        <th scope="col">ID Kamar</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelforindex" style="font-family: 'Space Mono', monospace;">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="pagination-container card-footer">
                        <ul class="pagination justify-content-center" id="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>

    <footer class="text-white text-center py-1" style="background-color: #106eea; height:60px;">
    </footer>
    <style>
        .bg-dark-opacity {
            background-color: rgba(0, 0, 0, 0.705);
        }
    </style>
    <footer class="bg-dark-opacity text-white text-center py-2">
        <p>&copy; Created by 21552011087 puput unggul prayoga TIF 221 PB</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/ajax-index.js"> </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
     
   
</body>

</html>