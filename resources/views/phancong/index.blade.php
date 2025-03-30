@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách phân công</h1>
    <a href="{{ route('phancong.create') }}" class="btn btn-primary">Tạo phân công mới</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>Chức vụ</th>
                <th>Phòng ban</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($phancongs as $phancong)
            <tr>
                <td>{{ $phancong->user->name }}</td>
                <td>{{ $phancong->user->vaitro }}</td>
                <td>{{ $phancong->phongban->ten_phong_ban }}</td>
                <td>
                    <a href="{{ route('phancong.show', $phancong->id) }}" class="btn btn-info">Xem</a>
                    <a href="{{ route('phancong.edit', $phancong->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('phancong.destroy', $phancong->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection