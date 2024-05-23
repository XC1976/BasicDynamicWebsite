function deletePopupError(event) {
    event.target.parentElement.remove();

    let url = window.location.href,
    parameter = 'message';

    let urlParts = url.split('?');
    if (urlParts.length >= 2) {
        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlParts[1].split(/[&;]/g);

        for (var i = pars.length; i-- > 0;) {
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        url = urlParts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
        history.replaceState({}, null, url);
    }
}