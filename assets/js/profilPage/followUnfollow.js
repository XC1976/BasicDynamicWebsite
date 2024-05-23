async function follow_user(followButton) {
  // Get the user followed ID
  const userFollowedID = document.getElementById("blockedID").value;
  // Get the current user trying to follow ID
  const currentUserID = document.getElementById("sessionID").value;

  const followUser = await fetch(
    "../../../scripts/profilPage/followUnfollow.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `user_followed=${userFollowedID}&current_user=${currentUserID}`,
    }
  );
  let followUserResponse = await followUser.text();

  if (followUserResponse == "unfollow") {
    followButton.classList.add("unfollowButton");
    followButton.classList.remove("followButton");
    followButton.innerHTML = "Unfollow -";
  } else {
    followButton.classList.add("followButton");
    followButton.classList.remove("unfollowButton");
    followButton.innerHTML = "Follow +";
  }
}

async function blockUser(blockButton) {
  // Get the user followed ID
  const blockedUserID = document.getElementById("blockedID").value;

  // Get the current user trying to follow ID
  const currentUserID = document.getElementById("sessionID").value;

  const blockUser = await fetch(
    "../../../scripts/profilPage/blockUnblock.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `user_blocked=${blockedUserID}&current_user=${currentUserID}`,
    }
  );
  let blockUserResponse = await blockUser.text();

  if (blockUserResponse == "unblock") {
    blockButton.classList.add("unblockButton");
    blockButton.classList.remove("blockButton");
    blockButton.innerHTML = "Unblock";
  } else {
    blockButton.classList.add("blockButton");
    blockButton.classList.remove("unblockButton");
    blockButton.innerHTML = "Block";
  }
}

async function deleteFollowUser(event, idUser) {
  // Script to delete user
  let deleteFollowUserRequest = await fetch(
    "../../../scripts/profilPage/deleteFollowUser.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `userID=${idUser}`,
    }
  );

  let deleteFollowUser = await deleteFollowUserRequest.text();

  if (deleteFollowUser == "successful") {
    event.target.parentElement.parentElement.remove();
  }
}

/*== Username reset ==*/
const usernameReset = document.getElementById("usernameReset"),
  usernameBtn = document.getElementById("username-btn"),
  usernameClose = document.getElementById("username-close");

/* Login show */
usernameBtn.addEventListener("click", triggerLoggingScreen);

// Trigger login screen function
function triggerLoggingScreen() {
  usernameReset.classList.add("show-login");
}

/* Login hidden */
usernameClose.addEventListener("click", () => {
  usernameReset.classList.remove("show-login");
});

function appearDissapear(event) {
  let ppForm = document.getElementById('editPPForm');

  ppForm.classList.toggle('appear');
}

async function deletePP(event) {

  let currentPP = document.getElementById('userProfilPic');

  let deletePPRequest = await fetch(
    "../../../scripts/profilPage/deletePP.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
    }
  );

  currentPP.src = "../../assets/img/profilPic/default.jpg";
}

async function supprimerChallenge(event, idChallenge) {
  // Delete challenge from user
  let deleteChallengeRequest = await fetch(
    "../../../scripts/challenge/deleteChallenge.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `idChallenge=${idChallenge}`,
    }
  );
  let deleteChallenge = await deleteChallengeRequest.text();

  if(deleteChallenge == 'success') {
    event.target.parentElement.remove();
    return;
  } else if(deleteChallenge == 'challengeDoesntExist') {
    alert('Le challenge n\'existe pas !');
    return;
  } else if(deleteChallenge == 'postWrong') {
    alert('Vous ne pouvez pas procéder au traitement ainsi !');
    return;
  } else {
    alert('Erreur inconnue !');
    return;
  }
}