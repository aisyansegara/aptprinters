<?php
require 'config/functions.php';
session_start();

if (isset($_POST['login'])) {
    if (login($_POST) > 0) {
        return true;
    } else {
        $error = true;
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
    <title>Login | AptPrinters</title>
</head>

<body class="body bg-dark">
    <div class="loginContainer bg-light p-4 w-75 mx-auto mt-5 rounded-3">

        <form action="" method="post">
            <h1 class="display-5">Login</h1>
            <hr class="mb-3">
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    Username atau password salah!
                </div>
            <?php endif; ?>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                    <label for="usernameUser" class="form-label my-1">Username</label>
                </div>
                <div class="col">
                    <input type="text" name="usernameUser" id="usernameUser" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-5 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                    <label for="passwordUser" class="form-label my-1">Password</label>
                </div>
                <div class="col">
                    <input type="password" name="passwordUser" id="passwordUser" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="row mb-4 form-check">
                <div class="col col-sm col-md col-lg col-xl">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>
            </div>
            <div class="btn-login mb-4">
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </div>
            <div>
                Belum punya akun? <a href="register.php" class="text-decoration-none">Register</a>
            </div>
        </form>

    </div>
</body>

</html>