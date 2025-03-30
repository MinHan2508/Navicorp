@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách Trạng thái Chứng từ</h1>
    <a href="{{ route('trangthaichungtu.create') }}" class="btn btn-primary mb-3">Tạo mới Trạng thái</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã Trạng thái</th>
                <th>Tên Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trangThaiChungTus as $trangThai)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $trangThai->ma_trang_thai }}</td>
                <td>{{ $trangThai->ten_trang_thai }}</td>
                <td>
                    <a href="{{ route('trangthaichungtu.edit', $trangThai->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('trangthaichungtu.destroy', $trangThai->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection