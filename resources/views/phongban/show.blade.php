@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết phòng ban</h1>
    <div class="form-group">
        <label for="ma_phong_ban">Mã phòng ban</label>
        <input type="text" class="form-control" id="ma_phong_ban" name="ma_phong_ban" value="{{ $phongban->ma_phong_ban }}" readonly>
    </div>
    <div class="form-group">
        <label for="ten_phong_ban">Tên phòng ban</label>
        <input type="text" class="form-control" id="ten_phong_ban" name="ten_phong_ban" value="{{ $phongban->ten_phong_ban }}" readonly>
    </div>
    <a href="{{ route('phongban.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection