@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tạo Phòng Ban Mới</h1>
    <form action="{{ route('phongban.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="ma_phong_ban">Mã Phòng Ban</label>
            <input type="text" name="ma_phong_ban" id="ma_phong_ban" class="form-control" value="{{ old('ma_phong_ban') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ten_phong_ban">Tên Phòng Ban</label>
            <input type="text" name="ten_phong_ban" id="ten_phong_ban" class="form-control" value="{{ old('ten_phong_ban') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control">{{ old('ghi_chu') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('phongban.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection