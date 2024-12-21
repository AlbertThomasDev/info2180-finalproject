<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}
// $userId = $_SESSION['user_id'];

require_once '../models/contact.php';
require_once '../models/notes.php';
require_once '../includes/db.php';
require_once '../models/user.php';

use models\Contact;
use models\Notes;
use models\User;

Contact::setConnection($conn);
Notes::setConnection($conn);
User::setConnection($conn);

global $contact_id, $contact,$updated,$type,$user,$user2;

if (isset($_GET['id'])) {
    $contact_id = intval($_GET['id']);
    $contact_id2 = intval($_GET['id']);
    $_SESSION['contactid'] = $contact_id;
    $_SESSION['contactId'] = $contact_id2;

    $contact = Contact::getContactById($contact_id);

    // $updated = Contact::updateContact($contact_id,$userId);

    if (!$contact) {
        echo "Contact not found.";
        error_log("Contact with ID $contact_id not found.");
        exit;
    }
} else {
    echo "No contact ID provided.";
    error_log("No contact ID provided in GET request.");
    exit;
}

// Fetch associated notes for the contact
 // Load all notes
$notes = Notes::getNotesByContactId($contact_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
    <link rel="stylesheet" href="view_contactdetails.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Cabin:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <?php if($contact): ?>
            <h1><svg width="27px" height="27px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M7 18V17C7 14.2386 9.23858 12 12 12V12C14.7614 12 17 14.2386 17 17V18" stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path><path d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="1.5" stroke-width="1.5"></circle></svg><?php echo htmlspecialchars($contact->getTitle()) . ' ' . htmlspecialchars($contact->getFirstName()) . ' ' . htmlspecialchars($contact->getLastName()); ?></h1>
            <h3>Created on <?php echo htmlspecialchars($contact->getCreatedAt()) . htmlspecialchars($contact->getCreatedBy())?></h3>
            <h3>Updated on <?php echo htmlspecialchars($contact->getUpdatedAt())?></h3>
            <div>
                <button class="assignbutton">Assign to me</button>
                <?php if($contact->getType() == 'Support'):?>
                <button class="switchbutton">Switch to Sales Lead</button>
                <?php else: ?>
                <button class="switchbutton">Switch to Support</button>
                <?php endif; ?>
            </div>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th><strong>Email:</strong></th>
                    <td><?php echo htmlspecialchars($contact->getEmail()); ?></td>
                </tr>
                <tr>
                    <th><strong>Telephone:</strong></th>
                    <td><?php echo htmlspecialchars($contact->getTelephone()); ?></td>
                </tr>
                <tr>
                    <th><strong>Company:</strong></th>
                    <td><?php echo htmlspecialchars($contact->getCompany()); ?></td>
                </tr>
                <tr>
                    <th><strong>Assigned To:</strong></th>
                    <?php $user2 = User::getUserById($contact->getAssignedTo()); ?>
                    <td><?php echo htmlspecialchars($user2->getFname().' '.$user2->getLname()); ?></td>
                </tr>
            </table>
            <?php endif; ?>
        </div>

        <div class="notes">
            <h2><svg width="27px" height="27px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#000000"><path d="M8 14L16 14" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 10L10 10" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 18L12 18" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10 3H6C4.89543 3 4 3.89543 4 5V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V5C20 3.89543 19.1046 3 18 3H14.5M10 3V1M10 3V5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>Notes</h2>
            <?php if (!empty($notes)): ?>
                <?php foreach($notes as $note): ?>
                    <?php $userId = $note->getCreatedBy(); 
                    $user = User::getUserById($userId);
                    ?>

            <div class="note"> 
                <p><strong><?php echo htmlspecialchars($user->getFname().' '.$user->getLname()); ?></strong></p>
                <p><?php echo htmlspecialchars($note->getComment()); ?></p>
                <small><?php echo htmlspecialchars($note->getCreatedAt()); ?></small>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div>
                <h2> Nothing here yet...<h2>
            </div>
            <?php endif; ?>

            <div class="add-note">
                <h3>Add a note about <?php echo htmlspecialchars($contact->getFirstName()); ?> </h3>
                <textarea rows="3" placeholder="Enter details here"></textarea>
                <button class="addnotebtn" >Add Note</button>
            </div>
        </div>
    </div>
</body>
</html>


