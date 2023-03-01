<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'db_toko');

    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    function registrasi($data){
        global $conn;
        $namaUser = htmlspecialchars(stripslashes($data['namaUser']));
        $usernameUser = htmlspecialchars(stripslashes($data['usernameUser']));
        $passwordUser = mysqli_real_escape_string($conn, $data['passwordUser']);
        $repasswordUser = mysqli_real_escape_string($conn, $data['repasswordUser']);
        $alamatUser = htmlspecialchars(stripslashes($data['alamatUser']));
        $statusUser = $data['statusUser'];

        $result = mysqli_query($conn, "SELECT usernameUser FROM tb_users WHERE usernameUser = '$usernameUser'");

        if(mysqli_fetch_assoc($result)){
            header("Location: register.php?error=username_sama");
            return false;
        }

        if ($passwordUser !== $repasswordUser) {
            header("Location: register.php?error=konfirmasi_salah");
            return false;
        }

        $passwordUser = password_hash($passwordUser, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO tb_users VALUES('', '$namaUser', '$usernameUser', '$passwordUser', '$alamatUser', '$statusUser')");
        return mysqli_affected_rows($conn);
    }

    function login($data){
        global $conn;
        $usernameUser = $data['usernameUser'];
        $passwordUser = $data['passwordUser'];

        $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE usernameUser = '$usernameUser'");

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($passwordUser, $row['passwordUser'])) {
                $_SESSION['login'] = true;

                if (isset($data['remember'])) {
                    setcookie('idUser', $row['idUser'], time() + 60);
                    setcookie('keyUser', hash('sha256', $row['usernameUser'], time() + 60));
                }
                if ($row['statusUser'] == 'customer') {
                    $_SESSION['idUser'] = $row['idUser'];
                    $_SESSION['namaUser'] = $row['namaUser'];
                    $_SESSION['usernameUser'] = $row['usernameUser'];
                    $_SESSION['alamatUser'] = $row['alamatUser'];
                    $_SESSION['statusUser'] = 'customer';
                    header("Location: index.php");
                    exit;
                }
                if ($row['statusUser'] == 'admin') {
                    $_SESSION['idUser'] = $row['idUser'];
                    $_SESSION['namaUser'] = $row['namaUser'];
                    $_SESSION['usernameUser'] = $row['usernameUser'];
                    $_SESSION['alamatUser'] = $row['alamatUser'];
                    $_SESSION['statusUser'] = 'admin';
                    header("Location: index.php");
                    exit;
                }
            } else {
                $_SESSION['passwordSalah'] = true;
            }
        } else {
            $_SESSION['usernameTidakDitemukan'] = true;
        }
    }
    
    function query($query){
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function tambahPrinter($data){
        global $conn;
        $namaPrinter = htmlspecialchars($data['namaPrinter']);
        $deskripsiPrinter = htmlspecialchars($data['deskripsiPrinter']);
        $hargaPrinter = htmlspecialchars($data['hargaPrinter']);
        $stokPrinter = htmlspecialchars($data['stokPrinter']);

        $gambarPrinter = uploadPrinter();
        if (!$gambarPrinter) {
            return false;
        }

        $query = "INSERT INTO tb_printers VALUES ('', '$gambarPrinter', '$namaPrinter', '$deskripsiPrinter', '$hargaPrinter', '$stokPrinter')";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function uploadPrinter(){
        $namaFile = $_FILES['gambarPrinter']['name'];
        $ukuranFile = $_FILES['gambarPrinter']['size'];
        $tmpName = $_FILES['gambarPrinter']['tmp_name'];

        $ekstensiGambarValid = ["jpg", "jpeg", "png"];
        $ekstensiGambar = explode(".", $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "
            <script>
                alert('Bukan gambar yang Anda upload!');
            </script>";
            return false;
        }

        if ($ukuranFile > 3000000) {
            echo "
            <script>
                alert('Ukuran gambar terlalu besar!');
            </script>";
            return false;
        }

        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, "img/imgPrinters/" . $namaFileBaru);
        return $namaFileBaru;
    }

    if (isset($_POST['editPrinter'])) {
        $idPrinter = $_POST['idPrinter'];
        $namaPrinter = htmlspecialchars($_POST['namaPrinter']);
        $deskripsiPrinter = htmlspecialchars($_POST['deskripsiPrinter']);
        $hargaPrinter = htmlspecialchars($_POST['hargaPrinter']);
        $stokPrinter = htmlspecialchars($_POST['stokPrinter']);
        $gambarLama = $_POST['gambarLama'];

        if ($_FILES['gambarPrinter']['error'] === 4) {
            $gambarPrinter = $gambarLama;
        } else {
            $gambarPrinter = uploadPrinter();
        }

        $queryEditPrinter = mysqli_query($conn, "UPDATE tb_printers SET gambarPrinter = '$gambarPrinter', namaPrinter = '$namaPrinter', deskripsiPrinter = '$deskripsiPrinter', hargaPrinter = '$hargaPrinter', stokPrinter = '$stokPrinter' WHERE idPrinter = $idPrinter");

        if ($queryEditPrinter) {
            header("Location: index.php");
        }
    }

    if (isset($_POST['hapusPrinter'])) {
        $idPrinter = $_POST['idPrinter'];

        $queryHapusPrinter = mysqli_query($conn, "DELETE FROM tb_printers WHERE idPrinter = $idPrinter");

        if ($queryHapusPrinter) {
            header("Location: index.php");
        }
    }

    function beliPrinter($data){
        global $conn;
        $idUser = $data['idUser'];
        $idPrinter = $data['idPrinter'];
        $jumlahPembelian = htmlspecialchars($data['jumlahPembelian']);
        $jasaPengiriman = $data['jasaPengiriman'];
        $statusPembelian = 0;

        //buat kode pembelian
        $query1 = mysqli_query($conn, "SELECT * FROM tb_pembelian");
        $rows1 = mysqli_num_rows($query1) + 1;
        $kodePembelian = "APTP0" . $rows1;

        //upload bukti pembelian
        $buktiPembayaran = uploadPembayaran();
        if (!$buktiPembayaran) {
            return false;
        }

        //hitung harga pembelian
        $hargaPembelian = hargaPembelian($data);

        //insert ke table pembelian
        mysqli_query($conn, "INSERT INTO tb_pembelian VALUES ('', '$idUser', '$idPrinter', NOW(), '$jumlahPembelian', '$hargaPembelian', '$jasaPengiriman', '$buktiPembayaran', '$kodePembelian', '$statusPembelian')");
        return mysqli_affected_rows($conn);
    }

    function hargaPembelian($data){
        global $conn;
        $idPrinter = $data['idPrinter'];
        $jumlahPembelian = htmlspecialchars($data['jumlahPembelian']);

        $query = mysqli_query($conn, "SELECT * FROM tb_printers WHERE idPrinter = $idPrinter");
        $row = mysqli_fetch_assoc($query);

        $hargaPrinter = $row['hargaPrinter'];

        $totalHarga = $jumlahPembelian * $hargaPrinter;
        return $totalHarga;
    }

    function updatePrinter($data){
        global $conn;
        $idPrinter = $data['idPrinter'];
        $jumlahPembelian = htmlspecialchars($data['jumlahPembelian']);

        $query = mysqli_query($conn, "SELECT * FROM tb_printers WHERE idPrinter = $idPrinter");
        $row = mysqli_fetch_assoc($query);

        $stokPrinter = $row['stokPrinter'];

        $stokBaru = $stokPrinter - $jumlahPembelian;

        mysqli_query($conn, "UPDATE tb_printers SET stokPrinter = '$stokBaru' WHERE idPrinter = $idPrinter");
        return mysqli_affected_rows($conn);
    }

    function uploadPembayaran(){
        $namaFile = $_FILES['buktiPembayaran']['name'];
        $ukuranFile = $_FILES['buktiPembayaran']['size'];
        $error = $_FILES['buktiPembayaran']['error'];
        $tmpName = $_FILES['buktiPembayaran']['tmp_name'];

        if ($error === 4) {
            return false;
        }

        $ekstensiGambarValid = ["jpg", "jpeg", "png"];
        $ekstensiGambar = explode(".", $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "
                <script>
                    alert('Bukan gambar yang Anda upload!');
                </script>";
            return false;
        }

        if ($ukuranFile > 3000000) {
            echo "
                <script>
                    alert('Ukuran gambar terlalu besar!');
                </script>";
            return false;
        }

        $buktiPembayaran = uniqid();
        $buktiPembayaran .= '.';
        $buktiPembayaran .= $ekstensiGambar;

        move_uploaded_file($tmpName, "img/imgPembelian/" . $buktiPembayaran);
        return $buktiPembayaran;
    }

    if (isset($_POST['konfirmasiPembelian'])) {
        $idPembelian = $_POST['idPembelian'];

        $queryKonfirmasiPembelian = mysqli_query($conn, "UPDATE tb_pembelian SET statusPembelian = 1 WHERE idPembelian = $idPembelian");

        if ($queryKonfirmasiPembelian) {
            header("Location: index.php");
        }
    }

    if (isset($_POST['batalkanPembelian'])) {
        $idPembelian = $_POST['idPembelian'];

        $queryPembelian = mysqli_query($conn, "SELECT * FROM tb_pembelian WHERE idPembelian = $idPembelian");
        $row = mysqli_fetch_assoc($queryPembelian);

        $jumlahPembelian = $row['jumlahPembelian'];
        $idPrinter = $row['idPrinter'];

        $queryPrinter = mysqli_query($conn, "SELECT * FROM tb_printers WHERE idPrinter = $idPrinter");
        $row2 = mysqli_fetch_assoc($queryPrinter);

        $stokPrinter = $row2['stokPrinter'];
        $stokPrinterBaru = $jumlahPembelian + $stokPrinter;

        mysqli_query($conn, "UPDATE tb_printers SET stokPrinter = $stokPrinterBaru WHERE idPrinter = $idPrinter");

        $batalkanPembelian = mysqli_query($conn, "UPDATE tb_pembelian SET statusPembelian = 2 WHERE idPembelian = $idPembelian");
        if ($batalkanPembelian) {
            echo "
            <script>
                alert('Pembelian berhasil dibatalkan');
                document.location.href = 'index.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Pembelian gagal dibatalkan');
                document.location.href = 'index.php';
            </script>
            ";
        }
    }
?>