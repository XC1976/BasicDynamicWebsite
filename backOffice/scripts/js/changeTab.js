async function changeLogFile(file) {
    const res = await fetch('logs.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `file=${file}`
    });

    if (res.ok) {
        
        // Mise à jour de la page avec le nouveau contenu
        const html = await res.text();
        document.open();
        document.write(html);
        document.close();
    }

    // Gestion des classes CSS des boutons
    document.querySelectorAll('.btn').forEach(btn => btn.classList.remove('active'));
    let chosenBtn = document.getElementById(file);
    chosenBtn.classList.add("active");
}
