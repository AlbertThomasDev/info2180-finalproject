document.addEventListener("DOMContentLoaded", function () {
    const sidenavLinks = document.querySelectorAll('.side');
    var result = document.getElementById("view");
    const filterlinks = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('table tbody tr');
    

    function filterTable(filter) {
        tableRows.forEach(row => {
            // Get the contact type and assigned user from the data attributes
            const type = row.getAttribute('data-type').toLowerCase();
            const assignedTo = row.getAttribute('data-assigned-to');
            const logInUserId = row.getAttribute('data-user-id');
            

            // Default action: Show all rows
            let Show = true;

            // Filter conditions
            if (filter === 'all') {
                Show = true; // Show all rows
            } else if (filter === 'sales-lead') {
                Show = (type === 'sales lead'); // Only show Sales Lead rows
            } else if (filter === 'support') {
                Show = (type === 'support'); // Only show Support rows
            } else if (filter === 'assigned-to-me') {
                // Assume the logged-in user's ID is stored in a variable `loggedInUserId`
                Show = (assignedTo === logInUserId); // Show rows assigned to the logged-in user
            }

            // Show or hide the row based on the filter condition
            if (Show) {
                row.style.display = ''; // Show the row
            } else {
                row.style.display = 'none'; // Hide the row
            }
        });
    }



    function fetchData(url) {
        const httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    result.innerHTML = httpRequest.responseText;

                    // Reattach listeners for dynamically loaded content
                    initializeDynamicListeners();
                } else {
                    result.innerHTML = '<p>There was a problem loading the content.</p>';
                }
            }
        };
        httpRequest.open('GET', url, true);
        httpRequest.send();
    }


        function initializeDynamicListeners() {
            // Reattach sidenav link listeners 
            const newSidenavLinks = document.querySelectorAll('.side'); 
            newSidenavLinks.forEach(link => 
                { link.addEventListener('click', function (e) { 
                e.preventDefault(); 
                const target = this.getAttribute('data-target'); 
                // console.log(target);
                // fetchData(target); 

                if (target === 'logout.php') { 
                    window.location.href = '../user_login.php';
                }
                else if(target === 'Home.php') {
                    window.location.href = target;               
                } else { fetchData(target); 

                } 
            }); 
        });


        const newfilterlinks = document.querySelectorAll('.filter-btn');
        newfilterlinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const target = this.getAttribute('data-filter');
                 filterTable(target);
               
            });
        });

            const newContactButton = document.getElementById('contbutton');
            if (newContactButton) {
                newContactButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    fetchData('newContact.php'); 
                });
            }
            // User button Listener
            const addUserButton = document.getElementById('addUserBtn');
            if (addUserButton) {
                addUserButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    fetchData('add_user.php'); 
                });
            }

            // add User Button Listener
            const addContactButton = document.getElementById('button-ad');
            if (addContactButton) {
                addContactButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    fetchData('newContact.php'); 
                });
            }


            const viewLinks = document.querySelectorAll('.view-link'); 
            viewLinks.forEach(link => { 
                link.addEventListener('click', function (e) { 
                    e.preventDefault(); 
                    const target = this.getAttribute('data-target'); 
                    fetchData(target); 
                }); 
            });

            const contactdetailLinks = document.querySelectorAll('.contdet'); 
            contactdetailLinks.forEach(link => { 
                link.addEventListener('click', function (e) { 
                    e.preventDefault(); 
                    const target = this.getAttribute('data'); 
                    fetchData(target); 
                }); 
            });

            // Assign to Me button
document.querySelectorAll('.assignbutton').forEach(button => {
    button.addEventListener('click', function () {
        const contactId = this.dataset.contactId;

        fetch('assignContact.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `contact_id=${contactId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Reload the page to reflect changes
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });
});

// Switch button
document.querySelectorAll('.switchbutton').forEach(button => {
    button.addEventListener('click', function () {
        const contactId = this.dataset.contactId;
        console.log(contactId);

        fetch('switchContact.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `contact_id=${contactId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });
});




document.querySelectorAll('.addnotebtn').forEach(button => {
    button.addEventListener('click', function () {
        const contactId = this.dataset.contactId1;
        // const contactId = 2;
        const comment = document.querySelector('textarea').value;  // Assuming you are using a <textarea> for the comment

        console.log('Contact ID:', contactId);
        console.log('Comment:', comment);

        if (!comment) {
            alert('Please enter a comment.');
            return;  // Don't send the request if comment is empty
        }

        fetch('addNotes.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `contact_id=${contactId}&comment=${encodeURIComponent(comment)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();  // Refresh the page to show the new note
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });
});
  
            console.log("Dynamic listeners initialized.");
        }

        // Initialize listeners on page load (for any existing content)
        initializeDynamicListeners();
    });

    



