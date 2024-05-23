// Validate order
async function validateOrder(event, orderID) {
    
    // Validate order script
    let validateOrderRequest = await fetch('../../../scripts/marketplace/validateOrder.php', 
        {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `orderID=${orderID}`,
        }
    )

    let validateOrderResponse = await validateOrderRequest.text();

    if(validateOrderResponse == 'successful') {
        alert('Votre commande a été livrée !');
    } else if(validateOrderResponse == 'ItemNotFromUser') {
        alert('Cette commande ne vous appartient pas !');
    } else if(validateOrderResponse == 'ItemNotFound') {
        alert('Cette commande n\'a pas été trouvée ! ');
    }
}

// Cancel order
async function cancelOrder(event, orderID) {
    
    // Validate order script
    let cancelOrderRequest = await fetch('../../../scripts/marketplace/cancelOrder.php', 
        {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `orderID=${orderID}`,
        }
    )

    let cancelOrderResponse = await cancelOrderRequest.text();

    if(cancelOrderResponse == 'successful') {
        alert('Votre commande a été annulée !');
    } else if(cancelOrderResponse == 'ItemNotFromUser') {
        alert('Cette commande ne vous appartient pas !');
    } else if(cancelOrderResponse == 'ItemNotFound') {
        alert('Cette commande n\'a pas été trouvée ! ');
    }
}