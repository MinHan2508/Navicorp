@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-info">Thông tin chi tiết Đối tác</h2>
        <div>
            
            <a href="{{ route('doitac.index') }}" class="btn btn-secondary">
                ← Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h4>Tên đối tác: </h4>
            <h4 class="text-primary mb-0"> {{ $doiTac->ten_doi_tac }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6"><strong>Loại đối tác:</strong> {{ $doiTac->loai_doi_tac }}</div>
                <div class="col-md-6"><strong>Email:</strong> {{ $doiTac->email ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Số điện thoại:</strong> {{ $doiTac->sdt ?? '-' }}</div>
                <div class="col-md-6"><strong>Địa chỉ:</strong> {{ $doiTac->dia_chi ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Mã số thuế:</strong> {{ $doiTac->ma_so_thue ?? '-' }}</div>
                <div class="col-md-6"><strong>Fax:</strong> {{ $doiTac->fax ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Người đại diện:</strong> {{ $doiTac->nguoi_dai_dien ?? '-' }}</div>
                <div class="col-md-6"><strong>Chức vụ:</strong> {{ $doiTac->chuc_vu_dai_dien ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Website:</strong> {{ $doiTac->website ?? '-' }}</div>
                <div class="col-md-6"><strong>Ghi chú:</strong> {{ $doiTac->ghi_chu ?? '-' }}</div>
            </div>
            <div class="text-end text-muted">
                <small>Ngày tạo: {{ $doiTac->created_at->format('d/m/Y H:i') }}</small>
            </div>
        </div>
    </div>
</div>
@endsection
