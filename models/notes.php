<?php

class Notes{
    private static $conn;
    private $id;
    private $contact_id;
    private $comment;
    private $created_by;
    private $created_at;
    private static $notes = [];

    public function __construct($id, $contact_id, $comment, $created_by, $created_at){
        $this->id = $id;
        $this->contact_id = $contact_id;
        $this->comment = $comment;
        $this->created_by = $created_by;
        $this->created_at = $created_at;

        if (!self::noteExists($id)) {
            self::$notes[$id] = $this;
        }
    }

    public static function noteExists($id):bool {
        return isset(self::$notes[$id]);
    }

    public function getId() {
        return $this->id;
    }

    public function getContactId() {
        return $this->contact_id;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getCreatedBy() {
        return $this->created_by;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getCreatedAtFormatted():string {
        $timestamp = strtotime($this->getCreatedAt());
        return date('F j, Y \a\t g:ia', $timestamp);
    }

    public static function setConnection($conn){
        self::$conn = $conn;
    }

    private static function clearNotes() {
        self::$notes = [];
    }

    public static function getNotes():array {
        return self::$notes;
    }

    public static function getNoteById($id) {
        if (isset(self::$notes[$id])) {
            return self::$notes[$id];
        }

        return null;
    }

    public static function getAllNotes() {
        $stmt = self::$conn->prepare("SELECT * FROM Notes");
        $stmt -> execute();
        $Notes = $stmt->fetchAll(PDO::FETCH_ASSOC);


            foreach ($Notes as $note) {
                new Notes ($note['id'],
                    $note['contact_id'],
                    $note['comment'],
                    $note['created_by'],
                    $note['created_at']
                );
            }
        }
    

    public static function addNote($contact_id, $comment, $created_by):bool {
        try{
        $stmt = self::$conn->prepare("
        INSERT INTO Notes (contact_id, comment, created_by, created_at) VALUES (:contact_id, :comment, :created_by, :created_at)");
        $created_at = date('Y-m-d H:i:s');

        $stmt->execute([
            ':contact_id'=> $contact_id,
            ':comment'=> $comment,
            ':created_by'=>$created_by,
            ':created_at'=>$created_at
        ]);
        return true;     
    }catch (PDOException $e){
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}


    // public static function getNotesByContactId($contact_id): array{
    //     $stmt = self::$conn->prepare("SELECT * FROM Notes WHERE contact_id = ?");
    //     $stmt-> execute();
    //     $Notes =
    //     mysqli_stmt_bind_param($stmt, 'i', $contact_id);
    //     mysqli_stmt_execute($stmt);
    //     $result = mysqli_stmt_get_result($stmt);

    //     $notes = [];
    //     while ($note = mysqli_fetch_assoc($result)) {
    //         $newNote =  new Notes ($note['id'],
    //                     $note['contact_id'],
    //                     $note['comment'],
    //                     $note['created_by'],
    //                     $note['created_at']
    //                 );

    //         $notes[$newNote->getId()] = $newNote;
    //     }

    //     return $notes;
    // }

}
