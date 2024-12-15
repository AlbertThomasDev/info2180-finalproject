<?php
session_start();
// require_once 'models/user.php';


if (isset($_SESSION['user_id'])):
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="home.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=home" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=add" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=group" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=logout" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  <title>Home</title>
</head>
<body>
<script src="controlpanel.js" type="text/javascript"></script>
<nav class="sidenav">
  <ul>
    <!-- got to add in icons -->
    <li><a class="side" data-target="Home.php"><span class="material-symbols-outlined">&#xe88a;</span>Home</a></li>
    <li><a class="side" data-target="newContact.php" id="contbutton"><span class="material-symbols-outlined">&#xe853;</span>New Contact</a></li>
    <?php if($_SESSION['role'] === 'admin') { ?>
      <li><a class="side" data-target="add_user.php"><span class="material-symbols-outlined">&#xe7ef;</span>Users</a></li>
    <?php } ?>
    <hr>
    <li><a class="side" data-target="logout.php"><span class="material-symbols-outlined">&#xe9ba;</span>Logout</a></li>
  </ul>
</nav>
<section id="view">
    <div class="table">
        <div class="dashboard-header">
            <h1>Dashboard<h1>

            <button class="contact-btn" id="addContactButton">
              <span class="material-symbols-outlined">&#xe145;</span> Add Contact
            </button>
        </div>
        <div class="filter-by">
          <span class="atkinson-hyperlegible-bold">Filter By:</span>
          <button id="filterAllButton" class="filter-btn" data-filter="all">All</button>
          <button class="filter-btn" data-filter="sales-lead">Sales Leads</button>
          <button class="filter-btn" data-filter="support">Support</button>
          <button class="filter-btn" data-filter="assigned-to-me">Assigned to me</button>
        </div>

        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Company</th>
              <th>Type</th>
            </tr>
          </thead>  
          <tbody>

            <!--This is for the php stuff here, using contacts -->


          </tbody>
      
    </div>
</section>
    

        

</body>
</html>
<?php endif; ?>