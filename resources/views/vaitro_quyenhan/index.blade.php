@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📋 Danh sách vai trò & phân quyền</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Mã vai trò</th>
                <th>Tên vai trò</th>
                <th>Quyền đã gán</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vaiTros as $vaiTro)
                <tr>
                    <td>{{ $vaiTro->id }}</td>
                    <td>{{ $vaiTro->ma_vai_tro }}</td>
                    <td>{{ $vaiTro->ten_vai_tro }}</td>
                    <td>
                        @foreach ($vaiTro->quyenHans as $qh)
                            <span class="badge bg-primary">{{ $qh->ten_quyen }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('vaitro_quyenhan.edit', $vaiTro->id) }}" class="btn btn-sm btn-warning">
                            ⚙️ Phân quyền
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
