document.addEventListener('DOMContentLoaded', function () {
    const huongSelect = document.getElementById('id_huong');
    const doiTacGroup = document.getElementById('doiTacGroup');

    function toggleDoiTacGroup() {
        const selectedOption = huongSelect.options[huongSelect.selectedIndex];
        const maHuong = selectedOption?.getAttribute('data-ma') || '';
        if (maHuong.startsWith('DEN_')) {
            doiTacGroup.style.display = 'block';
        } else {
            doiTacGroup.style.display = 'none';
            const doiTacSelect = document.getElementById('id_nguoi_gui_doi_tac');
            if (doiTacSelect) doiTacSelect.value = '';
        }
    }

    toggleDoiTacGroup(); // Khi load
    huongSelect.addEventListener('change', toggleDoiTacGroup);
});
