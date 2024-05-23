/*=============== new_post ===============*/
const new_post = document.getElementById("new_post");
const new_postBtn = document.getElementById("new_post-btn");
const new_postClose = document.getElementById("new_post-close");
const content = document.getElementById("new_post_text");
const message = document.getElementById("message");
/* new_post hidden */
new_postClose.addEventListener("click", () => {
  new_post.classList.remove("show-new_post");
});

get_message = window.location.search.search("message=");

//si pas de message d'erreur
if (get_message !== -1) {
  new_post.classList.add("show-new_post");
}

//==== do not show new post input box if the user isn't connected

async function check_connection() {
  //const login = document.getElementById('login');

  const res = await fetch("../../scripts/is_connected.php");
  const connected = await res.text();
  return connected;
}

async function show_popup() {
  connected = await check_connection();

  if (connected == 0) {
    //show login
    login.classList.add("show-login");
  } else {
    //show new post
    new_post.classList.add("show-new_post");
  }
}

//do not submit form is no categorie have been choosen
document.addEventListener("DOMContentLoaded", function () {
  new_post.addEventListener("submit", async function (event) {
    let doNotSubmit = 0;
    content.classList.remove("warning");

    // Check for default value
    if (content.value.length <= 10) {
      content.classList.add("warning");
      message.innerHTML = "Le poste est trop court";
      event.preventDefault();
    }
    if (content.value.length > 10000) {
      content.classList.add("warning");
      message.innerHTML = "Le poste est trop long";
      event.preventDefault();
    }
  });
});
//like btn
async function like_click(element) {
  //check if user is connected
  connected = await check_connection();

  if (connected == 0) {
    //show login
    login.classList.add("show-login");
    return;
  }

  //get the post id
  const id = element.id;
  const counter = document.getElementById("counter" + id);
  //make the request
  const like_nb = await fetch("../../scripts/new_like.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_post=${id}`,
  });
  const str = await like_nb.text();
  counter.innerHTML = str;
  //réécrire le nombre de likes
}

// Script to delete post
async function deletePost(event, idPost) {
  let deletePostRequest = await fetch("../../scripts/posts/deletePost.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_post=${idPost}`,
  });

  let deletePost = await deletePostRequest.text();

  if (deletePost == "success") {
    event.target.parentElement.parentElement.remove();
  } else if (deletePost == "postNotBelongsToYou") {
    alert("Ce post ne vous appartient pas !");
  } else if (deletePost == "postNotFound") {
    alert("Ce post n'existe pas !");
  }
}

// Show edit text area
function showTextArea(event) {
  // Get closest edit textarea
  let button = event.target;
  let container = button.parentElement;

  // Find the closest textarea element with the class "editPost" within the container
  let textarea = container.querySelector(".editPost");

  // If textarea found
  if (textarea) {
   textarea.classList.toggle('editPostAppear');
  } else {
    console.log("Text area is not found !");
  }
}

// Script to delete post
async function deletePost2(event, idPost) {
  
  let deletePostRequest = await fetch("../../scripts/posts/deleteReviewBook.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_post=${idPost}`,
  });

  let deletePost = await deletePostRequest.text();

  if (deletePost == "success") {
    event.target.parentElement.parentElement.remove();
  } else if (deletePost == "postNotBelongsToYou") {
    alert("Ce post ne vous appartient pas !");
  } else if (deletePost == "postNotFound") {
    alert("Ce post n'existe pas !");
  }
}