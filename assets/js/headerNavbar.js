/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu'),
      navToggle = document.getElementById('nav-toggle'),
      navClose = document.getElementById('nav-close')

/* Menu show */
navToggle.addEventListener('click', () =>{
   navMenu.classList.add('show-menu')
})

/* Menu hidden */
navClose.addEventListener('click', () =>{
   navMenu.classList.remove('show-menu')
})

/*=============== SEARCH ===============*/
const search = document.getElementById('search'),
      searchBtn = document.getElementById('search-btn'),
      searchClose = document.getElementById('search-close')

/* Search show */
searchBtn.addEventListener('click', () =>{
   search.classList.add('show-search')
})

/* Search hidden */
searchClose.addEventListener('click', () =>{
   search.classList.remove('show-search')
})

/*=============== LOGIN ===============*/
const login = document.getElementById('login'),
      loginBtn = document.getElementById('login-btn'),
      loginClose = document.getElementById('login-close')

/* Login show */
loginBtn.addEventListener('click', triggerLoggingScreen);

// Trigger login screen function
function triggerLoggingScreen() {
   login.classList.add('show-login');
}

/* Login hidden */
loginClose.addEventListener('click', () =>{
   login.classList.remove('show-login')
})

//show if the url has the parameter "show-login" set to 1
window.onload = function() {
   let urlParams = new URLSearchParams(window.location.search);
   let doShowLogin = urlParams.get('show-login');
   if (doShowLogin === 'true' ) {
      login.classList.add('show-login');
   };
   
}


async function searchBooks() {
   //fetch searchbar
   const searchBar = document.getElementById('search_input');
   const search = searchBar.value;
   
   const books = await fetch('../../scripts/seachbar.php', {
      method: "POST",
      headers: {"Content-Type": "application/x-www-form-urlencoded"},
      body : `search=${search}`
   });

   let results = await books.text();
   //console.log(results);
   
   try {
      results = JSON.parse(results);
      
   }
   catch (error) {
      console.log('Aucun résultat');
   }
   displaySeach(results);
   
   
}

function displaySeach(results) {
   const resultsDiv = document.getElementById('results');
   resultsDiv.innerHTML = "";
   results.forEach(result => {
      let a = document.createElement("a");
      let p_name = document.createElement("p");
      let p_type = document.createElement("p");

      let link = String;

      if (result.type === 'utilisateur') {
         link = '../../pages/Profil/profile.php?username=' + result.name;
      } else {
         link = '../../pages/livres/livre.php?id=' + result.id_book;
      }
      a.setAttribute("href", link);

      a.classList.add("searchResultItem");
      
      p_name.textContent = result.name;
      p_type.textContent = result.type;
      p_type.classList.add("resType");
      
      a.appendChild(p_name);
      a.appendChild(p_type);
      
      resultsDiv.appendChild(a);
   });
}
