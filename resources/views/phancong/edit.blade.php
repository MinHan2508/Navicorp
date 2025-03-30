@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa phân công</h1>
    <form action="{{ route('phancong.update', $phancong->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="user_id">Người dùng</label>
            <select class="form-control" id="user_id" name="user_id" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $phancong->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="phongban_id">Phòng ban</label>
            <select class="form-control" id="phongban_id" name="phongban_id" required>
                @foreach($phongbans as $phongban)
                <option value="{{ $phongban->id }}" {{ $phancong->phongban_id == $phongban->id ? 'selected' : '' }}>{{ $phongban->ten_phong_ban }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection