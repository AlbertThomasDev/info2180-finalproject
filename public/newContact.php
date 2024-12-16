<?php
session_start();
include_once '../includes/db.php';
include_once '../models/contact.php';
include_once '../models/user.php';
// use models\Contact;
// use models\User;

Contact::setConnection($conn);
User::setConnection($conn);
User::getAllUsers();
$users = User::getUsers();

//$signupCheck = $_GET['signup'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $assignedTo = filter_input(INPUT_POST, "assignedTo", FILTER_SANITIZE_NUMBER_INT);

    $emailcheck = !Contact::emailCheck($email);
    $telval = Contact::ValidateTelephone($telephone);

    /*if($title && $firstName && $lastName && $email && $telephone && $company && $type && $assignedTo) {
        if(!Contact::emailCheck($email) && !Contact::telcheck($telephone) && $telval){
            Contact::addContact($title, $firstName, $lastName, $email, $telephone, $company, $type, $assignedTo, $_SESSION['user_id']);
*/

    if($title && $firstName && $lastName && $email && $telephone && $company && $type && $assignedTo) {
        if(empty($title)||empty($firstName)||empty($lastName)||empty($email)||empty($telephone)||empty($company)||empty($type)||empty($assignedTo)){
            header("Location: ../newContact.php?signup=empty");
            exit();
        }
        else{
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                header("Location: ../newContact.php?signup=email");
                exit();
            }
            else{
                if(!$telval){
                    header("Location: ../newContact.php?signup=telval");
                    exit();
                }
                else{
                    if(!$telephoneDoesntExist){
                    header("Location: ../newContact.php?signup=telexist");
                    exit();
                    }
                    else{
                        if(!$emailcheck){
                        header("Location: ../newContact.php?signup=emailexist");
                        exit(); 
                        }
                        else{
                        header("Location: ../newContact.php?signup=success");
                        exit();
                        }
                    }
                }
            }
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
                        <input type="text" id="telephone" name="telephone" placeholder="Enter Telephone" required>
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
                        <label for="assignedTo">Assigned To</label>
                        <select id="assignedTo" name="assignedTo" required>
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
                            exit();
                        }
                        elseif($signupCheck == 'email'){
                            echo "<p class='error'>You entered an Invalid email.</p>";
                            exit();
                        }
                        elseif($signupCheck == 'telval'){
                            echo "<p class='error'>Incorrect telephone format.</p>";
                            exit();
                        }
                        elseif($signupCheck == 'telexist'){
                            echo "<p class='error'>Someone with this number already exists.</p>";
                            exit();
                        }
                        elseif($signupCheck == 'emailexist'){
                            echo "<p class='error'>Someone with this email already exists.</p>";
                            exit();
                        }
                        if($signupCheck == 'success'){
                            echo "<p class='success'>Contact Created!</p>";
                            exit();
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