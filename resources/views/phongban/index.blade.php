@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách phòng ban</h1>
    <a href="{{ route('phongban.create') }}" class="btn btn-primary">Tạo phòng ban mới</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Mã phòng ban</th>
                <th>Tên phòng ban</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($phongbans as $phongban)
            <tr>
                <td>{{ $phongban->ma_phong_ban }}</td>
                <td>{{ $phongban->ten_phong_ban }}</td>
                <td>
                    <a href="{{ route('phongban.show', $phongban->id) }}" class="btn btn-info">Xem</a>
                    <a href="{{ route('phongban.edit', $phongban->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('phongban.destroy', $phongban->id) }}" method="POST" style="display:inline-block;">
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