const rows = document.querySelectorAll('.forum-table tr:not(.notClickable)');

rows.forEach(function(row) {
    row.addEventListener('click', function() {
        window.location = this.cells[0].getAttribute('data-url');
    });
});