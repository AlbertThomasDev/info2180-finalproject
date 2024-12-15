<?php
session_start();
require_once 'includes/db.php';

if ($_SESSION['role'] _= 'admin') {
    header("Location: dashboard.php");
    exit;
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstname = filter_var(trim($_POST['firstname']), FILTER_SANITIZE_STRING);
    $lastname = filter_var(trim($_POST['lastname']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $error = "";
    if ($email === false) {
        $error = "Invalid Email Format!";
    } else if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[A-Z]/', $password) || strlen($password) < 8){
            $error = "Password should include at least one number, letter, a capital letter, and be at least 8 characters long!";
        }
    
    if (!isset($error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $prep_stmt = $conn->prepare("INSERT INTO firstname, lastname, password, email, role, created_at VALUES ?, ?, ?, ?, ?, NOW()");
        $prep_stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $role);
        
        $prep_stmt->execute();
    }


}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolphin CRM</title>
    <link rel="stylesheet" href="add_user.css">
</head>
<body>
    <div class="add-user-container">
        <h2>Add User</h2>
        <form method="POST" action="add_user.php">
            
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first-name" required placeholder=" Jane">
            </div>

            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name" required placeholder=" Smith">
            </div>
        
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder=" Email Address">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="Member">Member</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            
            <?php if (isset($error)) { ?>
                <div class="error-message">
                    <?php alert($error); ?>  <!-- this is unsafe -->
                </div>
            <?php } ?>
        </form>


    </div>
    <header>
        <p>Copyright © 2024 Dolphin CRM</p>
    </header>
</body>
</html>