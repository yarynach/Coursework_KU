<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script  defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../view/style.css"/>
</head>
<body>
    <div class="text-center">
    <form id="formlog" method="post" action="../controller/registration_controller.php">
        <h1 class="h3 mb-3">Please register</h1>
        <label class="sr-only"> Username</label>
        <input type="text"  class="form-control" name="username" required autofocus>
        <div>
        <label class="sr-only">Password</label>
        <input type="password" class="form-control" name="password" required>
        </div>
        <label class="sr-only">Confirm password</label>
        <input type="password" class="form-control" name="password1" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="register_btn">Register</button>
        <p> Already a member? <a href="../controller/login_controller.php">Sign in</a>
    </form>
    </div>
</body>
</html>

