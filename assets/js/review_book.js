
//=============== review ===============
const review = document.getElementById('review_form');
const reviewBtn = document.getElementById('review-btn');
const reviewClose = document.getElementById('review-close');
const content = document.getElementById('review_text');
const message = document.getElementById('message');
const ratingDiv = document.getElementById('ratingAndTitle');
const rating = document.getElementById('rating');review__button
const title = document.getElementById('review__title');
const btn = document.getElementById('review__button');
const response = document.getElementById('respond_to');

//review hidden 
reviewClose.addEventListener('click', () =>{
   review.classList.remove('show-review')
})

get_message = window.location.search.search("message=");

//si pas de message d'erreur
if (get_message !== -1) {
   review.classList.add('show-review');
}

//==== do not show new post input box if the user isn't connected

async function check_connection() {

   const res = await fetch("../../scripts/is_connected.php"); 
   const connected = await res.text();
   return connected;
}
//this function show the popup to write a review/response
//it modifies the form accordingly
async function show_popup(element) {
   //User must be connected
   connected = await check_connection();
   if (connected == 0) {
      //show login     
      login.classList.add('show-login');
      return;
   }
   //show new post
   review.classList.add('show-review');
   
   if (element.id === 'review-btn') {
      //REVIEW
      ratingDiv.style.display = "block";
      rating.value = 5;
      title.innerHTML = "Ecrire une critique";
      btn.innerHTML = "Poster ma critique";
   }
   else { //RESPOND TO A USER
      ratingDiv.style.display = "none";
      rating.value = -1; 
      response.value = element.id;
      title.innerHTML = "Ecrire une réponse";
      btn.innerHTML = "Poster ma réponse";

   }

}

//do not submit form is no categorie have been choosen
document.addEventListener('DOMContentLoaded', function() {
   
   review.addEventListener('submit', function(event) {

      // Check for default value
      if (content.value.length <= 10) {
         message.innerHTML = "Le poste est trop court";
         event.preventDefault();
      }
      if (content.value.length > 10000 ) {
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
      login.classList.add('show-login');
      return;
   }
   
   //get the review id
   const id = element.id;
   const counter = document.getElementById("counter" + id);
   //make the request
   const like_nb = await fetch('../../scripts/new_like_review.php', {
       method: "POST",
       headers: {"Content-Type": "application/x-www-form-urlencoded" },
       body : `id_review=${id}`
   });
   const str = await like_nb.text();
   //réécrire le nombre de likes
   counter.innerHTML = str;
   
}

//=== star coloring for the new review
const stars = document.querySelectorAll('.rating i');

stars.forEach(star => {
   star.addEventListener('mouseover', function() {
      const rating = parseInt(this.getAttribute('data-rating'));
      stars.forEach((s, index) => {
         if (index >= rating) {
            s.style.color = '#ccc';
         } else {
            s.style.color = '#F3B519';
         }
      });
   }); 

   star.addEventListener('click', function() {
      const rating = parseInt(this.getAttribute('data-rating'));
      document.getElementById('rating').value = rating;
   });
});

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
     event.target.parentElement.parentElement.parentElement.remove();
   } else if (deletePost == "postNotBelongsToYou") {
     alert("Ce post ne vous appartient pas !");
   } else if (deletePost == "postNotFound") {
     alert("Ce post n'existe pas !");
   }
 }

async function switchFinished(event, idBook) {
   
   // Switch finished and unfinished
   let switchFinishRequest = await fetch("../../scripts/libraries/switchFinish.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `idBook=${idBook}`,
   });
   let switchFinish = await switchFinishRequest.text();
   
   if(switchFinish == 'switchCompleted') {
      event.target.classList.add('buttonCompleted');
      event.target.classList.remove('buttonNotCompleted');
      event.target.innerHTML = 'Complétée';
      return;
   } else if(switchFinish == 'switchUncompleted') {
      event.target.classList.add('buttonNotCompleted');
      event.target.classList.remove('buttonCompleted');
      event.target.innerHTML = 'Pas complétée';
      return;
   } else if(switchFinish == 'bookDoesntExist') {
      alert('Le livre n\'existe pas !');
      return;
   } else if(switchFinish == 'postWrong') {
      alert('Vous ne pouvez pas accéder au formulaire ainsi !');
      return;
   } else {
      alert('Erreure inconnue !');
      return;
   }
}