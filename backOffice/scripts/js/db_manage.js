const messageH2 = document.getElementById('message');
let currentAction = null;
fetchBackups();


function togglePopupDb(action) {
    //reset 
    const backupNameOutput = document.getElementById('backupNameOutput');
    backupNameOutput.classList.add('hidden');
    const backupNameInput = document.getElementById('backupNameInput');
    backupNameInput.classList.add('hidden');
    //display overlay
    const popup = document.querySelector("#overlay");
    
    popup.classList.toggle("open");
    //confirmation message
    const txtConfirmAction = document.getElementById('txtConfirmAction');
    txtConfirmAction.innerHTML = 'Êtes-vous sûr.e de vouloir ';

    let selected = document.querySelector('.selected');

    switch (action) {
        case 'create':
            backupNameInput.classList.remove('hidden');
            txtConfirmAction.innerHTML += 'créer un nouveau back-up ?';
            currentAction = createBackup;
            break;

        case 'restore':
            //selected row
            if (selected === null) {
                selected = document.getElementById('backups').firstElementChild;
                if (selected === null) {
                    popup.classList.toggle("open");
                    return;
                }
            }
            backupNameOutput.innerHTML = selected.querySelector('.backupName').innerHTML;

            backupNameOutput.classList.remove('hidden');
            txtConfirmAction.innerHTML += 'restaurer ce back-up ?';
            currentAction = restoreBackup;
            break;

        case 'destroy':
            //selected row
            
            if (selected === null) {
                selected = document.getElementById('backups').firstElementChild;
                if (selected === null) {
                    popup.classList.toggle("open");
                    return;
                }
            }
            backupNameOutput.innerHTML = selected.querySelector('.backupName').innerHTML;

            backupNameOutput.classList.remove('hidden');
            txtConfirmAction.innerHTML += 'détruire ce back-up ?';
            currentAction = destroyBackup;
            break;

        case 'dropDb':
            txtConfirmAction.innerHTML += 'atomiser la base de donnée ?';
            currentAction = dropDatabase;
            break;
    }
}


function confirmAction() {
    if (currentAction) {
        currentAction();
    }
    togglePopupDb();
}

async function fetchBackups() {
    const backups = document.getElementById('backups');
    const req = await fetch('../../backOffice/scripts/php/api/getBackup.php');
    const res = await req.text();
    backups.innerHTML = res;
    rowClick();
}

function rowClick(){
    //make row clickable
    const rows = document.querySelectorAll('#backups tr');

    rows.forEach(row => {
        row.addEventListener('click', () => {
            const unselected = document.querySelector('.selected');

            if (unselected !== null) {
                unselected.classList.remove('selected');
            }
            row.classList.add('selected');
        });
    });
}


async function createBackup() {
    const backupName = document.getElementById('backupNameInput').value;
    const req = await fetch('../../backOffice/scripts/php/api/createBackup.php', {
        method: 'POST',
        headers : {'Content-Type' : 'application/x-www-form-urlencoded'},
        body : `name=${backupName}`
    });
    let res = await req.text();
    res = parseInt(res);
    if (res !== 0) {
        messageH2.innerHTML = 'La création du backup a échouée';
    } else {
        messageH2.innerHTML = 'La création du backup a réussi';
    }
    console.log(res);
    fetchBackups();
}

function restoreBackup() {
    console.log('Backup restored');
}

async function destroyBackup() {
    backup = document.getElementById('backupNameOutput').innerHTML;

    const req = await fetch('../../backOffice/scripts/php/api/destroyBackup.php', {
        method: 'POST',
        headers : {'Content-Type' : 'application/x-www-form-urlencoded'},
        body : `name=${backup}`
    });
    let res = await req.text();
    //console.log(res);
    res = parseInt(res);
    if (res !== 0) {
        messageH2.innerHTML = 'La destruction du backup a échouée';
    } else {
        messageH2.innerHTML = 'La destruction du backup a réussi';
    }
    fetchBackups();
    
}

async function restoreBackup() {
    backup = document.getElementById('backupNameOutput').innerHTML;

    const req = await fetch('../../backOffice/scripts/php/api/restoreBackup.php', {
        method: 'POST',
        headers : {'Content-Type' : 'application/x-www-form-urlencoded'},
        body : `name=${backup}`
    });
    let res = await req.text();
    res = parseInt(res);
    if (res !== 0) {
        messageH2.innerHTML = 'La restauration du backup a échouée';
    } else {
        messageH2.innerHTML = 'La restauration du backup a réussi';
    }
    
}


async function dropDatabase() {
    const req = await fetch('../../backOffice/scripts/php/api/destroy_database.php');
    let res = await req.text();
    console.log(res);
    res = parseInt(res);
    if (res !== 0) {
        messageH2.innerHTML = "La base de donnée n'a pas pû être atomisée";
    } else {
        messageH2.innerHTML = "La base de donnée à été atomisée avec succès";
    }
    
}


