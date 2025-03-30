@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo phân công mới</h1>
    <form action="{{ route('phancong.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">Người dùng</label>
            <select class="form-control" id="user_id" name="user_id" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="phongban_id">Phòng ban</label>
            <select class="form-control" id="phongban_id" name="phongban_id" required>
                @foreach($phongbans as $phongban)
                <option value="{{ $phongban->id }}">{{ $phongban->ten_phong_ban }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>
@endsection