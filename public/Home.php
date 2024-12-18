<?php
session_start();
include_once '../models/contact.php';
use models\Contact;
Contact::setConnection($conn);

Contact::getAllcontacts();
$contacts = Contact::getContacts();



if (isset($_SESSION['user_id'])):
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="home.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=logout" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" />
  <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Cabin:ital,wght@0,400..700;1,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <title>Home</title>
</head>
<body>
<script src="controlpanel.js" type="text/javascript"></script>
<nav class="sidenav">
  <ul>
    <li><a class="side" data-target="Home.php" id="homebutton1">
        <svg width="27px" height="27px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#ffffff">
        <path d="M10 18V15C10 13.8954 10.8954 13 12 13V13C13.1046 13 14 13.8954 14 15V18" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M2 8L11.7317 3.13416C11.9006 3.04971 12.0994 3.0497 12.2683 3.13416L22 8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M20 11V19C20 20.1046 19.1046 21 18 21H6C4.89543 21 4 20.1046 4 19V11" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg> Home</a></li>
    <li><a class="side" data-target="contact.php" id="contbutton">
      <svg width="27px" height="27px" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="#b12525">
        <path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="#fff"></path>
        <path d="M4.271 18.3457C4.271 18.3457 6.50002 15.5 12 15.5C17.5 15.5 19.7291 18.3457 19.7291 18.3457" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>New Contact</a></li>
    <?php if($_SESSION['role'] === 'Admin') { ?>
      <li><a class="side" data-target="view_users.php">
        <svg width="27px" height="27px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#fff">
        <path d="M7 18V17C7 14.2386 9.23858 12 12 12V12C14.7614 12 17 14.2386 17 17V18" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M1 18V17C1 15.3431 2.34315 14 4 14V14" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M23 18V17C23 15.3431 21.6569 14 20 14V14" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M12 12C13.6569 12 15 10.6569 15 9C15 7.34315 13.6569 6 12 6C10.3431 6 9 7.34315 9 9C9 10.6569 10.3431 12 12 12Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M4 14C5.10457 14 6 13.1046 6 12C6 10.8954 5.10457 10 4 10C2.89543 10 2 10.8954 2 12C2 13.1046 2.89543 14 4 14Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        <path d="M20 14C21.1046 14 22 13.1046 22 12C22 10.8954 21.1046 10 20 10C18.8954 10 18 10.8954 18 12C18 13.1046 18.8954 14 20 14Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>Users</a></li>
    <?php } ?>
    <hr>
    <li><a class="side" data-target="logout.php" id="logout"><span class="material-symbols-outlined">&#xe9ba;</span>Logout</a></li>
  </ul>
</nav>
<section id="view">
    <div class="table">
        <div class="dashboard-header">
            <h1>Dashboard<h1>

            <button class="contact-btn" id="button-ad">
            <svg width="27px" height="27px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#ffffff"><path d="M20.777 13.3453L13.4799 21.3721C12.6864 22.245 11.3136 22.245 10.5201 21.3721L3.22304 13.3453C2.52955 12.5825 2.52955 11.4175 3.22304 10.6547L10.5201 2.62787C11.3136 1.755 12.6864 1.755 13.4799 2.62787L20.777 10.6547C21.4705 11.4175 21.4705 12.5825 20.777 13.3453Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M9 12H12M15 12H12M12 12V9M12 12V15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg> Add Contact
            </button>
        </div>
        <div class="tablecontainer"> 
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
              <th></th>
            </tr>
          </thead>  
          <tbody>
          <?php if (!empty($contacts)): ?>
                    <?php foreach ($contacts as $contact): ?>
                        <tr
                            data-type="<?php echo htmlspecialchars(strtolower($contact->getType())); ?>"
                            data-assigned-to="<?php echo htmlspecialchars($contact->getAssignedTo()); ?>"
                           data-user-id="<?php echo $_SESSION['user_id']; ?>"
                        >
                        <td class="name"><strong><?php echo htmlspecialchars($contact->getTitle()) . ' ' . htmlspecialchars($contact->getFirstName()) . ' ' . htmlspecialchars($contact->getLastName()); ?></strong></td>
                            <td><?php echo htmlspecialchars($contact->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($contact->getCompany()); ?></td>
                            <td class="contactType">
                                <?php if (strtolower($contact->getType()) === 'support'): ?>
                                    <span class="support-btn">SUPPORT</span>
                                <?php else: ?>
                                    <span class="sales-lead-btn">SALES LEAD</span>
                                <?php endif; ?>
                            </td>
                            <td><a class="view-link" data-target="viewcontactdetails.php?id=<?php echo htmlspecialchars($contact->getId()); ?>" 
                            onclick="console.log('ID:', <?php echo htmlspecialchars(json_encode($contact->getId())); ?>);"
                            >View</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class= "name"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endif; ?>
          </tbody>
         </table>          
        </div>
        
    </div>
</section>
</body>
</html>
<?php endif; ?>

