@extends('layouts.app')
@section('content')
<div class="container">
    <h3>➕ Tạo quyền mới</h3>
    <form method="POST" action="{{ route('quyenhan.store') }}">
        @csrf
        <div class="mb-3">
            <label>Mã quyền</label>
            <input name="ma_quyen" class="form-control" value="{{ old('ma_quyen') }}" required>
        </div>
        <div class="mb-3">
            <label>Tên quyền</label>
            <input name="ten_quyen" class="form-control" value="{{ old('ten_quyen') }}" required>
        </div>
        <button class="btn btn-primary">Lưu</button>
        <a href="{{ route('quyenhan.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
