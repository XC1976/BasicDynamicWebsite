async function search() {
    console.log('ok');
    const list = document.getElementById('searchElems');
    const searchInput = document.getElementById('searchBar');
    const search = searchInput.value;
    const res = await fetch('/backOffice/scripts/php/displaySearch.php?name=' + search);
    const str = await res.text();
    list.innerHTML = str;
}
