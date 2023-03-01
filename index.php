<?php
session_start();
require 'config/functions.php';

$printers = query("SELECT * FROM tb_printers");

if (isset($_COOKIE['idUser']) && isset($_COOKIE['keyUser'])) {
    $idUser = $_COOKIE['idUser'];
    $keyUser = $_COOKIE['keyUser'];

    $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE idUser = $idUser");
    $row = mysqli_fetch_assoc($result);

    if ($keyUser === hash('sha256', $row['usernameUser'])) {
        $_SESSION['login'] = true;
        $_SESSION['idUser'] = $row['idUser'];
        $_SESSION['namaUser'] = $row['namaUser'];
        $_SESSION['usernameUser'] = $row['usernameUser'];
        $_SESSION['alamatUser'] = $row['alamatUser'];
        $_SESSION['statusUser'] = $row['statusUser'];
    }
}

if (isset($_SESSION['idUser']) && isset($_SESSION['namaUser']) && isset($_SESSION['usernameUser']) && isset($_SESSION['alamatUser']) && isset($_SESSION['statusUser'])) {
    $idUser = $_SESSION['idUser'];
    $namaUser = $_SESSION['namaUser'];
    $usernameUser = $_SESSION['usernameUser'];
    $alamatUser = $_SESSION['alamatUser'];
    $statusUser = $_SESSION['statusUser'];

    $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE idUser = $idUser");
    $user = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style2.css">
    <title>Beranda | AptPrinters</title>
</head>

<body>
    <header>
        <?php
        if (!isset($_SESSION['login'])) {
            include 'header.php';
        } elseif ($_SESSION['statusUser'] == 'customer') {
            include 'customerHeader.php';
        } elseif ($_SESSION['statusUser'] == 'admin') {
            include 'adminHeader.php';
        }
        ?>
    </header>

    <main>
        <div class="head container">
            <div class="bg-light rounded p-5">
                <h1>AptPrinters</h1>
                <p class="lead">Toko penyedia printer berkualitas no. 1 di Indonesia.</p>
                <a class="btn btn-lg btn-primary" href="" role="button">Lihat lebih lanjut &raquo;</a>
            </div>
        </div>

        <div class="product container mt-3">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($printers as $printer) : ?>
                    <?php $hargaPrinter = $printer['hargaPrinter']; ?>
                    <div class="col">
                        <div class="card w-100 h-100">
                            <div class="card-img-top">
                                <img src="img/imgPrinters/<?= $printer['gambarPrinter']; ?>" class="img rounded-2" width="100%" height="225" alt="">
                            </div>
                            <div class="card-body mb-auto">
                                <h5 class="card-title text-uppercase"><?= $printer['namaPrinter']; ?></h5>
                                <p class="card-text"><?= $printer['deskripsiPrinter']; ?></p>
                            </div>
                            <div class="card-footer border-0  bg-white">
                                <ul class="card-text list-unstyled mb-auto">
                                    <li class="card-text text-start">Stok: <?= $printer['stokPrinter']; ?></li>
                                    <li class="card-text text-start">Harga: Rp<?= number_format("$hargaPrinter", 0, ",", "."); ?></li>
                                </ul>
                            </div>
                            <div class="card-footer bg-white border-0 p-3">
                                <?php if (!isset($_SESSION['login'])) : ?>
                                    <button submit="button" class="btn btn-md btn-primary w-100" data-bs-toggle="modal" data-bs-target="#notLogin" title="Beli Printer">Beli Printer</button>

                                    <div class="modal fade" id="notLogin" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <center><img src="img/imgProperties/login.png" class="loginImg w-50"></center>
                                                    <h1 class="display-6 text-center">Oops, login dahulu!</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif ($_SESSION['statusUser'] == 'customer') : ?>
                                    <a href="pembelian.php?idUser=<?= $user['idUser']; ?>&idPrinter=<?= $printer['idPrinter']; ?>" class="btn btn-md btn-primary w-100" title="Beli Printer">Beli Printer</a>

                                <?php elseif ($_SESSION['statusUser'] == 'admin') : ?>
                                    <button type="button" class="btn btn-md btn-warning" data-bs-toggle="modal" data-bs-target="#editPrinter<?= $printer['idPrinter']; ?>" title="Edit data">Edit</button>

                                    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editPrinter<?= $printer['idPrinter']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Printer</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="idPrinter" value="<?= $printer['idPrinter']; ?>">
                                                        <input type="hidden" name="gambarLama" value="<?= $printer['gambarPrinter']; ?>">

                                                        <img src="img/imgPrinters/<?= $printer['gambarPrinter']; ?>" class="rounded-2 mb-3" width="100%" height="250">
                                                        
                                                        <div class="editElement mb-3">
                                                            <label for="gambarPrinter" class="form-label">Gambar Printer:</label>
                                                            <input type="file" name="gambarPrinter" id="gambarPrinter" class="form-control">
                                                        </div>
                                                        <div class="editElement mb-3">
                                                            <label for="namaPrinter" class="form-label">Nama Printer:</label>
                                                            <input type="text" name="namaPrinter" id="namaPrinter" class="form-control" value="<?= $printer['namaPrinter']; ?>">
                                                        </div>
                                                        <div class="editElement mb-3">
                                                            <label for="deskripsiPrinter" class="form-label">Deskripsi Printer:</label><br>
                                                            <textarea name="deskripsiPrinter" id="deskripsiPrinter" rows="3" class="form-control overflow-scroll"><?= $printer['deskripsiPrinter']; ?></textarea>
                                                        </div>
                                                        <div class="editElement mb-3">
                                                            <label for="hargaPrinter" class="form-label">Harga Printer:</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="number" min="0" name="hargaPrinter" id="hargaPrinter" class="form-control" value="<?= $printer['hargaPrinter']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="editElement mb-3">
                                                            <label for="stokPrinter" class="form-label">Stok Printer:</label>
                                                            <input type="number" min="0" name="stokPrinter" id="stokPrinter" class="form-control" value="<?= $printer['stokPrinter']; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" name="editPrinter" class="btn btn-primary">Ubah</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-md btn-danger" data-bs-toggle="modal" data-bs-target="#hapusPrinter<?= $printer['idPrinter']; ?>" title="Hapus data">Hapus</button>

                                    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="hapusPrinter<?= $printer['idPrinter']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <center><img src="img/imgProperties/delete.png" class="deleteImg w-50 mb-4"></center>
                                                    <p class="fs-4 text-center">Yakin hapus <b class="text-uppercase">"<?= $printer['namaPrinter']; ?>"</b>?</p>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="idPrinter" value="<?= $printer['idPrinter']; ?>">
                                                        <div class="modal-footer d-flex justify-content-center border-0">
                                                            <button type="submit" name="hapusPrinter" class="btn btn-danger px-5">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <div class="container-fluid bg-light">
        <footer class="py-5 mt-3">
            <?php 
                include 'footer.php';
            ?>
        </footer>
    </div>
    
</body>
<script src="js/bootstrap.bundle.min.js"></script>

</html>