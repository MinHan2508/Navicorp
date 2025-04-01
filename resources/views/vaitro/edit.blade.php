@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh Sửa Vai Trò</h1>
    <form action="{{ route('vaitro.update', $vaiTro->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="ma_vai_tro">Mã Vai Trò</label>
            <input type="text" class="form-control" id="ma_vai_tro" name="ma_vai_tro" value="{{ $vaiTro->ma_vai_tro }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ten_vai_tro">Tên Vai Trò</label>
            <input type="text" class="form-control" id="ten_vai_tro" name="ten_vai_tro" value="{{ $vaiTro->ten_vai_tro }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea class="form-control" id="ghi_chu" name="ghi_chu">{{ $vaiTro->ghi_chu }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('vaitro.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection