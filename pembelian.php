<?php
session_start();
require 'config/functions.php';

if (isset($_GET['idUser'])) {
    $idUser = $_GET['idUser'];

    $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE idUser = $idUser");
    $user = mysqli_fetch_assoc($result);
}

if (isset($_GET['idPrinter'])) {
    $idPrinter = $_GET['idPrinter'];

    $result = mysqli_query($conn, "SELECT * FROM tb_printers WHERE idPrinter = $idPrinter");
    $printer = mysqli_fetch_assoc($result);

    $hargaPrinter = $printer['hargaPrinter'];
}

if (isset($_POST['beliPrinter'])) {
    if (beliPrinter($_POST) > 0) {
        if (updatePrinter($_POST) > 0) {
            echo "
            <script>
                alert('Pembelian printer berhasil, cek menu list pembelian!');
                document.location.href = 'index.php';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Pembelian printer gagal!');
            document.location.href = 'index.php';
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
    <link rel="stylesheet" href="style/style3.css">
    <title>Form Pembelian | AptPrinters</title>
</head>

<body>
    <header>
        <?php
        if ($_SESSION['statusUser'] == 'customer') {
            include 'customerHeader.php';
        } else {
            header("Location: index.php");
        }
        ?>
    </header>

    <main class="bg-light">
        <div class="formPembelian bg-white p-4 w-75 mx-auto border rounded-3">

            <form action="" method="post" enctype="multipart/form-data">
                <h1 class="display-5"> Form Pembelian </h1>
                <hr>
                <div class="row my-5">
                    <div class="col">
                        <center><img class="img-fluid" src="img/imgPrinters/<?= $printer['gambarPrinter']; ?>" width="50%" alt="Gambar printer"></center>
                    </div>
                </div>
                <input type="hidden" name="idUser" value="<?= $user['idUser']; ?>">
                <input type="hidden" name="idPrinter" value="<?= $printer['idPrinter']; ?>">
                <div class="row align-items-center mb-3">
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <label for="namaPrinter" class="form-label my-1">Nama Printer</label>
                    </div>
                    <div class="col">
                        <input type="text" name="namaPrinter" id="namaPrinter" class="form-control text-uppercase" value="<?= $printer['namaPrinter']; ?>" disabled>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <label for="hargaPrinter" class="form-label my-1">Harga Printer</label>
                    </div>
                    <div class="col">
                        <input type="text" name="hargaPrinter" id="hargaPrinter" class="form-control" value="<?= number_format("$hargaPrinter") ?>" disabled>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <label for="jumlahPembelian" class="form-label my-1">Jumlah Unit</label>
                    </div>
                    <div class="col">
                        <input type="number" min="1" max="<?= $printer['stokPrinter']; ?>" name="jumlahPembelian" id="jumlahPembelian" class="form-control" required>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <label for="jasaPengiriman" class="form-label my-1">Jasa Pengiriman</label>
                    </div>
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jasaPengiriman" value="tiki" id="tiki" required><label for="tiki"> TIKI</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jasaPengiriman" value="jne" id="jne" required><label for="jne"> JNE</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jasaPengiriman" value="j&t" id="j&t" required><label for="j&t"> J&T</label>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-5">
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <label for="buktiPembayaran" class="form-label my-1">Bukti Pembayaran</label>
                    </div>
                    <div class="col">
                        <input type="file" name="buktiPembayaran" id="buktiPembayaran" class="form-control" required>
                        <em class="small text-secondary">Bayar melalui rekening Bank BZA (103-298-9612)</em>
                    </div>
                </div>
                <div class="form-button">
                    <a href="index.php" class="btn btn-md btn-danger">Kembali</a>
                    <button type="submit" name="beliPrinter" class="btn btn-md btn-primary float-end">Beli Printer</button>
                </div>
            </form>

        </div>
    </main>
</body>
<script src="js/bootstrap.bundle.js"></script>

</html>