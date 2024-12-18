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

use models\Contact;
//use Notes;
Contact::setConnection($conn);
Notes::setConnection($conn);
global $contact_id, $contact,$updated;

if (isset($_GET['id'])) {
    $contact_id = intval($_GET['id']);
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
Notes::getAllNotes(); // Load all notes
$notes = array_filter(Notes::getNotes(), function ($note) use ($contact_id) {
    return $note->getContactId() == $contact_id;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <?php if($contact): ?>
            <h1><?php echo htmlspecialchars($contact->getTitle()) . ' ' . htmlspecialchars($contact->getFirstName()) . ' ' . htmlspecialchars($contact->getLastName()); ?></h1>
            <h3>Created on <?php echo htmlspecialchars($contact->getCreatedAt()) . htmlspecialchars($contact->getCreatedBy())?></h3>
            <h3>Updated on <?php echo htmlspecialchars($contact->getUpdatedAt())?></h3>
            <div>
                <button class="assignbutton">Assign to me</button>
                <script>
document.querySelectorAll('.assignbutton').addEventListener('click', function () {
    const contactId = this.dataset.contactId;
s
    // Send the request to assign the contact
    fetch('assignContact.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ contact_id: contactId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Contact assigned to you successfully!');
            location.reload(); // Reload to reflect the changes
        } else {
            alert('Failed to assign the contact: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while assigning the contact.');
    });
});
</script>
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
                    <td><strong>Email:</strong></td>
                    <td><?php echo htmlspecialchars($contact->getEmail()); ?></td>
                </tr>
                <tr>
                    <td><strong>Telephone:</strong></td>
                    <td><?php echo htmlspecialchars($contact->getTelephone()); ?></td>
                </tr>
                <tr>
                    <td><strong>Company:</strong></td>
                    <td><?php echo htmlspecialchars($contact->getCompany()); ?></td>
                </tr>
                <tr>
                    <td><strong>Assigned To:</strong></td>
                    <td><?php echo htmlspecialchars($contact->getAssignedTo()); ?></td>
                </tr>
            </table>
            <?php endif; ?>
        </div>

        <div class="notes">
            <h2>Notes</h2>
            <?php if (!empty($notes)): ?>
                <?php foreach($notes as $note): ?>
            <div class="note"> 
                <p><strong><?php echo htmlspecialchars($note->getCreatedBy()); ?></strong></p>
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
                <button class="addnotebtn">Add Note</button>
            </div>
        </div>
    </div>
</body>
</html>


