<?php
session_start();
require 'config/functions.php';

if (isset($_GET['idUser'])) {
    $idUser = $_GET['idUser'];

    $query = mysqli_query($conn, "SELECT * FROM tb_users WHERE idUser = $idUser");
    $user = mysqli_fetch_assoc($query);

    $buys = mysqli_query($conn, "SELECT * FROM tb_pembelian INNER JOIN tb_printers ON tb_pembelian.idPrinter = tb_printers.idPrinter WHERE idUser = $idUser AND statusPembelian = 0");
    $buy = mysqli_fetch_assoc($buys);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style1.css">
    <title>List Pembelian | AptPrinters</title>
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

    <main class="container">
        <h1 class="display-5">List Pembelian</h1>
        <hr>
        <table class="table table-striped border">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Kode Pembelian</th>
                    <th scope="col">Barang</th>
                    <th scope="col">Jumlah Unit</th>
                    <th scope="col">Total Pembayaran</th>
                    <th scope="col">Status Pembelian</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($buys as $buy) : ?>
                    <?php
                        $hargaPembelian = $buy['hargaPembelian'];
                        $statusPembelian = $buy['statusPembelian'];
                        if ($statusPembelian == 0) {
                            $statusPembelian = "Belum Terkonfirmasi";
                        } else {
                            $statusPembelian = "Terkonfirmasi";
                        }
                    ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $buy['kodePembelian']; ?></td>
                        <td class="text-uppercase"><?= $buy['namaPrinter']; ?></td>
                        <td><?= $buy['jumlahPembelian']; ?></td>
                        <td><?= number_format("$hargaPembelian", 0, ',', '.'); ?></td>
                        <td><?= $statusPembelian; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
<script src="js/bootstrap.bundle.min.js"></script>

</html>