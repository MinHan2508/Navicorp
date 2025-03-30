@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa loại chứng từ</h1>
    <form action="{{ route('loaichungtu.update', $loaichungtu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ma_loai_chung_tu">Mã loại chứng từ</label>
            <input type="text" class="form-control" id="ma_loai_chung_tu" name="ma_loai_chung_tu" value="{{ $loaichungtu->ma_loai_chung_tu }}" required>
        </div>
        <div class="form-group">
            <label for="ten_loai_chung_tu">Tên loại chứng từ</label>
            <input type="text" class="form-control" id="ten_loai_chung_tu" name="ten_loai_chung_tu" value="{{ $loaichungtu->ten_loai_chung_tu }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection