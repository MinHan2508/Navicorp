@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa phòng ban</h1>
    <form action="{{ route('phongban.update', $phongban->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="ma_phong_ban">Mã phòng ban</label>
            <input type="text" class="form-control" id="ma_phong_ban" name="ma_phong_ban" value="{{ $phongban->ma_phong_ban }}" required>
        </div>
        <div class="form-group">
            <label for="ten_phong_ban">Tên phòng ban</label>
            <input type="text" class="form-control" id="ten_phong_ban" name="ten_phong_ban" value="{{ $phongban->ten_phong_ban }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection