<?php

header('Content-Type: application/json');
require_once("dataAccess.php");
require_once("recipe.php");

if (!isset($_REQUEST["ingredient_name"]))
{
  echo json_encode([]);
}
else {
  $names =  getIngredientByStart($_REQUEST["ingredient_name"]);
  echo json_encode($names);
}



?>