function hideLoading() {
    document.getElementById('file-preview-loading')?.classList.add('d-none');
    document.getElementById('file-preview-content')?.classList.remove('d-none');
}

function xacNhanTuChoi() {
    const ghiChu = document.getElementById('ghi_chu').value.trim();
    if (!ghiChu) {
        document.getElementById('ghi-chu-error').classList.remove('d-none');
        return;
    }
    document.getElementById('ghi-chu-error').classList.add('d-none');

    Swal.fire({
        title: 'Bạn có chắc muốn từ chối?',
        text: 'Lý do: ' + ghiChu,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Có, từ chối!',
        cancelButtonText: 'Huỷ',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('form-xuly');
            const inputTuChoi = document.createElement('input');
            inputTuChoi.type = 'hidden';
            inputTuChoi.name = 'tu_choi';
            inputTuChoi.value = '1';
            form.appendChild(inputTuChoi);
            form.submit();
        }
    });
}


function xacNhanDuyet(thuTu, moTa) {
    Swal.fire({
        title: 'Xác nhận duyệt?',
        text: `Bạn có chắc chắn muốn duyệt bước: "${moTa}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Duyệt',
        cancelButtonText: 'Huỷ',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('form-xuly');
            const inputThuTu = document.createElement('input');
            inputThuTu.type = 'hidden';
            inputThuTu.name = 'thu_tu';
            inputThuTu.value = thuTu;
            form.appendChild(inputThuTu);
            form.submit();
        }
    });
}

