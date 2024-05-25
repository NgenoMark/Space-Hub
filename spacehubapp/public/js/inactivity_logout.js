let inactivityTime = function () {
    let time;
    let maxInactivityTime = 1 * 60 * 1000; // 10 minutes
    let warningTime = 0.8 * 60 * 1000; // 9 minutes (1 minute before logout)

    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
    document.onwheel = resetTimer;
    document.onkeydown = resetTimer;

    function logout() {
        axios.post('/logout').then(response => {
            window.location.href = '/login';
        });
    }

    function showWarning() {
        alert('You will be logged out in 1 minute due to inactivity.');
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, maxInactivityTime);
        setTimeout(showWarning, warningTime);
    }
};

inactivityTime();
