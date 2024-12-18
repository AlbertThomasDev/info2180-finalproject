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

    public static function contactExists($id): bool{
        return isset(self::$contacts[$id]);
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getCompany() {
        return $this->company;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type):void{
        $this->type = $type;
    }

    public function getAssignedTo() {
        return $this->assigned_to;
    }

    public function setAssignedTo($assigned_to):void{
        $this->assigned_to = $assigned_to;
    }

    public function getCreatedBy() {
        return $this->created_by;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setCreatedat():string{
        $time = strtotime($this->getCreatedAt());
        return date('F j, Y', $time);
    }

    public function setUpdateat():string{
        $time = strtotime($this->getUpdatedAt());
        return date('F j, Y', $time);
    }

    public static function ValidateTelephone($telephone): bool {
        return preg_match("/^\(\d{3}\)-\d{3}-\d{4}$|^\d{3}-\d{4}$/", $telephone);
    }

    public static function getContacts(): array
    {
        return self::$contacts;
    }

    // public static function getContactById($id) {
    //     if ($id == $_GET['id']) {
    //         return self::$contacts[$id];
    //     }
    //     return null;
    // }

    public static function getContactById($id) {
        try {
            $stmt = self::$conn->prepare("SELECT * FROM Contacts WHERE id = :id");
    
            // Bind the parameter to the placeholder
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Execute the query
            $stmt->execute();
    
            // Debug SQL errors
            if ($stmt->errorCode() !== '00000') {
                var_dump($stmt->errorInfo());
                return null;
            }
    
            // Fetch the result as an associative array
            $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($contact) {
                return new Contact(
                    $contact['id'],
                    $contact['title'],
                    $contact['firstname'],
                    $contact['lastname'],
                    $contact['email'],
                    $contact['telephone'],
                    $contact['company'],
                    $contact['type'],
                    $contact['assigned_to'],
                    $contact['created_by'],
                    $contact['created_at'],
                    $contact['updated_at']
                );
            }
    
            // No contact found
            echo "No contact found with ID: " . htmlspecialchars($id);
            return null;
    
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return null;
        }
    }

    private static function clearContacts() {
        self::$contacts = [];
    }

    public static function getAllcontacts(){
        $stmt = self::$conn->prepare("SELECT * FROM contacts");
        $stmt -> execute();
        $Contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($Contacts as $contact) {
            self::$contacts[$contact['id']] = new Contact(
                $contact['id'],
                $contact['title'],
                $contact['firstname'],
                $contact['lastname'],
                $contact['email'],
                $contact['telephone'],
                $contact['company'],
                $contact['type'],
                $contact['assigned_to'],
                $contact['created_by'],
                $contact['created_at'],
                $contact['updated_at']
            );
        }
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

    public function update($type, $assigned_to): bool {
        $this->setType($type);
        $this->setAssignedTo($assigned_to);
        $id = $this->getId();
    
        try {
            $stmt = self::$conn->prepare(
                "UPDATE Contacts SET type = :type, assigned_to = :assigned_to, updated_at = NOW() WHERE id = :id"
            );
    
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':assigned_to', $assigned_to, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception as needed, e.g., log the error or rethrow it
            error_log('Update failed: ' . $e->getMessage());
            return false;
        }
    }
    

    public static function updateContact($id, $assigned_to): bool {
        try {
            $query = "UPDATE Contacts SET assigned_to = :assigned_to, updated_at = NOW() WHERE id = :id";
            $stmt = self::$conn->prepare($query);
    
            $stmt->bindParam(':assigned_to', $assigned_to, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Update failed: ' . $e->getMessage());
            return false;
        }
    }

    
}
?>
