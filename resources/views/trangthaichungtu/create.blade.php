@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo mới Trạng thái Chứng từ</h1>
    <form action="{{ route('trangthaichungtu.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ma_trang_thai">Mã Trạng thái</label>
            <input type="text" name="ma_trang_thai" id="ma_trang_thai" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="ten_trang_thai">Tên Trạng thái</label>
            <input type="text" name="ten_trang_thai" id="ten_trang_thai" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
    </form>
</div>
@endsection