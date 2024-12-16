<?php
namespace models;
require_once '../includes/db.php';
use PDO;
use PDOException;

class Contact {
    private int $id;
    private string $title;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $telephone;
    private string $company;
    private string $type;
    private int $assigned_to;
    private int $created_by;
    private string $created_at;
    private string $updated_at;
    private static array $contacts = [];
    private static $conn;

    public function __construct($id, $title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by, $created_at, $updated_at) {
        $this->id = $id;
        $this->title = $title;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->company = $company;
        $this->type = $type;
        $this->assigned_to = $assigned_to;
        $this->created_by = $created_by;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }

    public static function ValidateTelephone($telephone): bool {
        return preg_match("/^\(\d{3}\)-\d{3}-\d{4}$|^\d{3}-\d{4}$/", $telephone);
    }

    public static function addcontact($title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by): bool {
        try {
            $stmt = self::$conn->prepare("
                INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at) 
                VALUES (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by, :created_at, :updated_at)
            ");

            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            $stmt->execute([
                ':title' => $title,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':telephone' => $telephone,
                ':company' => $company,
                ':type' => $type,
                ':assigned_to' => $assigned_to,
                ':created_by' => $created_by,
                ':created_at' => $created_at,
                ':updated_at' => $updated_at
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public static function emailCheck($email): bool {
        $stmt = self::$conn->prepare("SELECT id FROM Contacts WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }

    public static function telcheck($telephone): bool {
        $stmt = self::$conn->prepare("SELECT id FROM Contacts WHERE telephone = :telephone");
        $stmt->execute([':telephone' => $telephone]);
        return $stmt->fetch() !== false;
    }
}
?>