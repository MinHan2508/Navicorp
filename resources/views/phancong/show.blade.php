@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết phân công</h1>
    <div class="form-group">
        <label for="user_id">Người dùng</label>
        <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $phancong->user->name }}" readonly>
    </div>
    <div class="form-group">
        <label for="phongban_id">Phòng ban</label>
        <input type="text" class="form-control" id="phongban_id" name="phongban_id" value="{{ $phancong->phongban->ten_phong_ban }}" readonly>
    </div>
    <a href="{{ route('phancong.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection