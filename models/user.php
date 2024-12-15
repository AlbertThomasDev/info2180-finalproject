<?php
namespace app\models;

class User{
    
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
     
     // Database connection
     private static $conn;
 
     // Static method to check if credentials are valid
     public static function isValidCredentials($email, $password) {
         // Database connection (simplified example)
         self::$conn = new mysqli("localhost", "root", "", "your_database");
         
         // Check if email exists
         $stmt = self::$conn->prepare("SELECT id, firstname, lastname, email, password FROM users WHERE email = ?");
         $stmt->bind_param("s", $email);
         $stmt->execute();
         $stmt->store_result();
         
         // If no user is found with the given email
         if ($stmt->num_rows == 0) {
             return false;
         }
         
         // Bind the result to variables
         $stmt->bind_result($id, $firstname, $lastname, $email, $hashedPassword);
         $stmt->fetch();
         
         // Check if the password matches
         if (password_verify($password, $hashedPassword)) {
             // If valid, return a user object or user data
             return new User($id, $firstname, $lastname, $email, $hashedPassword);
         } else {
             return false; // Invalid password
         }
     }
     
     // Constructor to initialize the User object
     public function __construct($id, $firstname, $lastname, $email, $password) {
         $this->id = $id;
         $this->firstname = $firstname;
         $this->lastname = $lastname;
         $this->email = $email;
         $this->password = $password;
     }

}
?>