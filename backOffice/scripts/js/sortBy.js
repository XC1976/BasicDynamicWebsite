function sortTable(x) {
    const table = document.querySelector('table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const arrow = table.querySelector('.arrow' + x);

    let newOrder;

    const currentOrder = arrow.classList.contains('asc') ? 'asc' : 'desc';

    if (currentOrder === 'asc') {
        newOrder = 'desc';
    } else {
        newOrder = 'asc';
    }

    table.querySelectorAll('.arrow').forEach(arrow => arrow.classList.remove('asc', 'desc'));

    arrow.className = 'arrow' + x + ' ' + newOrder;

    rows.sort((a, b) => {
        const aValue = a.cells[x].textContent.trim();
        const bValue = b.cells[x].textContent.trim();
        return newOrder === 'asc'
            ? aValue.localeCompare(bValue, undefined, { numeric: true, sensitivity: 'base' })
            : bValue.localeCompare(aValue, undefined, { numeric: true, sensitivity: 'base' });
    });

    tbody.innerHTML = '';

    rows.forEach(row => tbody.appendChild(row));
}
