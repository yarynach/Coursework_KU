<!DOCTYPE html>
<html>

    <header>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <script  defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../view/style.css"/>
        <script type="text/javascript" src="../view/clientcode.js"></script>

    </header>
    <body>
        <div class="text-center">
            <form id="formlog" method="get" action="../controller/order.php">
                <h1 class="h3 mb-3">Please complete your order</h1>
                <label class="sr-only"> Your name and surname</label>
                <input type="text" class="form-control"name="name" required autofocus>
                <label class="sr-only">Your address</label>
                <input type="text" class="form-control" name="address">
                <label class="sr-only">Your email</label>
                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" name="email" required>
                <div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="order_btn" required>Submit </button>
                <br><br>
                <a class="btn btn-primary" href="../controller/recipe_list.php">Go back</a>
                </div>
            </form>
        </div>
    </body>
</html>