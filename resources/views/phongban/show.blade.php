@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Phòng Ban</h1>
    <div class="form-group mb-3">
        <label for="ma_phong_ban">Mã Phòng Ban</label>
        <input type="text" class="form-control" id="ma_phong_ban" value="{{ $phongban->ma_phong_ban }}" readonly>
    </div>
    <div class="form-group mb-3">
        <label for="ten_phong_ban">Tên Phòng Ban</label>
        <input type="text" class="form-control" id="ten_phong_ban" value="{{ $phongban->ten_phong_ban }}" readonly>
    </div>
    <div class="form-group mb-3">
        <label for="ghi_chu">Ghi Chú</label>
        <textarea class="form-control" id="ghi_chu" readonly>{{ $phongban->ghi_chu }}</textarea>
    </div>
    <a href="{{ route('phongban.index') }}" class="btn btn-secondary">Quay Lại</a>
</div>
@endsection