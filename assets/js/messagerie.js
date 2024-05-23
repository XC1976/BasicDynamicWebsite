//display messages when window just loaded
document.addEventListener('DOMContentLoaded', function(){
    fetchMsg(1);
    fetchDmUsers();
})
//refresh message every 1 sec
setInterval(function() {
    fetchMsg(0)
    fetchDmUsers();
}, 1000);

//make discu clickable
function clickableDiscu() {
    const allDiscu = document.querySelectorAll('.discu');
    allDiscu.forEach(function(discu) {
        discu.addEventListener('click', function() {
            select_discu(discu.id);
        });
    });
}
clickableDiscu();

/*=============== SEARCH ===============*/
const searchUsr = document.getElementById('searchUsr'),
      searchBtnUsr = document.getElementById('search-btnUsr'),
      searchCloseUsr = document.getElementById('search-closeUsr')



/* Search hidden */
searchCloseUsr.addEventListener('click', () =>{
   searchUsr.classList.remove('show-search')
})

function new_mp() {
    searchUsr.classList.add('show-search');
}

async function select_discu(idDiscu) {

    if (idDiscu == '' || idDiscu === null)
    return 1;

    let match = idDiscu.match(/\d+/);
    let idDest = match ? parseInt(match[0], 10) : null;

    if (idDest === null) {
        return 1;
    }
    console.log('selected discu : ' + idDest);
    
    const res = await fetch('../../scripts/selected_dest.php', {
        method : "POST",
        headers : {"Content-Type" : "application/x-www-form-urlencoded" },
        body : `id_dest=${idDest}`
    });
    
    fetchMsg();
}


//get the message for a discu
async function fetchMsg(scroll) {
    //console.log('Fetching new messages');
    const req_id_dest = await fetch('../../scripts/fetch_selected_dest.php');
    const req_req = await req_id_dest.text()
    if (req_req == -1) {
        return 1;
    }
    
    
    const res = await fetch('../../scripts/fetchDM.php');
    let messages = await res.text();
    
    try {
        messages = JSON.parse(messages);
    } catch(error) {
        console.log(error);
        return 1;
    }

    const rootPath = '../../';
    const msgarea = document.getElementById('msgarea');
    msgarea.innerHTML = '';

    messages.forEach(message => {
        let msgDiv = document.createElement('div');
        msgDiv.className = 'discu';
        let avatarLink = document.createElement('a');
        avatarLink.className = 'avatar';
        avatarLink.href = `${rootPath}pages/Profil/profile.php?username=${message.username}`;

        let avatarDiv = document.createElement('div');

        
        let img = document.createElement('img');
        img.src = `${rootPath}assets/img/profilPic/${message.profile_pic}`;
        img.alt = 'User Avatar';

        let userInfoDiv = document.createElement('div');
        userInfoDiv.className = 'user-info';

        let usernameDiv = document.createElement('div');
        usernameDiv.className = 'username';
        usernameDiv.textContent = `@${message.username}`;

        userInfoDiv.appendChild(usernameDiv);

        avatarDiv.appendChild(img);
        avatarDiv.appendChild(userInfoDiv);

        avatarLink.appendChild(avatarDiv);

        let contentDiv = document.createElement('div');
        contentDiv.className = 'content';

        let innerContentDiv = document.createElement('div');
        innerContentDiv.className = 'content';
        innerContentDiv.textContent = message.content;

        let timeDiv = document.createElement('div');
        timeDiv.className = 'time';
        timeDiv.textContent = message.sent_date;

        contentDiv.appendChild(innerContentDiv);
        contentDiv.appendChild(timeDiv);

        msgDiv.appendChild(avatarLink);
        msgDiv.appendChild(contentDiv);
        msgarea.appendChild(msgDiv);
        if (scroll !== 0) {

            msgarea.scrollTop = msgarea.scrollHeight;
        }
        
    });
    
}

async function sendMsg() {
    //post content
    let msgbox = document.getElementById('msgContent');
    const content = msgbox.value;
    
    if (content === '') {
        return 1;
    }

    const res = await fetch('../../scripts/send_message.php', {
        method : "POST",
        headers : {"Content-Type" : "application/x-www-form-urlencoded" },
        body : `content=${content}`
    });
    msgbox.value = '';
    const code = await res.text();

    fetchMsg();
    fetchDmUsers();
}





async function searchUser() {
    //fetch searchbar
    const searchBar = document.getElementById('search_inputUsr');
    const search = searchBar.value;
    
    const users = await fetch('../../scripts/seachbar_user.php', {
       method: "POST",
       headers: {"Content-Type": "application/x-www-form-urlencoded"},
       body : `search=${search}`
    });
 
    let results = await users.text();
    //console.log(results);
    
    try {
       results = JSON.parse(results);
       
    }
    catch (error) {
       console.log('Aucun résultat');
       return 1;
    }
    displaySeachUsr(results);
    
 }
 
function displaySeachUsr(results) {
    const resultsDiv = document.getElementById('resultsUser');
    resultsDiv.innerHTML = "";
    results.forEach(result => {
       let div_listen = document.createElement("div");
       let p_name = document.createElement("p");
 
       let link = '../../pages/Profil/profile.php?username=' + result.name;
        div_listen.addEventListener("click", function() {
            const msgarea = document.getElementById('msgarea');
            msgarea.innerHTML = '';
            searchUsr.classList.remove('show-search');
            select_discu(String(result.id_user));
            console.log('selected user : ' + result.id_user);
            fetchDmUsers();
        })
       div_listen.classList.add("searchResultItem");
       
       p_name.textContent = result.name;
       div_listen.appendChild(p_name);
       resultsDiv.appendChild(div_listen);
    });
}

async function fetchDmUsers() {
    const usrArea = document.getElementById('usrArea');
    const req = await fetch('../../scripts/fetchDmUsers.php');
    const txt = await req.text();
    usrArea.innerHTML = txt;
    clickableDiscu();
}