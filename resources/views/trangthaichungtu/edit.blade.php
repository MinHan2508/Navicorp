@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chỉnh sửa Trạng thái Chứng từ</h1>
    <form action="{{ route('trangthaichungtu.update', $trangThaiChungTu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ma_trang_thai">Mã Trạng thái</label>
            <input type="text" name="ma_trang_thai" id="ma_trang_thai" class="form-control" value="{{ $trangThaiChungTu->ma_trang_thai }}" required>
        </div>
        <div class="form-group">
            <label for="ten_trang_thai">Tên Trạng thái</label>
            <input type="text" name="ten_trang_thai" id="ten_trang_thai" class="form-control" value="{{ $trangThaiChungTu->ten_trang_thai }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
</div>
@endsection