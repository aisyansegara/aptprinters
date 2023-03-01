<?php
require 'config/functions.php';
session_start();

if (isset($_GET['error'])) {
    $error = $_GET['error'];
} else {
    $error = "";
}

$pesan = "";
if ($error == "username_sama") {
    $pesan = "Username sudah terdaftar";
} elseif ($error == "konfirmasi_salah") {
    $pesan = "Konfirmasi password salah";
}

if (isset($_POST['register'])) {
    if (registrasi($_POST) > 0) {
        echo "
            <script>
                alert('Registrasi akun berhasil, silahkan login!');
                document.location.href = 'login.php';
            </script>
            ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Register | AptPrinters</title>
</head>

<body class="body bg-dark">
    <div class="registerContainer bg-light p-4 w-75 mx-auto mt-5 rounded-3">

        <form action="" method="post">
            <h1 class="display-5">Registrasi</h1>
            <hr class="mb-3">
            <?php if ($error) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $pesan; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-3">
                    <label for="namaUser" class="form-label my-1">Nama</label>
                </div>
                <div class="col">
                    <input type="text" name="namaUser" id="namaUser" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-3">
                    <label for="usernameUser" class="form-label my-1">Username</label>
                </div>
                <div class="col">
                    <input type="text" name="usernameUser" id="usernameUser" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-3">
                    <label for="passwordUser" class="form-label my-1">Password</label>
                </div>
                <div class="col">
                    <input type="password" name="passwordUser" id="passwordUser" class="form-control" required>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-3">
                    <label for="repasswordUser" class="form-label my-1">Konfirmasi Password</label>
                </div>
                <div class="col">
                    <input type="password" name="repasswordUser" id="repasswordUser" class="form-control" required>
                </div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-3">
                    <label for="alamatUser" class="form-label my-1">Alamat</label>
                </div>
                <div class="col">
                    <input type="text" name="alamatUser" id="alamatUser" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <input type="hidden" name="statusUser" id="statusUser" value="customer">
            <div class="btn-register mb-4">
                <button type="submit" name="register" class="btn btn-primary">Register</button>
            </div>
            <div>
                Sudah punya akun?<a href="login.php" class="text-decoration-none"> Login</a>
            </div>
        </form>

    </div>
</body>
<script src="js/bootstrap.bundle.min.js"></script>

</html>