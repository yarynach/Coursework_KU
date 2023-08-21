<?php
require_once("../model/recipe.php");
require_once("../model/dataAccess.php");

session_start();

if ((isset($_REQUEST['order_btn'])) && ($_REQUEST["name"]!="")&& ($_REQUEST["address"]!="")&& ($_REQUEST["email"]!="")){
    $name=$_REQUEST['name'];
    $address=$_REQUEST['address'];
    $email=$_REQUEST['email'];
    $id=$_SESSION['user']['id'];
    $order_id=addOrder($id,$name,$address,$email);
    addOrderDetail($order_id,$_SESSION['quantity']);
    unset($_SESSION['basket']);
}



require_once("../view/order_view.php");
?>
