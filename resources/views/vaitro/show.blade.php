@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi Tiết Vai Trò</h1>
    <div class="form-group mb-3">
        <label for="ma_vai_tro">Mã Vai Trò</label>
        <input type="text" class="form-control" id="ma_vai_tro" value="{{ $vaiTro->ma_vai_tro }}" readonly>
    </div>
    <div class="form-group mb-3">
        <label for="ten_vai_tro">Tên Vai Trò</label>
        <input type="text" class="form-control" id="ten_vai_tro" value="{{ $vaiTro->ten_vai_tro }}" readonly>
    </div>
    <div class="form-group mb-3">
        <label for="ghi_chu">Ghi Chú</label>
        <textarea class="form-control" id="ghi_chu" readonly>{{ $vaiTro->ghi_chu }}</textarea>
    </div>
    <a href="{{ route('vaitro.index') }}" class="btn btn-secondary">Quay Lại</a>
</div>
@endsection