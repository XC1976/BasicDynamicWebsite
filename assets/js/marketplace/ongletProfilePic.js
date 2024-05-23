function openTab(x) {
    let contents = document.querySelectorAll(".tab");
    let btns = document.querySelectorAll(".btn");
    
    for (let i=0; i< contents.length; i++) {
        contents[i].style.display = "none";
        btns[i].classList.remove("active");
    }

    contents[x].style.display = "block";
    btns[x].classList.add("active");
}