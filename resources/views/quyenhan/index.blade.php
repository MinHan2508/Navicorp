@extends('layouts.app')
@section('content')
<div class="container">
    <h3>📋 Danh sách quyền hạn</h3>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <a href="{{ route('quyenhan.create') }}" class="btn btn-primary mb-3">➕ Thêm quyền mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã quyền</th>
                <th>Tên quyền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quyenHans as $q)
                <tr>
                    <td>{{ $q->id }}</td>
                    <td>{{ $q->ma_quyen }}</td>
                    <td>{{ $q->ten_quyen }}</td>
                    <td>
                        <a href="{{ route('quyenhan.edit', $q) }}" class="btn btn-sm btn-warning">✏️</a>
                        <form action="{{ route('quyenhan.destroy', $q) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xoá?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
