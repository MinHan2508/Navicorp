
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tạo mới Đối Tác</h1>
    <form action="{{ route('doitac.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="ten_doi_tac">Tên Đối Tác</label>
            <input type="text" name="ten_doi_tac" id="ten_doi_tac" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sdt">Số Điện Thoại</label>
            <input type="text" name="sdt" id="sdt" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="dia_chi">Địa Chỉ</label>
            <input type="text" name="dia_chi" id="dia_chi" class="form-control">
        </div>
        <div class="form-group">
            <label for="loai_doi_tac">Loại Đối Tác</label>
            <select name="loai_doi_tac" id="loai_doi_tac" class="form-control" required>
                <option value="Cá nhân">Cá nhân</option>
                <option value="Tổ chức">Tổ chức</option>
                <option value="Nhà Nước">Nhà Nước</option>
                <option value="Khác">Khác</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('doitac.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection