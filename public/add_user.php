<?php
session_start();
require_once '../includes/db.php';
require_once '../models/user.php';

// if ($_SESSION['role'] == 'admin') {
//     header("Location: dashboard.php");
//     exit;
// }else


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstname = filter_var(trim($_POST['first-name']), FILTER_SANITIZE_STRING);
    $lastname = filter_var(trim($_POST['last-name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $error = "";
    if ($email === false) {
        $error = "Invalid Email Format!";
    }
    
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[A-Z]/', $password) || strlen($password) < 8){
            $error = "Password should include at least one number, letter, a capital letter, and be at least 8 characters long!";
        }
    
        if (empty($error)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                $prep_stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, password, email, role, created_at) 
                                            VALUES (?, ?, ?, ?, ?, NOW())");
                $prep_stmt->bindParam(1, $firstname, PDO::PARAM_STR);
                $prep_stmt->bindParam(2, $lastname, PDO::PARAM_STR);
                $prep_stmt->bindParam(3, $hashed_password, PDO::PARAM_STR);
                $prep_stmt->bindParam(4, $email, PDO::PARAM_STR);
                $prep_stmt->bindParam(5, $role, PDO::PARAM_STR);
    
                if ($prep_stmt->execute()) {
                    // Redirect to a success page or dashboard
                    header("Location: ../public/Home.php");
                    exit;
                } else {
                    $error = "Error inserting user.";
                }
            } catch (PDOException $e) {
                $error = "Database Error: " . $e->getMessage();
            }
        }
    
        if (!empty($error)) {
            echo "<p style='color: red;'>$error</p>";
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
                <button type="submit">Submit</button>
            </div>
            
            <?php if (isset($error)) { ?>
                <div class="error-message">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php } ?>
        </form>


    </div>
    <header>
        <p>Copyright © 2024 Dolphin CRM</p>
    </header>
</body>
</html>