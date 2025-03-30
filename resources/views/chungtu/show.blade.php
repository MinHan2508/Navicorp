@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết Chứng từ</h1>
    <div class="mb-3">
        <strong>Tên:</strong> {{ $chungTu->name }}
    </div>
    <div class="mb-3">
        <strong>Mô tả:</strong> {{ $chungTu->description }}
    </div>
    <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection