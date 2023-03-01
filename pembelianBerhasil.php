<?php
session_start();
require 'config/functions.php';

if (isset($_GET['idUser'])) {
    $idUser = $_GET['idUser'];

    $query = mysqli_query($conn, "SELECT * FROM tb_users WHERE idUser = $idUser");
    $user = mysqli_fetch_assoc($query);

    $buys = mysqli_query($conn, "SELECT * FROM tb_pembelian INNER JOIN tb_printers ON tb_pembelian.idPrinter = tb_printers.idPrinter WHERE idUser = $idUser AND statusPembelian = 1");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Pembelian Berhasil | AptPrinters</title>
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
        <h1 class="display-5">Pembelian Berhasil</h1>
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
                    <th scope="col">Lihat Struk</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($buys as $buy) : ?>
                    <?php
                    $statusPembelian = $buy['statusPembelian'];
                    $hargaPembelian = $buy['hargaPembelian'];
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
                        <td><?= number_format("$hargaPembelian", 0, ",", "."); ?></td>
                        <td><?= $statusPembelian; ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#strukPembelian<?= $buy['idPembelian']; ?>" title="Lihat Struk"><i class="bi bi-receipt-cutoff"></i></button>

                            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="strukPembelian<?= $buy['idPembelian']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body mb-4">
                                            <h1 class="display-6 text-center">AptPrinters</h1>
                                            <br>
                                            <p style="text-align: justify;">Hai, <?= $user['namaUser']; ?>! Selamat Anda berhasil melakukan pembelian di AptPrinters. Berikut di bawah ini merupakan info detail terkait pemesanan kamu.</p>
                                            <ul class="mb-5">
                                                <li>Kode Pembelian : <b><?= $buy['kodePembelian']; ?></b></li>
                                                <li>Nama Barang : <b class="text-uppercase"><?= $buy['namaPrinter']; ?></b></li>
                                                <li>Jumlah Unit : <b class="text-uppercase"><?= $buy['jumlahPembelian']; ?> unit</b></li>
                                                <li>Total Pembayaran : Rp<b class="text-uppercase"><?= number_format("$hargaPembelian", 0, ",", "."); ?></b></li>
                                                <li>Tanggal Pembelian : <b><?= $buy['tanggalPembelian']; ?></b></li>
                                                <li>Metode Pengiriman : <b class="text-uppercase"><?= $buy['jasaPengiriman']; ?></b></li>
                                                <li>Alamat : <b class="text-uppercase"><?= $user['alamatUser']; ?></b></li>
                                            </ul>
                                            <p style="text-align: center;" class="fs-6">Status Pembelian</p>
                                            <center><b class="text-uppercase text-success fs-4"><?= $statusPembelian; ?></b></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>
<script src="js/bootstrap.bundle.min.js"></script>

</html>