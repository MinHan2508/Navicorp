@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo loại chứng từ mới</h1>
    <form action="{{ route('loaichungtu.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ma_loai_chung_tu">Mã loại chứng từ</label>
            <input type="text" class="form-control" id="ma_loai_chung_tu" name="ma_loai_chung_tu" required>
        </div>
        <div class="form-group">
            <label for="ten_loai_chung_tu">Tên loại chứng từ</label>
            <input type="text" class="form-control" id="ten_loai_chung_tu" name="ten_loai_chung_tu" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>
@endsection