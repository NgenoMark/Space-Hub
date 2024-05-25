// Ensure Axios is imported if not already
import axios from 'axios';

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let inactivityTime = function () {
    let time;
    let maxInactivityTime = 1 * 60 * 1000; // 1 minute for testing purposes

    // Reset the timer on user interactions
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onclick = resetTimer;     // Catch click events
    document.onscroll = resetTimer;    // Catch scroll events
    document.onwheel = resetTimer;     // Catch mouse wheel events
    document.onkeydown = resetTimer;   // Catch keydown events

    function logout() {
        axios.post('/logout')
            .then(response => {
                if (response.status === 200) {
                    window.location.href = '/login';
                }
            })
            .catch(error => {
                console.error('Logout error:', error);
            });
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, maxInactivityTime);
    }
};

inactivityTime();
