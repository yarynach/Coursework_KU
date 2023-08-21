<!doctype html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../view/style.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="../view/clientcode.js"></script>
        <script type="text/javascript" src="../view/adding_view.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <script  defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
        <title>Admin page</title>
    <head>
    <body>
            <nav   class="navbar top navbar-expand-lg navbar-light" style="background-color: #93b886">
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
                        <li class="nav-item active"><a href="adminPage_controller.php" class="nav-link">Admin page</a></li>
                        <li class="nav-item active"><form>
                                <button  class="btn btn-danger"type="submit" name="logout_btn">Logout</button>
                        </form></li>
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
                    <button type="button" class="btn btn-dark" id="add_btn">Add recipe</button>

                </div>
            </nav>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Recipe ID</th>
                <th>Recipe Name</th>
                <th>Dietory restriction</th>
                <th>Ingredients</th>
                <th>Cooking time</th>
                <th>Recipe text</th>
                <th>Image</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <?php foreach ($results as $recipes) : ?>
                <td ><div class="id"><?= $recipes->id ?></div></td>
                <td  ><?= $recipes->recipe_name ?></td>
                <td ><?=$recipes->restriction?></td>
                <td ><?= $recipes->ingredient_name?></td>
                <td><?= $recipes->cookingTime?></td>
                <td ><?= $recipes->recipeText?></td>
                <td ><img alt="Picture of the recipe" src="<?= $recipes->img ?>"></td>
                <td ><button class="update_btn" id="update_btn" name="update_btn">Update</button></td>
            </tr>
            <?php endforeach?>
            </tbody>
        </table>
        </div>
   
        <div class="container">
            <div class="modal fade" id="modalPopupUpd">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header"><h1>Update recipe</h1></div>
                        <div class="modal-body"> 
                            <form class="updateForm" action="../controller/adminPage_controller.php" method="POST">
                            </form>
                            </div>
                        <div class="modal-footer">
                            <button type="button" id="upd_close_btn" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>


        <div class="container">
            <div class="modal fade" id="modalPopupAdd">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header"><h1>Add recipe</h1></div>
                        <div class="modal-body"> 
                        <form  method="post"  action="../controller/adminPage_controller.php">
                            <p>Name of recipe
                            <input name = "recipe_name"/>
                            <p>Dietory restriction
                                <?php foreach($restrictions as $restr) :?>
                                    <input type="checkbox" name="restr[]" value="<?=$restr; ?>"/><?=$restr; ?>
                                <?php endforeach?>    
                            <p>Cooking time
                            <input name = "time"/>
                            <div class="add_ingr">
                                <div>
                                <p>Ingredient
                                <input name = "ingr[]" type="text"/>
                                </div>
                            </div>
                            
                            <button type = "button" class="add_item">Add new ingredient</button>
                            <p>Recipe text
                            <textarea name="text"></textarea>
                            <div>
                            Add photo:
                            <input  name="img">
                            </div>
                            <input type = "submit" name="add_recipe" value="Add!"/>
                        </form>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="add_close_btn" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>



    </body>
</html>