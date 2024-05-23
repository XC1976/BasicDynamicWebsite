// Function to trigger login screen to add to cart button if not connected

function triggerLoginScreen() {
    login.classList.add('show-login');
}

// Allows to change the main image on single product page to the one we clicked

let MainImg = document.getElementById("MainImage");

let smallImg = document.getElementsByClassName("small-img-col");

smallImg[0].onclick = function() {
    MainImg.src = smallImg[0].querySelector('img').src;
}
smallImg[1].onclick = function() {
    MainImg.src = smallImg[1].querySelector('img').src;
}
smallImg[2].onclick = function() {
    MainImg.src = smallImg[2].querySelector('img').src;
}
smallImg[3].onclick = function() {
    MainImg.src = smallImg[3].querySelector('img').src;
}

async function addtoCart(event) {

    // Get the product data
    let productID = document.getElementById("addToCartJS").value;

    // Get quantity of products
    let productQuantity = document.getElementById("quantityProduct").value;

    // Get the add to cart button
    let addToCartButton = document.getElementsByClassName("addToCartButton")[0];

    let updateSessionItems = await fetch('../../../scripts/marketplace/addItemToCart.php', {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded" },
        body: `item_id=${productID}&item_quantity=${productQuantity}`
    });

    let reponseAlreadyInCart = await updateSessionItems.text();

    if(reponseAlreadyInCart == 'successful') {
        addToCartButton.innerText = 'Déjà dans le panier';
    }
    updateCartItemNavbar()
}

// Update dynamically the cart item number on navbar
async function updateCartItemNavbar() {
    // Get span on navbar id
    let navbarCartIcon = document.getElementById("numberCartItemNavbarFront");

    let updateCountItem = await fetch('../../../scripts/marketplace/updateCartItemNavbar.php', {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded" },
    })

    let responseupdateCountItem = await updateCountItem.text();
    
    navbarCartIcon.innerText = responseupdateCountItem;
}

// Function to verify that the value inside the input type number is valid

function quantityChanged(event) {
    let input = event.target;

    // Get the max value in stock
    let maxStockValue = document.getElementById("idBookToSellInput").value;

    // Regex to verify it only contains number 0 to 9
    if(!/^[0-9]+$/.test(input.value) || Number(input.value) > Number(maxStockValue) || input.value <= 0) {
        input.value = 1;
    }
}