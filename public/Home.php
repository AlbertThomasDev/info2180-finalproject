<?php
session_start();

/*if (isset($_SESSION['user_id'])) {
    header("Location: ../logout.php");
    exit;
    }*/   
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel = "stylesheet" type="text/css" href="home.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  <title>Home</title>
</head>
<body>
<nav class="sidenav">
  <ul>
    <!-- got to add in icons -->
    <li><a data-target="Home.php">Home</a></li>
    <li><a data-target="Home.php">New Contact</a></li>
    <?php if($_SESSION['role'] === 'Admin') { ?>
      <li><a data-target="add_user.php">Users</a></li>
    <?php } ?>
    <hr>
    <li><a data-target="logout.php">Logout</a></li>
  </ul>
</nav>
<section id="view">
    <div class="table">
        <div class="dashboard-header">
            <h1>Dashboard<h1>

            <button class="contact-btn" id="addContactButton">
                <span class="symbols">add</span> Add Contact
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