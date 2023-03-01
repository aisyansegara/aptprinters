<?php
session_start();
require 'config/functions.php';

if (isset($_GET['idUser'])) {
    $idUser = $_GET['idUser'];

    $query = mysqli_query($conn, "SELECT * FROM tb_users WHERE idUser = $idUser");
    $user = mysqli_fetch_assoc($query);

    $buys = mysqli_query($conn, "SELECT * FROM tb_pembelian JOIN tb_printers ON tb_pembelian.idPrinter = tb_printers.idPrinter JOIN tb_users ON tb_pembelian.idUser = tb_users.idUser WHERE statusPembelian = 0 ORDER BY kodePembelian ASC");
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
    <title>Konfirmasi Transaksi | AptPrinters</title>
</head>

<body>
    <header>
        <?php
        if ($_SESSION['statusUser'] == 'admin') {
            include 'adminHeader.php';
        } else {
            header("Location: index.php");
        }
        ?>
    </header>

    <main class="container">
        <h1 class="display-5">Konfirmasi Transaksi</h1>
        <hr>
        <table class="table table-striped border">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Kode Pembelian</th>
                    <th scope="col">Nama Pembeli</th>
                    <th scope="col">Barang</th>
                    <th scope="col">Jumlah Unit</th>
                    <th scope="col">Total Pembayaran</th>
                    <th scope="col">Bukti Pembayaran</th>
                    <th scope="col">Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($buys as $buy) : ?>
                    <?php
                    $hargaPembelian = $buy['hargaPembelian'];
                    ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $buy['kodePembelian']; ?></td>
                        <td><?= $buy['namaUser']; ?></td>
                        <td class="text-uppercase"><?= $buy['namaPrinter']; ?></td>
                        <td><?= $buy['jumlahPembelian']; ?></td>
                        <td><?= number_format("$hargaPembelian", 0, ",", ".") ?></td>
                        <td><a href="img/imgPembelian/<?= $buy['buktiPembayaran']; ?>" class="text-decoration-none" target="_blank">Lihat bukti</a></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#konfirmasiPembelian<?= $buy['idPembelian']; ?>" title="Konfirmasi Pembelian"><i class="bi bi-check-square"></i></button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#batalkanPembelian<?= $buy['idPembelian']; ?>" title="Batalkan Pembelian"><i class="bi bi-x-square"></i></button>

                            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="konfirmasiPembelian<?= $buy['idPembelian']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <center><img src="img/imgProperties/konfirmasi.png" class="w-50 mb-4"></center>
                                            <p class="fs-4 text-center">Konfirmasi pembelian kode <b class="text-uppercase">"<?= $buy['kodePembelian']; ?>"</b>?</p>
                                            <form action="" method="post">
                                                <input type="hidden" name="idPembelian" value="<?= $buy['idPembelian']; ?>">
                                                <div class="modal-footer d-flex justify-content-center border-0">
                                                    <button type="submit" name="konfirmasiPembelian" class="btn btn-success px-5">Konfirmasi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="batalkanPembelian<?= $buy['idPembelian']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <center><img src="img/imgProperties/delete.png" class="w-50 mb-4"></center>
                                            <p class="fs-4 text-center">Batalkan pembelian kode <b class="text-uppercase">"<?= $buy['kodePembelian']; ?>"</b>?</p>
                                            <form action="" method="post">
                                                <input type="hidden" name="idPembelian" value="<?= $buy['idPembelian']; ?>">
                                                <div class="modal-footer d-flex justify-content-center border-0">
                                                    <button type="submit" name="batalkanPembelian" class="btn btn-danger px-5">Batalkan</button>
                                                </div>
                                            </form>
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