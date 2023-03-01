<?php 
if (!isset($_SESSION['login'])) {
    header("Location: index");
}
?>
<nav class="navbar navbar-dark bg-dark fixed-top" aria-label="First navbar example">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">AptPrinters</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-2" id="navbarsExample01">
            <ul class="navbar-nav me-auto mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="tambahPrinter.php?statusUser=<?= $user['statusUser']; ?>">Tambah Printer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="konfirmasiTransaksi.php?idUser=<?= $user['idUser']; ?>">Konfirmasi Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="konfirmasiBerhasil.php?idUser=<?= $user['idUser']; ?>">Konfirmasi Berhasil</a>
                </li>
                <li class="nav-item dropdown mt-2">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Akun</a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li class="dropdown-item mb-1">
                            <strong><?= $user['usernameUser']; ?></strong>
                            <p class="text-secondary d-inline"><em>(<?= $user['statusUser']; ?>)</em></p>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>