document.addEventListener("DOMContentLoaded", function () {
    const sidenavLinks = document.querySelectorAll('.side');
    var result = document.getElementById("view");

    sidenavLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const target = this.getAttribute('data-target');
            if (target === '../logout.php') {
                window.location.href = target;
            } else {
                fetchData(target);
            }
        });
    });

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
                if (target === 'logout.php') { 
                    window.location.href = target; 
                } else 
                { fetchData(target); 

                } 
            }); 
        });
            // Contact Button Listener
            const addContactButton = document.getElementById('contbutton');
            if (addContactButton) {
                addContactButton.addEventListener('click', function (e) {
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

            // New User Button Listener
            const newUserButton = document.getElementById('newUserButton');
            if (newUserButton) {
                newUserButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    fetchData('/public/newUser.php');
                });
            }
    
            console.log("Dynamic listeners initialized.");
        }
    
        // Initialize listeners on page load (for any existing content)
        initializeDynamicListeners();
    });



