async function switchPublicPrivate(event, libID) {
  // Switch between public and private

  let switchPublicPrivateRequest = await fetch(
    "../../../scripts/libraries/switchPublicPrivate.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `libID=${libID}`,
    }
  );
  let switchPublicPrivate = await switchPublicPrivateRequest.text();

  if (switchPublicPrivate == "switchToPublic") {
    event.target.classList.add("libPublic");
    event.target.classList.remove("libPrivate");
    event.target.innerHTML = "Publique";
    return;
  } else if (switchPublicPrivate == "switchToPrivate") {
    event.target.classList.add("libPrivate");
    event.target.classList.remove("libPublic");
    event.target.innerHTML = "Privée";
    return;
  } else if (switchPublicPrivate == "libraryNotOwned") {
    alert("Vous ne posséder pas cette librarie !");
    return;
  } else if (switchPublicPrivate == "libraryDoesNotExist") {
    alert("Cette librarie n'existe pas !");
    return;
  }
}

async function removeBookLibrary(event, bookID, libID) {
  // Get the link
  let link = document.getElementById("pageLinkC").value;

  // Remove the book from library

  let removeBookLibraryRequest = await fetch(
    "../../../scripts/libraries/removeBookLibrary.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `bookID=${bookID}&libID=${libID}`,
    }
  );

  let removeBookLibrary = await removeBookLibraryRequest.text();

  if (removeBookLibrary == "success") {
    event.target.parentElement.remove();
  } else if(removeBookLibrary == 'bookNotInLibrary') {
    alert('Le livre n\'est pas dans la librarie !');
    return;
  } else if(removeBookLibrary == 'libNotFound') {
    alert('Librarie introuvable !');
    return;
  } else if(removeBookLibrary == 'bookNotFound') {
    alert('Livre introuvable !');
    return;
  } else if(removeBookLibrary == 'notOwnBook') {
    alert('Vous n\'êtes pas propriétaire du livre !');
    return;
  } else {
    alert('Bug introuvable !');
    return;
  }
}

async function removeLib(event, idLib) {

  let removeBookLibraryRequest = await fetch(
    "../../../scripts/libraries/removeLibraryTotal.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `libID=${idLib}`,
    }
  );

  let removeBookLibrary = await removeBookLibraryRequest.text();

  if(removeBookLibrary == 'success') {
    window.location.href = '../../index.php?message=Librairie supprimée avec succès !';
    return;
  } else if(removeBookLibrary == 'notOwnLib') {
    alert('Vous ne posséder pas cette librarie !');
    return;
  } else if(removeBookLibrary == 'libNotFound') {
    alert('Cette librarie n\'existe pas !');
    return;
  }
}