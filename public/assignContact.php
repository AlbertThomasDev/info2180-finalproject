<?php
session_start();
require_once '../models/contact.php';
require_once '../includes/db.php';

use models\Contact;

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$currentUserId = $_SESSION['user_id'];

// Get the contact ID from the request
$data = json_decode(file_get_contents('php://input'), true);
$contactId = intval($data['contact_id'] ?? 0);

if ($contactId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
    exit;
}

// Set up the database connection
Contact::setConnection($conn);

try {
    // Update the assigned_to field for the contact
    $success = Contact::updateContact($contactId, $currentUserId);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to assign contact']);
    }
} catch (Exception $e) {
    error_log('Error assigning contact: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}
?>