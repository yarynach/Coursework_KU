<?php
require_once("../model/recipe.php");
require_once("../model/dataAccess.php");

session_start();

if(isset($_REQUEST["buy_btn"])&&(isset($_SESSION['user']))&&!(empty($_SESSION['basket']))){
    header("location:../controller/order.php");

}
else if((!isset($_SESSION['user'])) && (isset($_REQUEST["buy_btn"]))&&!(empty($_SESSION['basket'])) ){
    header("location:../view/restricted.php");
}


if(isset($_REQUEST['logout_btn'])){
    if(!isset($_SESSION['user'])){
        header("location:../controller/login_controller.php");
    }else{
        session_destroy();
        unset($_SESSION['user']);
        header("location: login_controller.php");
    }

}


if(isset($_REQUEST["searchname"]) && $_REQUEST["searchname"] != ""){
    $name=$_REQUEST["searchname"];
    $results=getRecipeByName($name);
}
else if(isset($_REQUEST["filter"])){
    $restr=array();
    $ingr=array();
    $time;
    $keyword;
    if (isset($_REQUEST["restr"])){
    $restr=$_REQUEST["restr"];
    }
    if (isset($_REQUEST["added_ingr"])){
    $ingr=$_REQUEST["added_ingr"];
    }
    if (isset($_REQUEST["time"])){
        $time=$_REQUEST["time"];
    }
    if (isset($_REQUEST["keyword"])){
        $keyword=$_REQUEST["keyword"];
    }

    $results=getByFilters($restr,$ingr,$time,$keyword);

    $restrictions= getAllRestrictions();
} 
else{
$results = getAllRecipes();
$restrictions= getAllRestrictions();


}

if (!isset($_SESSION["basket"]))
{
    $_SESSION["basket"] = [];
}

$basket = $_SESSION["basket"];

$quantity = array();
if (!empty($basket)) {
    foreach ($basket as $recipe) {
        $quantity[$recipe->id] = $_SESSION["quantity"][$recipe->id];
    }
}

if (isset($_REQUEST["add"]))
{

    $addedRecipeId = $_REQUEST["add"];
    $addedRecipe = getRecipeById($addedRecipeId);

    if(in_array($addedRecipe,$basket)){
        $quantity[$addedRecipe->id]+=1;
    }else{
        $quantity[$addedRecipe->id]=1;
        $basket[] = $addedRecipe;

    }
    $_SESSION["basket"] = $basket;
    $_SESSION["quantity"] = $quantity;
}




require_once("../view/recipe_view.php");

?>