<?php

error_reporting(0);
require_once("../model/User.php");
require_once("../model/dataAccess.php");
session_start();

$errors=0;

if(isset($_REQUEST['login_btn'])){
    if(isset($_REQUEST['username']))
    $username=$_REQUEST['username'];
    $password=$_REQUEST['password'];
    login($username,$password);
}

function login($username,$password){
    $errors=0;
    if(empty($username)){ //перевірити чи ще не існує
        $errors++;
    }
    if(empty($password)){
        $errors++;
    }
    if($errors==0){
        $user= getUser($username,$password);
        if ($user->user_type=='admin'){

            $_SESSION['user']=get_object_vars($user);
            $_SESSION['user']['user_type'] = 'admin';
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['success']  = "You are now logged in";
    
            header('location:adminPage_controller.php');
        }
        else if($user->user_type=='user'){
            $_SESSION['user']=get_object_vars($user);
            $_SESSION['user']['user_type'] = 'user';
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['success']  = "You are now logged in";
    
            header('location:recipe_list.php');
        }
        else{
        }
    }
}


require_once("../view/login_view.php");

?>
