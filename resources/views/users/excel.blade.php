@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">📥 Nhập danh sách người dùng từ Excel</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('users.importExcel') }}" method="POST" enctype="multipart/form-data">
        @csrf        

        <div class="mb-3">
            <label for="file" class="form-label">Chọn file Excel (.xlsx, .csv)</label>
            <input type="file" name="file" id="file" class="form-control" required accept=".xlsx,.xls,.csv">
        </div>

        <button type="submit" class="btn btn-primary">📤 Nhập dữ liệu</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">← Quay lại danh sách</a>
    </form>

    <hr>
    <p><strong>Gợi ý cột cần có:</strong> name, email, password, sdt, dia_chi, gioi_tinh, ngay_sinh, id_vaitro, id_phongban, trang_thai</p>
</div>
@endsection