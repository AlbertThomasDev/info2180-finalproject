<?php
session_start();
require_once 'includes/db.php';
require_once 'models/user.php';
// use PDO;
// use models\User;


$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($email === false) {
        $error = "Invalid Email Format!";
    } else {
        // Prepare the SQL statement
        $prep_stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
        $prep_stmt->bindParam(1, $email, PDO::PARAM_STR);
        $prep_stmt->execute();
    
        // Fetch the user data
        $user = $prep_stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            // Extract user data
            $user_id = $user['id'];
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $user_stored_password = $user['password'];
            $email = $user['email'];
            $role = $user['role'];
            $created_at = $user['created_at'];
    
            // Verify the password
            if (password_verify($password, $user_stored_password)) {
                // Create User object
                $loggedInUser = new User($user_id, $firstname, $lastname, $email, $role, $created_at);
                
                // Store user information in the session
                $_SESSION['user_id'] = $loggedInUser->getId();
                $_SESSION['firstname'] = $loggedInUser->getFname();
                $_SESSION['lastname'] = $loggedInUser->getLname();
                $_SESSION['email'] = $loggedInUser->getEmail();
                $_SESSION['role'] = $role;
    
                // Redirect to the Home page
                header("Location: public/Home.php");
                exit;
            } else {
                $error = "Incorrect Password!";
            }
        } else {
            $error = "No user found with this Email!";
        }
    }


    
    

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolphin CRM</title>
    <link rel="stylesheet" href="user_login.css">
</head>
<body>
    <header>
        <p>🐬Dolphin CRM</p>
    </header>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="user_login.php">
            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder=" Email Address">
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder=" Password">
            </div>

            <div class="form-group">
                <button type="submit">Login</button>
            </div>

            <?php if (isset($error)) { ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
        </form>


    </div>
    <header>
        <p>Copyright © 2024 Dolphin CRM</p>
    </header>
</body>
</html>