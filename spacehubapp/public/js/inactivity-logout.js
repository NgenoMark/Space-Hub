let inactivityTimeout;

function resetInactivityTimeout() {
    clearTimeout(inactivityTimeout);
    inactivityTimeout = setTimeout(() => {
        console.log('User inactive, sending logout request.');
        
        // Log CSRF token
        console.log('CSRF Token:', document.head.querySelector('meta[name="csrf-token"]').content);
        
        axios.post('/api/user/inactive-logout')
            .then(response => {
                console.log('Logout request successful, redirecting to logout.');
                window.location.href = '/logout'; // Adjust the logout URL as necessary
            })
            .catch(error => {
                console.error('Logout failed:', error.response ? error.response.data : error.message);
                
                // Log detailed error information
                if (error.response) {
                    console.error('Error status:', error.response.status);
                    console.error('Error headers:', error.response.headers);
                    console.error('Error data:', error.response.data);
                } else if (error.request) {
                    console.error('Error request:', error.request);
                } else {
                    console.error('Error message:', error.message);
                }
            });
    }, 60000); // 1 minute in milliseconds
    console.log('Inactivity timeout reset.');
}

window.onload = resetInactivityTimeout;
document.onmousemove = resetInactivityTimeout;
document.onkeypress = resetInactivityTimeout;
