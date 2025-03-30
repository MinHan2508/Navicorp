
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chỉnh sửa Chứng từ</h1>
    <form action="{{ route('chungtu.update', $chungTu->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $chungTu->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea name="description" id="description" class="form-control">{{ $chungTu->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
    </form>
</div>
@endsection