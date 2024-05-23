# File structure

# Basic dynamic Website in PHP/CSS/SQL

```
/var/www/html/
│
├── assets/
│   ├── css/            # CSS files
│   │   ├── general/        # style.css with style needed everywhere
│   │   ├── modules/        # css files for reusable elements on multiple pages
│   │   └── pageSpecific/   # css files for page specific
│   ├── js/             # JavaScript files
│   └──  img/           # Image files
│
├── includes/           # PHP include files
│
├── pages/              # PHP page files
│
├── scripts/            # PHP scripts (e.g., form handling)
│
├── backOffice/         # All back office PHP files
│
├── index.php           # Main entry point
│  
├── experiments/        # Experimental mini projects that may be of use later 
├── templates           # Contains html templates
├── script.sql          # SQL script
└── README.md           # Project README file
```

# :root CSS variables
```CSS
:root {
    /*========== Font and typography ==========*/
  --primary-font-1: 'Poppins', sans-serif;
  --primary-font-2: 'Syne', sans-serif;
  --normal-font-size: .938rem;
  --h2-font-size: 1.25rem;

  /* ============= Colors ================ */
  --primary-color-1: #8B53FF;
  --primary-color-2: #E91E63;
  --primary-color-3: #24262B;
  --background-color-light-grey: #F5F7FF;
  --background-color-grey: rgb(245, 245, 245);
  --white-color: #FFF;
  --black-color: #000;
}
/*========== Responsive typography ==========*/
@media screen and (min-width: 1023px) {
  :root {
    --h2-font-size: 1.5rem;
    --normal-font-size: 1rem;
  }
}
```

# $_SESSION after logging in
```PHP
    $_SESSION['auth'] = true;
    $_SESSION['id_user'] = $usersInfos['id_user'];
    $_SESSION['name'] = $usersInfos['name'];
    $_SESSION['lastname'] = $usersInfos['lastname'];
    $_SESSION['username'] = $usersInfos['username'];
    $_SESSION['email'] = $usersInfos['email'];
    $_SESSION['profile_pic'] = $usersInfos['profile_pic'];
    $_SESSION['bio'] = $usersInfos['bio'];
    $_SESSION['birthdate'] = $usersInfos['birthdate'];
    $_SESSION['creation_date'] = $usersInfos['creation_date'];
    $_SESSION['deathdate'] = $usersInfos['deathdate'];
    $_SESSION['status'] = $usersInfos['status'];
```

# $_COOKIES for reference
```PHP
    // Create $_COOKIES for username and password with 2 months expiry date
    setcookie("username", $usersInfos['username'], time() + 5259492, "/");
    setcookie("email", $usersInfos['email'], time() + 5259492, "/");
    setcookie("password", $usersInfos['password'], time() + 5259492, "/");
```