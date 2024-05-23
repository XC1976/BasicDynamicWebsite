// Function to delete product

async function deleteProduct(event, productID) {

    // Fetch script to delete product

    let deleteProductRequest = await fetch('../../../scripts/marketplace/deleteOwnProduct.php', {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `orderID=${productID}`,
    })

    let deleteProduct = await deleteProductRequest.text();

    if(deleteProduct == 'deletionSuccessful') {
        alert("Deletion successful !");

        event.target.parentElement.parentElement.parentElement.remove();
    } else if(deleteProduct == 'notOwnedProduct') {
        alert("You do not own the product !");
    }
}