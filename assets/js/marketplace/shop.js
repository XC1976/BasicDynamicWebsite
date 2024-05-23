// This script change the $_GET['page'] value depending on the navigation button on the bottom for shop.php in the marketplace

function addGetParameter(paramName, paramValue) {
    // Get the current URL
    var url = window.location.href;

    // Check if the URL already contains parameters
    var urlParams = new URLSearchParams(window.location.search);

    // Update the value if the parameter already exists, otherwise add the new parameter
    urlParams.set(paramName, paramValue);

    // Construct the new URL with the updated $_GET parameter
    var newUrl = window.location.origin + window.location.pathname + '?' + urlParams.toString();

    // Redirect to the new URL
    window.location.href = newUrl;
}