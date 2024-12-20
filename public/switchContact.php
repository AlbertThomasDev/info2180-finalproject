<?php
session_start();
//require_once '../includes/init.php'; // Ensure this includes session and authentication logic
require_once '../models/contact.php'; // Include the Contact model
require_once '../includes/db.php'; // Database connection

use models\Contact;


    // Ensure the user is authenticated
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
        exit;
    }

    // Retrieve contact ID from POST
    $contactId = $_SESSION['contactid'];
    if ($contactId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid contact ID.']);
        exit;
    }

    // Set the database connection in the Contact class
    Contact::setConnection($conn);

    // Fetch the contact by ID
    $contact2 = Contact::getContactById($contactId);

    if (!$contact2) {
        echo json_encode(['success' => false, 'message' => 'Contact not found.']);
        exit;
    }



      // Toggle the contact's type
      $currentType = $contact2->getType();
      $newType = ($currentType === "Sales Lead") ? "Support" : "Sales Lead";
  
      // Update the type in the database
      $updatedType = $contact2->updateType($contactId, $newType);

    if ($updatedType) {
        echo json_encode(['success' => true, 'message' => 'Type reassigned successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to reassign Type.']);
    }
    exit;
?>