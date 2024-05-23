async function FetchAuthorAZERTY() {
    const list = document.getElementById('authorOptions');
    list.classList.remove("hidden");
    const searchInput = document.getElementById('AUTHOR');
    const search = searchInput.value;
    const res = await fetch('scripts/php/displayAuthor.php?name=' + search);
    const str = await res.text();
    const div = document.getElementById('authorOptions');
    div.innerHTML = str;
}
