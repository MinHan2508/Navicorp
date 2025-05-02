document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById('id_nguoi_gui_doi_tac');
    const box = document.getElementById('thong-tin-doi-tac');

    const fields = {
        'dt-ten': 'data-ten',
        'dt-email': 'data-email',
        'dt-sdt': 'data-sdt',
        'dt-diachi': 'data-diachi',
        'dt-mst': 'data-mst',
        'dt-nguoi': 'data-nguoi',
        'dt-chucvu': 'data-chucvu',
        'dt-fax': 'data-fax',
        'dt-website': 'data-website',
        'dt-ghichu': 'data-ghichu',
    };

    if (!select || !box) return;

    select.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        if (!opt || !opt.getAttribute('data-ten')) {
            box.classList.add('d-none');
            return;
        }

        for (const [spanId, attr] of Object.entries(fields)) {
            const el = document.getElementById(spanId);
            if (el) el.innerText = opt.getAttribute(attr) || '-';
        }

        box.classList.remove('d-none');
    });
});
