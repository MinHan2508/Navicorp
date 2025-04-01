@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh Sửa Phòng Ban</h1>
    <form action="{{ route('phongban.update', $phongban->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="ma_phong_ban">Mã Phòng Ban</label>
            <input type="text" name="ma_phong_ban" id="ma_phong_ban" class="form-control" value="{{ $phongban->ma_phong_ban }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ten_phong_ban">Tên Phòng Ban</label>
            <input type="text" name="ten_phong_ban" id="ten_phong_ban" class="form-control" value="{{ $phongban->ten_phong_ban }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control">{{ $phongban->ghi_chu }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('phongban.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection