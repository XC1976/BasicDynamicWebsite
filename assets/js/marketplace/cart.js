// Remove item from cart script

let removeButtons = document.getElementsByClassName("removeButtons");

for (let i = 0; i < removeButtons.length; ++i) {
  let button = removeButtons[i];

  button.addEventListener("click", removeCartItem);
}

// Verify the input is not a wrong value every time it is changed

let quantityInputs = document.getElementsByClassName("itemQuantity");

for (let i = 0; i < quantityInputs.length; ++i) {
  let input = quantityInputs[i];

  input.addEventListener("change", quantityChanged);
}

// Remove the current item and update the cart
async function removeCartItem(event) {
  let buttonClicked = event.target;

  // Get the current item ID
  let currentItemID =
    buttonClicked.parentElement.parentElement.getElementsByClassName(
      "itemIDSession"
    )[0].value;

  let removeItemFromSession = await fetch(
    "../../../scripts/marketplace/removeItemSession.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `current_item_id=${currentItemID}`,
    }
  );

  let responseremoveItemFromSession = await removeItemFromSession.text();

  // Item ID n'existe pas dans la SESSION
  if (responseremoveItemFromSession == "0") {
    alert("Vous essayez de supprimer un item non présent dans votre panier !");
    return;
  }

  buttonClicked.parentElement.parentElement.remove();
  updateCartTotal();
  await updateCartItemNavbar();
}

// Update dynamically the cart item number on navbar
async function updateCartItemNavbar() {
  // Get span on navbar id
  let navbarCartIcon = document.getElementById("numberCartItemNavbarFront");

  let updateCountItem = await fetch(
    "../../../scripts/marketplace/updateCartItemNavbar.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
    }
  );

  let responseupdateCountItem = await updateCountItem.text();

  navbarCartIcon.innerText = responseupdateCountItem;
}

// Update dynamically the cart item number on navbar
async function updateCartItemNavbar() {
  // Get span on navbar id
  let navbarCartIcon = document.getElementById("numberCartItemNavbarFront");

  let updateCountItem = await fetch(
    "../../../scripts/marketplace/updateCartItemNavbar.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
    }
  );

  let responseupdateCountItem = await updateCountItem.text();

  navbarCartIcon.innerText = responseupdateCountItem;
}

// Update the price function in total checkout
function updateCartTotal() {
  let cartRows = document.getElementsByClassName("cartItem");

  let total = 0;

  // Shipping price
  let shippingPrice = document
    .getElementsByClassName("shippingPrice")[0]
    .innerText.replace("$", "");

  for (let i = 0; i < cartRows.length; ++i) {
    let cartRow = cartRows[i];
    // Get price
    let price = cartRow
      .getElementsByClassName("itemPrice")[0]
      .innerText.replace("$", "");

    // Get quantity
    let quantity = cartRow.getElementsByClassName("itemQuantity")[0].value;

    total = total + price * quantity;
  }

  let totalPrice = parseFloat(total) + parseFloat(shippingPrice);

  // Condition if the total = 0

  if (total == 0) {
    // Total price set to 0
    totalPrice = 0;

    let newButtonHTML =
      '<button onclick="noitem()" style="background-color: #EA5455;">Panier vide !</button>';

    // Get the button container element
    let buttonContainer = document.getElementById("buttonContainer");

    // Set the innerHTML of the button container to the new button HTML
    buttonContainer.innerHTML = newButtonHTML;
  }

  // Round the results
  total = Math.round(total * 100) / 100;
  totalPrice = Math.round(totalPrice * 100) / 100;

  // Insert new values

  document.getElementsByClassName("totalPrice")[0].innerText = "$ " + total;
  document.getElementsByClassName("totalCheckout")[0].innerText =
    "$ " + totalPrice;
}

// Function to verify that the value inside the input is valid

function quantityChanged(event) {
  let input = event.target;

  // Get the max value in stock
  let maxStockValue = input.getAttribute("data-max-stock-value");

  // Regex to verify it only contains number 0 to 9
  if (
    !/^[0-9]+$/.test(input.value) ||
    Number(input.value) > Number(maxStockValue) || input.value <= 0
  ) {
    input.value = 1;
  }
  updateCartTotal();
}

// Function to pay

async function checkout(event) {
  // Get all items quantity elements
  let allItemsQuantity = document.getElementsByClassName("itemQuantity");

  let allItemsQuantityString = "";

  for (let i = 0; i < allItemsQuantity.length; ++i) {
    allItemsQuantityString =
      allItemsQuantityString + "_" + allItemsQuantity[i].value;
  }
  allItemsQuantityString = allItemsQuantityString.slice(1);

  // Send the new string of quantities to a script to construct a new one
  let addNewQuantites = await fetch(
    "../../../scripts/marketplace/checkoutCart.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `new_string_quantities=${allItemsQuantityString}`,
    }
  );

  let addNewQuantitesResponse = await addNewQuantites.text();

  // Success message or error message handling
  if (addNewQuantitesResponse == "success") {
    alert("Commande passée avec succès !");
    location.reload();
  } else if (addNewQuantitesResponse == "newQuantitiesInvalid") {
    alert("Vos nouvelles quantités sont invalides !");
  } else if (addNewQuantitesResponse == "ItemNotFound") {
    alert("Les ID des objets sont invalides ! ");
  } else if (addNewQuantitesResponse == "NotEnoughStock") {
    alert("Vos quantités commandées sont supérieures au stock disponibles !");
  }

  // At the end unset($_SESSION['cartItems']);
}

// Alert for checkout button when no item

function noitem() {
  alert("Il n'y a pas d'objets dans le panier ! ");
}
