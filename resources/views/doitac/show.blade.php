@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-info">🔍 Chi tiết Đối tác</h2>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-primary">{{ $doiTac->ten_doi_tac }}</h4>
            <p><strong>Loại đối tác:</strong> {{ $doiTac->loai_doi_tac }}</p>
            <p><strong>Email:</strong> {{ $doiTac->email ?? '-' }}</p>
            <p><strong>SĐT:</strong> {{ $doiTac->sdt ?? '-' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $doiTac->dia_chi ?? '-' }}</p>
            <p><strong>Mã số thuế:</strong> {{ $doiTac->ma_so_thue ?? '-' }}</p>
            <p><strong>Fax:</strong> {{ $doiTac->fax ?? '-' }}</p>
            <p><strong>Người đại diện:</strong> {{ $doiTac->nguoi_dai_dien ?? '-' }}</p>
            <p><strong>Chức vụ đại diện:</strong> {{ $doiTac->chuc_vu_dai_dien ?? '-' }}</p>
            <p><strong>Website:</strong> {{ $doiTac->website ?? '-' }}</p>
            <p><strong>Ghi chú:</strong> {{ $doiTac->ghi_chu ?? '-' }}</p>
            <p><strong>Ngày tạo:</strong> {{ $doiTac->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('doitac.edit', $doiTac->id) }}" class="btn btn-warning">✏️ Chỉnh sửa</a>
        <a href="{{ route('doitac.index') }}" class="btn btn-secondary">← Quay lại</a>
    </div>
</div>
@endsection
