<?php
session_start();
include_once '../includes/db.php';
include_once '../models/contact.php';
include_once '../models/user.php';
use models\Contact;
use models\User;

Contact::setConnection($conn);
User::setConnection($conn);
User::getAllUsers();
$users = User::getUsers();

//$signupCheck = $_GET['signup'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_SPECIAL_CHARS);
    $company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
    $assigned_to = filter_input(INPUT_POST, 'assigned_to', FILTER_SANITIZE_NUMBER_INT);

    $emailCheck = !Contact::emailCheck($email);
    $telVal = Contact::ValidateTelephone($telephone);
    $telephoneCheck = !Contact::telcheck($telephone);

    if (!$title || !$firstName || !$lastName || !$email || !$telephone || !$company || !$type || !$assigned_to) {
        header("Location: newContact.php?signup=empty");
        exit();
    } elseif (!$email) {
        header("Location: newContact.php?signup=email");
        exit();
    } elseif (!$telVal) {
        header("Location: newContact.php?signup=telval");
        exit();
    } elseif (!$telephoneCheck) {
        header("Location: newContact.php?signup=telexist");
        exit();
    } elseif (!$emailCheck) {
        header("Location: newContact.php?signup=emailexist");
        exit();
    } else {
        if (Contact::addcontact($title, $firstName, $lastName, $email, $telephone, $company, $type, $assigned_to, $_SESSION['user_id'])) {
            header("Location: newContact.php?signup=success");
            exit();
        } else {
            echo "<p class='error'>Error saving contact. Please try again.</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New user</title>
    <link rel="stylesheet" href="contact_style.css">
</head>
<body>
<div class="form-body">
    <div class="right">
        <br><br>
        <h1>New Contact</h1><br>
        <div class="login">

            <form id="contactForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                <!-- Title -->
                <div class="formselect">
                    <label for="title">Title</label>
                    <select id="title" name="title" required>
                        <option value="Mr.">Mr.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Prof.">Prof.</option>
                    </select>
                </div>

                <!-- First Column: First and Last Name -->
                <div class="info">
                    <div class="usercontent">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" required>
                    </div>
                    <div class="usercontentadd">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                    </div>
                </div>

                <!-- Second Column: Email and Telephone -->
                <div class="info">
                    <div class="usercontent">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="usercontent">
                        <label for="telephone">Telephone</label>
                        <input type="text" id="telephone" name="telephone" placeholder="Tel: (123)-456-7890 or 456-7890" required>
                    </div>
                </div>

                <!-- Third Column: Company and Type -->
                <div class="info">
                    <div class="usercontent">
                        <label for="company">Company</label>
                        <input type="text" id="company" name="company" placeholder="Enter Company Name" required>
                    </div>
                    <div class="usercontent">
                        <label for="type">Type</label>
                        <select id="type" name="type" required>
                            <option value="Sales Lead">Sales Lead</option>
                            <option value="Support">Support</option>
                        </select>
                    </div>
                </div>

                <!-- Assigned To -->
                <div class="info assigned-row">
                    <div class="usercontent">
                        <label for="assigned_to">Assigned To</label>
                        <select id="assigned_to" name="assigned_to" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo htmlspecialchars($user->getId()); ?>">
                                    <?php echo htmlspecialchars($user->getFName()) . ' ' . htmlspecialchars($user->getLName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="info">
                    <div class="usercontent-buttonadd">
                        <button type="submit" value="submit">Save</button>
                    </div>
                    <?php 
                    if(!isset($_GET['signup'])){
                        exit();
                    }
                    else{
                        $signupCheck = $_GET['signup'];

                        if($signupCheck == 'empty'){
                            echo "<p class='error'>You did not fill in all the fields.</p>";
                        }
                        elseif($signupCheck == 'email'){
                            echo "<p class='error'>You entered an Invalid email.</p>";
                        }
                        elseif($signupCheck == 'telval'){
                            echo "<p class='error'>Incorrect telephone format.</p>";
                        }
                        elseif($signupCheck == 'telexist'){
                            echo "<p class='error'>Someone with this number already exists.</p>";
                        }
                        elseif($signupCheck == 'emailexist'){
                            echo "<p class='error'>Someone with this email already exists.</p>";
                        }
                        if($signupCheck == 'success'){
                            echo "<p class='success'>Contact Created!</p>";
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

