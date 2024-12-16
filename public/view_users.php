<?php
session_start();
require_once '../includes/db.php';
require_once '../models/user.php';

User::setConnection($conn);
User::getAllUsers();
$users = User::getUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="styles.css"> <!-- Reference to the external CSS file -->
</head>
<body>
    <h1>Users List</h1>
    <button class="add-btn" id="addUserBtn">
        <span class="material-symbols-outlined">&#xe145;</span> Add User
    </button>
    <table class="user-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user->getLName() . ' ' . $user->getFName()); ?></td>
                        <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                        <td><?php echo htmlspecialchars($user->getRole()); ?></td>
                        <td><?php echo htmlspecialchars($user->getCreatedAt()); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>











