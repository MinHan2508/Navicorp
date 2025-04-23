@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Hiển thị lỗi tổng quát --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Đã có lỗi xảy ra:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1 class="mb-4 text-primary">
    📤 Tạo mới:
    <small class="text-muted ms-2">
        <span class="fw-bold text-success">{{ $tenHuong }}</span>
    </small>
    </h1>
    <div class="form-group mb-3">
            <label class="form-label">Người tạo</label>
            <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled>
            <input type="hidden" name="id_nguoi_tao" value="{{ auth()->user()->id }}">
        </div>
        
    {{-- Form chính --}}
    <form action="{{ route('chungtu.store') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        @csrf
        <input type="hidden" name="id_huong" value="{{ $huongMacDinh }}">
        @include('chungtu.partials._form_create', [
            'loaiChungTus' => $loaiChungTus,
            'doiTacs' => $doiTacs ?? [],
            'chungTu' => $chungTu ?? null
        ])

        {{-- Nút submit --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">💾 Lưu</button>
            <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">← Quay lại</a>
        </div>
    </form>
</div>
@endsection
