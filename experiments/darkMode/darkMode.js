let darkModeIcon = document.getElementById("darkModeIcon");

darkModeIcon.onclick = function() {
    document.body.classList.toggle("dark-theme");
    if(document.body.classList.contains("dark-theme")) {
        darkModeIcon.src = "assets/img/darkMode/sun.png";
    } else {
        darkModeIcon.src = "assets/img/darkMode/moon.png";
    }
}