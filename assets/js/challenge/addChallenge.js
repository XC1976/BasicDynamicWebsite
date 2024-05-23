async function addChallenge(event, challengeID) {

    // Add challenge to user
    let addChallengeRequest = await fetch(
        "../../../scripts/challenge/addChallenge.php",
        {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `idChallenge=${challengeID}`,
        }
    );
    let addChallenge = await addChallengeRequest.text();

    if(addChallenge == 'success') {
        event.target.parentElement.parentElement.remove();
        return;
    } else if(addChallenge == 'alreadyExists') {
        alert('Vous avez déjà rajouté ce challenge !');
        return;
    } else if(addChallenge == 'challengeDoesntExist') {
        alert('Le challenge n\'existe pas !');
        return;
    } else if(addChallenge == 'missingPost') {
        alert('Vous ne pouvez pas faire le traitement de cette manière !');
        return;
    } else {
        alert('Erreur inconnue !');
        return;
    }
}