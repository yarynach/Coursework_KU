<?php

require_once("../model/dataAccess.php");
require_once("../model/User.php");
session_start();
$errors=0;
if(isset($_REQUEST['register_btn'])){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $password1 = $_REQUEST['password1'];
if(empty($username)||checkUsername($username)==0){ 
    $errors++;
}
if(empty($password)){
    $errors++;
}
if(empty($password1)){
    $errors++;
}
if($password!=$password1){
    $errors;
}

if ($errors==0){
    $user_type='user';
    $user = new User;
    $user->createUser($username,$user_type,$password);
    $user->id=addUser($user);
    $_SESSION['user']=get_object_vars($user);
    $_SESSION['user']['user_type']=$user->user_type;
    $_SESSION['user']['id'] = $user->id;
    header('location:recipe_list.php');
}
else{
    header('location:registration_controller.php');
}
}

require_once("../view/registration_view.php");
?>