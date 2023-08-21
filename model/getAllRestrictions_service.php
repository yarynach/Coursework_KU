<?php

header('Content-Type: application/json');
require_once("dataAccess.php");
require_once("recipe.php");

  $restrictions = getAllRestrictions();
  echo json_encode($restrictions);




?>