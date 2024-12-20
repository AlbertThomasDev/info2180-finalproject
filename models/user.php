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

    public function getCreatedAt() {
        return $this->created_at;
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


    public static function getUserById($id): ?User {
        // Prepare the SQL query
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = self::$conn->prepare($query);
    
        // Bind the parameter using PDO
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // If the user exists, return a User object
        if ($user) {
            return new User(
                $user['id'],
                $user['firstname'],
                $user['lastname'],
                $user['email'],
                $user['role'],
                $user['created_at']
            );
        }
    
        // Return null if no user found
        return null;
    }

        public static function getAllUsers() {
        // Prepare the SQL statement
        $stmt = self::$conn->prepare("SELECT * FROM users");
        $stmt->execute();
        
        // Execute the statement
        /*if (!$stmt->execute()) {
            // Log or handle the error
            throw new Exception("Failed to execute query: " . implode(", ", $stmt->errorInfo()));
        }*/
    
        // Fetch all users as an associative array
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Check if any users were returned
        if (!$users) {
            // Optionally, handle the case where no users are found
            return;
        }else{
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
}
?>