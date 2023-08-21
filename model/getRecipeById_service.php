<?php
header('Content-Type: application/json');
require_once ("recipe.php");
require_once ("dataAccess.php");

if (!isset($_REQUEST["id"]))
{
  echo json_encode([]);
}
else {
  $recipes = getRecipeById($_REQUEST["id"]);
  echo json_encode($recipes);  
}                               
?>