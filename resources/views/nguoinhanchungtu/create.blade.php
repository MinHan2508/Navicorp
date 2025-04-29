@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Gửi chứng từ: {{ $chungTu->tieu_de }}</h1>

    <form action="{{ route('nguoinhanchungtu.store', $chungTu->id) }}" method="POST">
        @csrf

        <!-- Chọn nhiều người dùng -->
        <div class="mb-4">
            <label for="id_users" class="form-label fw-bold">Chọn người dùng</label>
            <select name="id_users[]" id="id_users" class="form-select" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <div class="form-text">Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều người.</div>
        </div>

        <!-- Chọn nhiều phòng ban -->
        <div class="mb-4">
            <label for="id_phong_bans" class="form-label fw-bold">Chọn phòng ban</label>
            <select name="id_phong_bans[]" id="id_phong_bans" class="form-select" multiple>
                @foreach ($phongBans as $phongBan)
                    <option value="{{ $phongBan->id }}">{{ $phongBan->ten_phong_ban }}</option>
                @endforeach
            </select>
            <div class="form-text">Giữ Ctrl (hoặc Cmd) để chọn nhiều phòng ban.</div>
        </div>

        <!-- Chọn nhiều đối tác -->
        <div class="mb-4">
            <label for="id_doi_tacs" class="form-label fw-bold">Chọn đối tác</label>
            <select name="id_doi_tacs[]" id="id_doi_tacs" class="form-select" multiple>
                @foreach ($doiTacs as $doiTac)
                    <option value="{{ $doiTac->id }}">{{ $doiTac->ten_doi_tac }}</option>
                @endforeach
            </select>
            <div class="form-text">Giữ Ctrl (hoặc Cmd) để chọn nhiều đối tác.</div>
        </div>

        <!-- Ghi chú -->
        <div class="mb-4">
            <label for="ghi_chu" class="form-label fw-bold">Ghi chú (tuỳ chọn)</label>
            <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3" placeholder="Nhập ghi chú nếu cần..."></textarea>
        </div>

        <!-- Nút gửi -->
        <div class="mb-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-send"></i> Gửi chứng từ
            </button>
            <a href="{{ route('chungtu.index') }}" class="btn btn-secondary ms-2">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>
@endsection
