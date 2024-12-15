<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="user_login.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
    <div class="login-container">
        <h2>User Login</h2>

        <!-- Login Form -->
        <form method="POST" action="login.php">
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