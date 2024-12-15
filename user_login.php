<?php
session_start();
require_once 'includes/db.php';
require_once 'models/user.php';


$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($email === false) {
        $error = "Invalid Email Format!";
    } else {
        $prep_stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
        $prep_stmt->bind_param("s", $email);
        $prep_stmt->execute();
        $prep_stmt->store_result();


        if ($prep_stmt->num_rows > 0) {
            $prep_stmt->bind_result($user_id,$firstname, $lastname, $user_stored_password, $email,  $role, $created_at);
            $prep_stmt->fetch();
            
            
            if (password_verify($password, $user_stored_password)) {
                
                $loggedInUser = new User($user_id, $firstname, $lastname, $email, $role, $created_at);
                // $loggedInUser = new User($user['id'], $user['firstname'], $user['lastname'], $user['email'], $user['role'], $user['created_at']);
                
                $_SESSION['user_id'] = $loggedInUser->getId();
                $_SESSION['firstname'] = $loggedInUser->getFname();
                $_SESSION['lastname'] = $loggedInUser->getLname();
                $_SESSION['email'] = $loggedInUser->getEmail();
                $_SESSION['role'] = $role;


                header("Location: public/Home.php");
                exit;
            } else {
                $error = "Incorrect Password!";
            }
        } else {
            $error = "No user found with this Email!";
        }
        $prep_stmt->close();
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