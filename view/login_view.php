<!DOCTYPE html>
<html>

    <header>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <script  defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../view/style.css"/>

    </header>
    <body>
        <div class="text-center">
            <form id="formlog" method="get" action="../controller/login_controller.php">
                <h1 class="h3 mb-3">Please sign in</h1>
                <label class="sr-only"> Username</label>
                <input type="text" class="form-control"name="username" required autofocus>
                <label class="sr-only">Password</label>
                <input type="password" class="form-control" name="password" required>
                <div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="login_btn">Sign in </button>
                <p> Want to register? <a href="../controller/registration_controller.php">Register</a>
                <div>
            </form>
        </div>
    </body>
</html>