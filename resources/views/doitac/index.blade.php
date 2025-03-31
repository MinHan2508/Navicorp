@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách Đối Tác</h1>
    <a href="{{ route('doitac.create') }}" class="btn btn-primary mb-3">Tạo mới Đối Tác</a>

    @if($doiTacs->isEmpty())
        <div class="alert alert-info">Không có đối tác nào được tìm thấy.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Đối Tác</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Địa Chỉ</th>
                    <th>Loại Đối Tác</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doiTacs as $doiTac)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $doiTac->ten_doi_tac }}</td>
                    <td>{{ $doiTac->email }}</td>
                    <td>{{ $doiTac->sdt }}</td>
                    <td>{{ $doiTac->dia_chi }}</td>
                    <td>{{ $doiTac->loai_doi_tac }}</td>
                    <td>
                        <a href="{{ route('doitac.show', $doiTac->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('doitac.edit', $doiTac->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('doitac.destroy', $doiTac->id) }}" method="POST" style="display:inline;">
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