@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh Sửa Quyền Hạn</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('quyenhan.update', $quyenHan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="ma_quyen">Mã Quyền</label>
            <input type="text" name="ma_quyen" id="ma_quyen" class="form-control"
                   value="{{ old('ma_quyen', $quyenHan->ma_quyen) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="ten_quyen">Tên Quyền</label>
            <input type="text" name="ten_quyen" id="ten_quyen" class="form-control"
                   value="{{ old('ten_quyen', $quyenHan->ten_quyen) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('quyenhan.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
