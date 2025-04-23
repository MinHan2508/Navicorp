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
        <form action="{{ route('chungtu.store') }}" method="POST" enctype="multipart/form-data"
            class="shadow p-4 rounded bg-light">

            <div id="doiTacGroup" class="form-group mb-3" style="display: none;">
                <label for="id_nguoi_gui_doi_tac" class="form-label">Đối tác/ Đơn vị gửi bên ngoài</label>
                <select name="id_nguoi_gui_doi_tac" id="id_nguoi_gui_doi_tac" class="form-select @error('id_nguoi_gui_doi_tac') is-invalid @enderror">
                    <option value="">-- Chọn Đối Tác --</option>
                    @foreach($doiTacs as $doiTac)
                        <option value="{{ $doiTac->id }}"
                            {{ old('id_nguoi_gui_doi_tac', $chungTu->id_nguoi_gui_doi_tac ?? '') == $doiTac->id ? 'selected' : '' }}>
                            {{ $doiTac->ten_doi_tac }}
                        </option>
                    @endforeach
                </select>
                @error('id_nguoi_gui_doi_tac')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Hướng chứng từ --}}

            {{-- CSRF token --}}    
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
