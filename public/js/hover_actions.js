document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.chung-tu-row').forEach(function (row) {
        row.addEventListener('mouseenter', function () {
            const actions = row.querySelector('.chung-tu-actions');
            if (actions) actions.classList.remove('d-none');
        });
        row.addEventListener('mouseleave', function () {
            const actions = row.querySelector('.chung-tu-actions');
            if (actions) actions.classList.add('d-none');
        });
    });
});
