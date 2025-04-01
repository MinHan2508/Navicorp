@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Loại Chứng Từ</h1>
    <div class="form-group mb-3">
        <label for="ma_loai_chung_tu">Mã Loại Chứng Từ</label>
        <input type="text" class="form-control" id="ma_loai_chung_tu" value="{{ $loaichungtu->ma_loai_chung_tu }}" readonly>
    </div>
    <div class="form-group mb-3">
        <label for="ten_loai_chung_tu">Tên Loại Chứng Từ</label>
        <input type="text" class="form-control" id="ten_loai_chung_tu" value="{{ $loaichungtu->ten_loai_chung_tu }}" readonly>
    </div>
    <div class="form-group mb-3">
        <label for="ghi_chu">Ghi Chú</label>
        <textarea class="form-control" id="ghi_chu" readonly>{{ $loaichungtu->ghi_chu }}</textarea>
    </div>
    <a href="{{ route('loaichungtu.index') }}" class="btn btn-secondary">Quay Lại</a>
</div>
@endsection