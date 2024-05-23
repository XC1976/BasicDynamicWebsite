function setValue(id) {
    const choiceInput = document.getElementById(id);
    const choice = choiceInput.innerHTML;
    console.log(choice);
    const valuePlace = document.getElementById('AUTHOR');
    valuePlace.value = choice;
    const list = document.getElementById('authorOptions');
    list.classList.add("hidden");
}
