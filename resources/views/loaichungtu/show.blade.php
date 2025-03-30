@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết loại chứng từ</h1>
    <div class="form-group">
        <label for="ma_loai_chung_tu">Mã loại chứng từ</label>
        <input type="text" class="form-control" id="ma_loai_chung_tu" name="ma_loai_chung_tu" value="{{ $loaichungtu->ma_loai_chung_tu }}" readonly>
    </div>
    <div class="form-group">
        <label for="ten_loai_chung_tu">Tên loại chứng từ</label>
        <input type="text" class="form-control" id="ten_loai_chung_tu" name="ten_loai_chung_tu" value="{{ $loaichungtu->ten_loai_chung_tu }}" readonly>
    </div>
    <a href="{{ route('loaichungtu.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection