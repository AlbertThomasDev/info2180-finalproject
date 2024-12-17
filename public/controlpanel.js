document.addEventListener("DOMContentLoaded", function () {
    const sidenavLinks = document.querySelectorAll('.side');
    var result = document.getElementById("view");
    const filterlinks = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('table tbody tr');

    // sidenavLinks.forEach(link => {
    //     link.addEventListener('click', function (e) {
    //         e.preventDefault();

    //         const target = this.getAttribute('data-target');
    //         if (target === '../logout.php') {
    //             window.location.href = target;
    //         } else {
    //             fetchData(target);
    //         }
    //     });
    // });

    // filterlinks.forEach(link => {
    //     link.addEventListener('click', function (e) {
    //         e.preventDefault();
    //         const target = this.getAttribute('data-filter');
    //          filterTable(target);
           
    //     });
    // });

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
                    window.location.href = target;
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


            console.log("Dynamic listeners initialized.");
        }
    // Contact Button Listener
    

        // Initialize listeners on page load (for any existing content)
        initializeDynamicListeners();
    });



