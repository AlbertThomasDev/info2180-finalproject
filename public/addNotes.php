<?php
session_start();
require_once '../models/contact.php';
require_once '../models/notes.php';
require_once '../includes/db.php';

use models\Notes;

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
}

if (isset($_SESSION['contactid']) && !empty($_SESSION['contactid'])) {
    $contactId1 = $_SESSION['contactid'];
}

if ($contactId1 <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid contact ID.']);
    exit;
}

$comment = $_POST['comment'] ?? '';
$created_by = $_SESSION['user_id'];  // Assuming user name is in the session

Notes::setConnection($conn);

    if ($contactId1 > 0 && !empty($comment)) {
        // Call the addNote method
        $result = Notes::addNote($contactId1, $comment, $created_by);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Note added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add note.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid contact ID or comment.']);
    }

?>

