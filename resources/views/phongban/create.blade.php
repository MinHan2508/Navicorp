@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo phòng ban mới</h1>
    <form action="{{ route('phongban.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="ma_phong_ban">Mã phòng ban</label>
            <input type="text" class="form-control" id="ma_phong_ban" name="ma_phong_ban" required>
        </div>
        <div class="form-group">
            <label for="ten_phong_ban">Tên phòng ban</label>
            <input type="text" class="form-control" id="ten_phong_ban" name="ten_phong_ban" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>
@endsection