function togglePopup(id) {
    let popup = document.querySelector("#overlay");
    popup.classList.toggle("open");
    
    // Sélectionnez le bouton "Oui"
    let ouiButton = document.querySelector("#buttons button:first-child");
    
    // Définir la fonction onclick du bouton "Oui"
    ouiButton.setAttribute("onclick", "deleteBanWord(" + id + ")");

}

async function deleteBanWord(id) {
    console.log('hey ' + id);
    const res = await fetch('scripts/php/deleteWord.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `word=${id}`
    });

    if (res.ok) {
        console.log('Deletion successful');
        // Rafraîchir la page
        setTimeout(() => {
            location.reload();
        }, 0);
    } else {
        console.log('Deletion failed');
    }
}
