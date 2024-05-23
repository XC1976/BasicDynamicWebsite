/*=============== discu ===============*/
const discu = document.getElementById('discu');
const discuBtn = document.getElementById('discu-btn');
const discuClose = document.getElementById('discu-close');
const categorie = document.getElementById('categorie');
const message = document.getElementById('message');
const title = document.getElementById('title');
const content = document.getElementById('discu_content');

/* discu hidden */
discuClose.addEventListener('click', () =>{
   discu.classList.remove('show-discu')
})

const get_message = window.location.search.search("message=");

//si pas de message d'erreur
if (get_message !== -1) {
   discu.classList.add('show-discu');
}

//==== do not show new discu input box if the user isn't connected
async function check_connection() {
   //const login = document.getElementById('login');

   const res = await fetch("../../scripts/is_connected.php"); 
   const connected = await res.text();
   console.log("connected = ");
   console.log(connected);
   return connected;
}

async function show_popup() {
   connected = await check_connection();

   if (connected == 0) {
      //show login
      console.log("disconneted");
     
      login.classList.add('show-login');
   } else {
      //show new post
      console.log("connected");
      discu.classList.add('show-discu');
   }
}


//do not submit form is no categorie have been choosen
document.addEventListener('DOMContentLoaded', function() {
   
   discu.addEventListener('submit', function(event) {
      let doNotSubmit = 0;
      title.classList.remove('warning');
      categorie.classList.remove("warning");
      content.classList.remove('warning');

      // Check for default value
      if (title.value.length <= 2) {
         title.classList.add('warning');
         message.innerHTML = "Le titre est trop court";
         doNotSubmit = 1;
      }
      if (categorie.value === 'default') {
         categorie.classList.add("warning");
         message.innerHTML = "Choisissez une catégorie !";
         doNotSubmit = 1;
      }
      if (content.value.length <= 10) {
         content.classList.add('warning');
         message.innerHTML = "Le poste est trop court";
         doNotSubmit = 1;
      }

      if (doNotSubmit == 1) {
         event.preventDefault();
      }
         
   });
});