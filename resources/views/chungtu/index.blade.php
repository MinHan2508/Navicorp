@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách Chứng từ</h1>
    <a href="{{ route('chungtu.create') }}" class="btn btn-primary mb-3">Tạo mới Chứng từ</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chungTus as $chungTu)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $chungTu->name }}</td>
                <td>{{ $chungTu->description }}</td>
                <td>
                    <a href="{{ route('chungtu.show', $chungTu->id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('chungtu.edit', $chungTu->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('chungtu.destroy', $chungTu->id) }}" method="POST" style="display:inline;">
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