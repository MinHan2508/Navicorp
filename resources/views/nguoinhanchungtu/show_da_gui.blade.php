@extends('layouts.app')

@section('content')
    <div class="container" >
        <h3 class="mb-4" margin-top="40px">📤 Danh sách chứng từ đã gửi</h3>

        {{-- Thông tin tổng quan chứng từ --}}
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Mã chứng từ:</strong> {{ $chungTu->ma_chung_tu }}</div>
                    <div class="col-md-4"><strong>Tiêu đề:</strong> {{ $chungTu->tieu_de }}</div>
                    <div class="col-md-4"><strong>Loại chứng từ:</strong>
                        {{ $chungTu->loaiChungTu->ten_loai_chung_tu ?? '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Thông tin người gửi --}}
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                    placeholder="🔍 Tìm theo tên, email, phòng ban hoặc đối tác...">
                <button class="btn btn-outline-secondary" type="submit">Tìm</button>
            </div>
        </form>
        {{-- Danh sách người nhận theo nhóm --}}
        <div class="card shadow-sm">
            <div class="card-body">
                @php
                    $users = $nguoiNhans->where('loai_nguoi_nhan', 'user');
                    $phongBans = $nguoiNhans->where('loai_nguoi_nhan', 'phong_ban');
                    $doiTacs = $nguoiNhans->where('loai_nguoi_nhan', 'doi_tac');
                @endphp

                @if($nguoiNhans->isEmpty())
                    <div class="alert alert-info">Chưa có ai nhận chứng từ này.</div>
                @else
                    {{-- Nhóm: Cá nhân --}}
                    <h5 class="mt-3">👤 Cá nhân ({{ $users->count() }})</h5>
                    @if($users->isEmpty())
                        <div class="text-muted">Không có người nhận cá nhân.</div>
                    @else
                        <ul class="list-group list-group-flush mb-3">
                            @foreach ($users as $item)
                                <li class="list-group-item">
                                    <strong>{{ $item->nguoiNhan->name ?? '[Đã xoá]' }}</strong>
                                    <small class="text-muted">({{ $item->nguoiNhan->email ?? 'Không có email' }})</small>
                                    @if ($item->ghi_chu)
                                        <div class="text-muted small">📝 {{ $item->ghi_chu }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- Nhóm: Phòng ban --}}
                    <h5 class="mt-3">🏢 Phòng ban ({{ $phongBans->count() }})</h5>
                    @if($phongBans->isEmpty())
                        <div class="text-muted">Không có phòng ban nhận.</div>
                    @else
                        <ul class="list-group list-group-flush mb-3">
                            @foreach ($phongBans as $item)
                                <li class="list-group-item">
                                    <strong>{{ $item->phongBan->ten_phong_ban ?? '[Đã xoá]' }}</strong>
                                    @if ($item->ghi_chu)
                                        <div class="text-muted small">📝 {{ $item->ghi_chu }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                   
                    {{-- Nhóm: Đối tác --}}
                    <h5 class="mt-3">🤝 Đối tác ({{ $doiTacs->count() }})</h5>
                    @if($doiTacs->isEmpty())
                        <div class="text-muted">Không có đối tác nhận.</div>
                    @else
                        <ul class="list-group list-group-flush mb-3">
                            @foreach ($doiTacs as $item)
                                <li class="list-group-item">
                                    <strong>{{ $item->doiTac->ten_doi_tac ?? '[Đã xoá]' }}</strong>
                                    <small class="text-muted">({{ $item->doiTac->email ?? 'Không có email' }})</small>
                                    @if ($item->ghi_chu)
                                        <div class="text-muted small">📝 {{ $item->ghi_chu }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endif
            </div>
        </div>

        <a href="{{ route('chungtu.show', $chungTu->id) }}" class="btn btn-secondary mt-4">
            ← Quay lại chứng từ
        </a>
    </div>
@endsection