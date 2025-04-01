@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách Hướng Chứng Từ</h1>
    <a href="{{ route('huongchungtu.create') }}" class="btn btn-primary mb-3">Tạo Hướng Chứng Từ Mới</a>

    @if($huongChungTus->isEmpty())
        <div class="alert alert-info">Không có hướng chứng từ nào được tìm thấy.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mã Hướng Chứng Từ</th>
                    <th>Tên Hướng Chứng Từ</th>
                    <th>Ghi Chú</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($huongChungTus as $huongChungTu)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $huongChungTu->ma_huong_chung_tu }}</td>
                    <td>{{ $huongChungTu->ten_huong_chung_tu }}</td>
                    <td>{{ $huongChungTu->ghi_chu ?? 'Không có' }}</td>
                    <td>
                        <a href="{{ route('huongchungtu.show', $huongChungTu->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('huongchungtu.edit', $huongChungTu->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('huongchungtu.destroy', $huongChungTu->id) }}" method="POST" style="display:inline;">
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