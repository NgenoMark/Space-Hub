import './bootstrap';

// Locks the screen until the page is loaded
document.addEventListener('DOMContentLoaded', function () {
    let inactivityTime = function () {
        let time;
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;  // catches touchscreen presses
        window.ontouchstart = resetTimer; // catches touchscreen swipes
        window.ontouchmove = resetTimer;  // required by some devices
        window.onclick = resetTimer;      // catches touchpad clicks

        function logout() {
            window.location.href = '/lock';
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(logout, 60000);  // 5 minutes
        }
    };

    // Call the inactivityTime function
    inactivityTime();

    // Lock screen button
    document.getElementById('lock-screen-button').addEventListener('click', function () {
        window.location.href = '/lock';
    });
});
