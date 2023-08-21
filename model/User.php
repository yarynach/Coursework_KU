<?php

class User{
    private $id;
    private $username;
    private $user_type;
    private $password;


    function createUser($username,$user_type,$password){
        $this->username=$username;
        $this->user_type=$user_type;
        $this->password=$password;
    }

    function __get($name){
        return $this->$name;
    }
    function __set($name,$value){
        $this->$name = $value;
    }


}


?>