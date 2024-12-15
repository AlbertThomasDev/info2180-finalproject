<?php
namespace app\models;
use PDO;

class Contact {

    private int $id;
    private string $title;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $telephone;
    private string $company;
    private string $password;
    private string $type;
    private int $assigned_to;
    private int $created_by;
    private string $created_at;
    private string $updated_at;
    private static array $contacts = [];
     
    // Database connection
    private static $conn;

    public function __construct($id, $title, $firstname, $lastname, $email, $telephone,  $company, $type, $assigned_to, $created_by, $created_at, $updated_at) {
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

        if (!self::contactExists($id)) {
            self::$contacts[$id] = $this;
        }
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

    public static function ValidateTelephone($telephone):bool{
        return preg_match("/^\d{3}-\d{4}$|^(0-9){3}-\d{3}-\d{4}$/",$telephone);

    }

    public static function getAllcontacts(){
        $stmt = self::$conn->prepare("SELECT * FROM contacts");
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

    public static function getContacts(): array
    {
        return self::$contacts;
    }

    public static function getContactById($id) {
        if (isset(self::$contacts[$id])) {
            return self::$contacts[$id];
        }

        return null;
    }


    public static function addcontact($title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by){
        $prep_stmt = self::$conn->prepare("INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()");

        $prep_stmt->bindValue($prep_stmt, 'sssssssii', $title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by);

        $prep_stmt->execute();
    }

    public static function emailCheck($email):bool {
        $stmt = self::$conn->prepare("SELECT * FROM contacts WHERE email = ?");
        $stmt->bindValue('s',$email,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result !== false;
    }

    public static function telcheck($telephone):bool {
        $stmt = self::$conn->prepare("SELECT * FROM contacts WHERE telephone = ?");
        $stmt->bindValue('s',$telephone,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result !== false;
    }



}
?>    