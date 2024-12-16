<?php
namespace models;
use PDO;

class User{
    
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    // private $password;
    private $role;
    private $created_at;

    private static array $users = []; 
    
    // Database connection
    private static $conn;
    
    
    
     
    
    public function __construct($id, $firstname, $lastname, $email, $role, $created_at) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        // $this->password = $password;
        $this->role = $role;
        $this->created_at = $created_at;

        if (!self::userIdExists($id)) {
            self::$users[$id] = $this;
        }


     }

    public static function userIdExists($id): bool{
        return isset(self::$users[$id]);
    }

    public function getId() {
        return $this->id;
    }

    public function getFname() {
        return $this->firstname;
    }

    public function getLname() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole():string {
        return $this->role;
    }

    

    // public function getPassword() {
    //     return $this->password;
    // }


    public static function setConnection($conn){
        self::$conn = $conn;
    } 

    private static function clearUsers() {
        self::$users = [];
    }

    public static function getUsers():array {
        return self::$users;
    }

    public static function getAllUsers(){
        $stmt = self::$conn->prepare("SELECT * FROM users");
        $stmt -> execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            self::$users[$user['id']] = new User(
                $user['id'],
                $user['firstname'],
                $user['lastname'],
                $user['email'],
                $user['role'],
                $user['created_at']
            );
        }
    }
}
?>