<?php
session_start();
require 'config/functions.php';

$statusUser = $_GET['statusUser'];
if ($statusUser !== 'admin') {
    header("Location: index.php");
}

if (isset($_POST['tambahPrinter'])) {
    if (tambahPrinter($_POST) > 0) {
        echo "
                <script>
                    alert('Printer baru berhasil ditambahkan!');
                    document.location.href = 'index.php';
                </script>
                ";
    } else {
        echo "
                <script>
                    alert('Printer baru gagal ditambahkan!');
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
    <title>Tambah Printer | AptPrinters</title>
</head>

<body class="body pt-5 bg-dark">
    <div class="tambahContainer bg-light p-4 w-75 mx-auto rounded-3">

        <form action="" method="post" enctype="multipart/form-data">
            <h1 class="display-5">Tambah Printer</h1>
            <hr class="mb-4">

            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                    <label for="gambarPrinter" class="form-label my-1">Gambar Printer</label>
                </div>
                <div class="col">
                    <input type="file" name="gambarPrinter" id="gambarPrinter" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                    <label for="namaPrinter" class="form-label my-1">Nama Printer</label>
                </div>
                <div class="col">
                    <input type="text" name="namaPrinter" id="namaPrinter" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                    <label for="deskripsiPrinter" class="form-label my-1">Deskripsi Printer</label>
                </div>
                <div class="col">
                    <textarea name="deskripsiPrinter" id="deskripsiPrinter" cols="20" rows="5" class="form-control" required></textarea>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                    <label for="hargaPrinter" class="form-label my-1">Harga Printer</label>
                </div>
                <div class="col input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" min="0" name="hargaPrinter" id="hargaPrinter" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="row align-items-center mb-4">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                    <label for="stokPrinter" class="form-label my-1">Stok Printer</label>
                </div>
                <div class="col">
                    <input type="number" min="0" name="stokPrinter" id="stokPrinter" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="form-button">
                <a href="index.php" class="btn btn-md btn-danger">Kembali</a>
                <button type="submit" name="tambahPrinter" class="btn btn-md btn-primary float-end">Tambah</button>
            </div>

        </form>
    </div>
</body>

</html>