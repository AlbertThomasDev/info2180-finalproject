<?php

class User{
    
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    private $role;
    private $created_at;
    private static $users = [];
     
     

}
?>