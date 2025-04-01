@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách Phòng Ban</h1>
    <a href="{{ route('phongban.create') }}" class="btn btn-primary mb-3">Tạo Phòng Ban Mới</a>

    @if($phongbans->isEmpty())
        <div class="alert alert-info">Không có phòng ban nào được tìm thấy.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mã Phòng Ban</th>
                    <th>Tên Phòng Ban</th>
                    <th>Ghi Chú</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($phongbans as $phongban)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $phongban->ma_phong_ban }}</td>
                    <td>{{ $phongban->ten_phong_ban }}</td>
                    <td>{{ $phongban->ghi_chu ?? 'Không có' }}</td>
                    <td>
                        <a href="{{ route('phongban.show', $phongban->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('phongban.edit', $phongban->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('phongban.destroy', $phongban->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection