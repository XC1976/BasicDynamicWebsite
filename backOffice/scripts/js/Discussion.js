function togglePopup(id) {
    let popup = document.querySelector("#overlay");
    popup.classList.toggle("open");
    
    // Sélectionnez le bouton "Oui"
    let ouiButton = document.querySelector("#buttons button:first-child");
    
    // Définir la fonction onclick du bouton "Oui"
    ouiButton.setAttribute("onclick", "deletePost(" + id + ")");

}

async function deletePost(id) {
    console.log('hey ' + id);
    const res = await fetch('scripts/php/deletePost.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `post=${id}`
    });

    if (res.ok) {
        setTimeout(() => {
            location.reload();
        }, 100); 
        console.log('Deletion successful');
    } else {
        console.log('Deletion failed');
       
    }
}

