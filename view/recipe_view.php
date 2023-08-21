<!doctype html>
<html>
    <head>
        
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="../view/style.css"/>
        <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="../view/clientcode.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <script  defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

        <title>Recipes website</title>

    </head> 
    <body>
        <nav  class="navbar top navbar-expand-lg navbar-light" style="background-color: #93b886">
        <div class="container">
            <a href="../controller/recipe_list.php" class="navbar-brand h1">Recipe for you!</a>  
            <button type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            class="navbar-toggler"
            aria-controls="navbarNav"
            arian-expanded="false"
            aria-label="Toggle navigation">  
            <span class="navbar-toggler-icon"></span>
            </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav" >
                    <li class="nav-item active"><a href="../controller/recipe_list.php" class="nav-link">Home</a></li>
                    <li class="nav-item active"><form><button type="submit" name="logout_btn" class="nav-link">Log in/Logout</button></form></li>
                </ul>
                </div>
                <form  class="d-flex" action="../controller/recipe_list.php">
                                <div id="ajaxsearch">
                                <input class="form-control me-2" type = "text" name="searchname" placeholder="Search"/>
                                <div class="results">
                                    <div class="result  navbar-text">data</div>
                                </div>
                            </div>
                </form>
                <button type="submit" class="btn btn-dark" id="cart_btn">Show cart</button>
            </div>
        </nav>

        <div class="container justify-content-start">
    <button type="submit" class="btn btn-dark" id="filter_btn">Filter</button>
    <form id="filter-form" action="../controller/recipe_list.php" method="get">
        <div>
            <label for="time" class="form-label">Cooking time</label>
            <input type="text" name="time" class="form-control" id="time">
        </div>
        <div>
            <p class="form-label">Filter by dietary restriction:</p>
            <?php foreach($restrictions as $restr) :?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="restr[]" value="<?=$restr; ?>" id="<?=$restr; ?>">
                <label class="form-check-label" for="<?=$restr; ?>"><?=$restr; ?></label>
            </div>
            <?php endforeach?>  
        </div>
        <div>
            <p class="form-label">Enter ingredients you have:</p>
            <div id="searchForIngr">
                <div class="input-group">
                    <input type="text" name="searchingr" class="form-control" placeholder="Search"/>
                </div>
                <div class="results">
                    <div class="result form-check">
                        <input class="form-check-input" type="checkbox" name="result_ingr[]" id="result1">
                        <label class="form-check-label" for="result1">data</label>
                    </div>
                </div>
                <div class="container_ingr"></div>
            </div>
        </div>
        <div>
            <label for="keyword" class="form-label">Keywords:</label>
            <input type="text" name="keyword" class="form-control" id="keyword">
        </div>
        <button type="submit" name="filter" class="btn btn-primary">Filter</button>
    </form>
    </div>


    <div class="row">
    <?php foreach ($results as $recipes) : ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card">
            <div class="img-container">
                <img alt="Picture of the recipe" class="card-img-top" src="<?= $recipes->img ?>">
            </div>
                <div class="card-body">
                    <h2 class="card-title"><?= $recipes->recipe_name ?></h2>
                    <span class="subtitle"><b><p>Ingredients:</b> <?= $recipes->ingredient_name?></span>
                    <span class="subtitle"><b><p>Cooking time:</b> <?= $recipes->cookingTime?></span>
                    <div class="card-text"><?= $recipes->recipeText?></div>
                    <span class="subtitle"><a class="btn btn-primary" href="recipe_list.php?add=<?=$recipes->id?>">add</a></span>
                    <div class="card-footer"><b><p>Restriction:</b> <?= $recipes->restriction?></div>
                </div>
            </div>
        </div>
    <?php endforeach?>
</div>



        <div class="container">
            <div class="modal fade" id="modalPopup">   
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header"><h1>Your basket</h1></div>
                    <div class="modal-body">
                        <form action="recipe_list.php" method="GET">
                        <table class="table">
                        <thead>
                            <tr>
                            <th>Recipe ID</th>
                            <th>Recipe Name</th>
                            <th>Image</th>
                            <th> Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($basket as $recipe) : ?>
                            <tr>
                            <td><?= $recipe->id ?></td>
                            <td><?= $recipe->recipe_name ?></td>
                            <td><img alt="Picture of the recipe" src="<?= $recipe->img ?>"></td>
                            <td><?= $quantity[$recipe->id]?></td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cart_close_btn" data-dismiss="modal">Close</button>
                        <button type="submit" name="buy_btn" class="buy_btn" data-dismiss="modal">Buy</button>
                            </form>
                    </div>
                    </div>
                </div>
                </div>


    

    </body>

</html>