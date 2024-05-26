// public/js/inactivity-logout.js

let inactivityTimeout;

function resetInactivityTimeout() {
    clearTimeout(inactivityTimeout);
    inactivityTimeout = setTimeout(() => {
        axios.post('/api/user/inactive-logout')
            .then(response => {
                window.location.href = '/logout';
            })
            .catch(error => {
                console.error('Logout failed:', error);
            });
    }, 60000); // 2 minutes in milliseconds
}

window.onload = resetInactivityTimeout;
document.onmousemove = resetInactivityTimeout;
document.onkeypress = resetInactivityTimeout;
