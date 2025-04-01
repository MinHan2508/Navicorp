@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách Vai Trò</h1>
    <a href="{{ route('vaitro.create') }}" class="btn btn-primary mb-3">Tạo Vai Trò Mới</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã Vai Trò</th>
                <th>Tên Vai Trò</th>
                <th>Ghi Chú</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vaiTros as $vaiTro)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $vaiTro->ma_vai_tro }}</td>
                <td>{{ $vaiTro->ten_vai_tro }}</td>
                <td>{{ $vaiTro->ghi_chu ?? 'Không có' }}</td>
                <td>
                    <a href="{{ route('vaitro.show', $vaiTro->id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('vaitro.edit', $vaiTro->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('vaitro.destroy', $vaiTro->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection