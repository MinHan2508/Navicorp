@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary">✏️ Chỉnh sửa Đối Tác</h2>

    {{-- ✅ Form update --}}
    <form action="{{ route('doitac.update', $doiTac->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="ten_doi_tac">Tên Đối Tác</label>
            <input type="text" name="ten_doi_tac" id="ten_doi_tac" class="form-control" value="{{ old('ten_doi_tac', $doiTac->ten_doi_tac) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $doiTac->email) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="sdt">Số Điện Thoại</label>
            <input type="text" name="sdt" id="sdt" class="form-control" value="{{ old('sdt', $doiTac->sdt) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="dia_chi">Địa Chỉ</label>
            <input type="text" name="dia_chi" id="dia_chi" class="form-control" value="{{ old('dia_chi', $doiTac->dia_chi) }}">
        </div>

        <div class="form-group mb-4">
            <label for="loai_doi_tac">Loại Đối Tác</label>
            <select name="loai_doi_tac" id="loai_doi_tac" class="form-control" required>
                @foreach (['Cá nhân', 'Tổ chức', 'Nhà Nước', 'Khác'] as $loai)
                    <option value="{{ $loai }}" {{ old('loai_doi_tac', $doiTac->loai_doi_tac) === $loai ? 'selected' : '' }}>
                        {{ $loai }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
        <a href="{{ route('doitac.index') }}" class="btn btn-secondary">← Hủy</a>
    </form>
</div>
@endsection
