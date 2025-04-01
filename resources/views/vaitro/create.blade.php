@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo Vai Trò Mới</h1>
    <form action="{{ route('vaitro.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="ma_vai_tro">Mã Vai Trò</label>
            <input type="text" name="ma_vai_tro" id="ma_vai_tro" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="ten_vai_tro">Tên Vai Trò</label>
            <input type="text" name="ten_vai_tro" id="ten_vai_tro" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="ghi_chu">Ghi Chú</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('vaitro.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection