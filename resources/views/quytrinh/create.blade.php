@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📝 Tạo bước xử lý mới</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('quytrinh.store') }}" method="POST">
        @csrf

        {{-- Hướng chứng từ --}}
        <div class="mb-3">
            <label for="id_huong" class="form-label">Hướng chứng từ</label>
            <select name="id_huong" id="id_huong" class="form-select" required>
                <option value="">-- Chọn hướng chứng từ --</option>
                @foreach ($dsHuong as $huong)
                    <option value="{{ $huong->id }}">
                        {{ $huong->ma_huong_chung_tu }} - {{ $huong->ten_huong_chung_tu }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Trạng thái từ --}}
        <div class="mb-3">
            <label for="id_tu_trang_thai" class="form-label">Từ trạng thái</label>
            <select name="id_tu_trang_thai" class="form-select" required>
                <option value="">-- Chọn trạng thái bắt đầu --</option>
                @foreach ($dsTrangThai as $tt)
                    <option value="{{ $tt->id }}">{{ $tt->ten }}</option>
                @endforeach
            </select>
        </div>

        {{-- Trạng thái đến --}}
        <div class="mb-3">
            <label for="id_den_trang_thai" class="form-label">Đến trạng thái</label>
            <select name="id_den_trang_thai" class="form-select" required>
                <option value="">-- Chọn trạng thái tiếp theo --</option>
                @foreach ($dsTrangThai as $tt)
                    <option value="{{ $tt->id }}">{{ $tt->ten }}</option>
                @endforeach
            </select>
        </div>

        {{-- Mô tả --}}
        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả bước xử lý (tùy chọn)</label>
            <input type="text" name="mo_ta" class="form-control" placeholder="Ví dụ: Trưởng phòng duyệt...">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('quytrinh.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Lưu bước xử lý</button>
        </div>
    </form>
</div>
@endsection
