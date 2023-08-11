function toggleTheme() {
    var body = document.body;
    var switcher = document.querySelector('.switcher');
    var isDarkMode = body.classList.contains('dark-mode');
    
    // Toggle dark mode class on body
    body.classList.toggle('dark-mode');
    
    // Toggle icon classes
    if (isDarkMode) {
        switcher.classList.remove('fa-sun');
        switcher.classList.add('fa-moon');
        // Remove the theme cookie if dark mode is disabled
        document.cookie = 'theme=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    } else {
        switcher.classList.remove('fa-moon');
        switcher.classList.add('fa-sun');
        // Set a theme cookie with an expiration date
        var expirationDate = new Date();
        expirationDate.setFullYear(expirationDate.getFullYear() + 1); // Set the expiration date to one year from now
        document.cookie = 'theme=dark; expires=' + expirationDate.toUTCString() + '; path=/;';
    }
}

// Function to check if a cookie with the given name exists
function getCookie(name) {
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();
        if (cookie.startsWith(name + '=')) {
            return cookie.substring(name.length + 1);
        }
    }
    return null;
}

// Function to set the theme based on the saved cookie
function setThemeFromCookie() {
    var theme = getCookie('theme');
    if (theme === 'dark') {
        document.body.classList.add('dark-mode');
        document.querySelector('.switcher').classList.remove('fa-moon');
        document.querySelector('.switcher').classList.add('fa-sun');
    }
}


// Call the setThemeFromCookie function on page load
window.addEventListener('load', setThemeFromCookie);
