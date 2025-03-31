@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi tiết Đối Tác</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Tên Đối Tác:</strong> {{ $doiTac->ten_doi_tac }}</p>
            <p><strong>Email:</strong> {{ $doiTac->email }}</p>
            <p><strong>Số Điện Thoại:</strong> {{ $doiTac->sdt }}</p>
            <p><strong>Địa Chỉ:</strong> {{ $doiTac->dia_chi }}</p>
            <p><strong>Loại Đối Tác:</strong> {{ $doiTac->loai_doi_tac }}</p>
        </div>
    </div>
    <a href="{{ route('doitac.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection