<?php
session_start();


if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}


// $error = '';
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Sanitize and validate inputs
//     $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
//     $password = $_POST['password'];
//     // $role = $_POST['role'];

//     // Validate email format
//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $error = "Invalid email format!";
//     }

//     // Validate password
//     if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[A-Z]/', $password) || strlen($password) < 8) {
//         $error = "Password must have at least one number, one letter, one capital letter, and be at least 8 characters long!";
//     }

//     if (!isset($error)) {
//         // Hash the password
//         $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//         // Insert user into database
//         $stmt = $conn->prepare("INSERT INTO Users (firstname, lastname, password, email, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
//         $stmt->bind_param("sssss", $firstname, $lastname, $hashed_password, $email, $role);
        
//         if ($stmt->execute()) {
//             $success = "User added successfully!";
//         } else {
//             $error = "Error adding user!";
//         }
//     }
// }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="user_login.css">
</head>
<body>
    <div class="login-container">
        <h2>User Login</h2>
        <form method="POST" action="user_login.php">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
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

        <!-- Link to registration page for users who don't have an account -->
        <!-- You can enable this if you decide to add a registration feature later -->
        <!-- <p><a href="register.php">Create an Account</a></p> -->
    </div>

</body>
</html>