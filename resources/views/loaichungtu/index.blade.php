@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách Loại Chứng Từ</h1>
    <a href="{{ route('loaichungtu.create') }}" class="btn btn-primary mb-3">Tạo Loại Chứng Từ Mới</a>

    @if($loaichungtus->isEmpty())
        <div class="alert alert-info">Không có loại chứng từ nào được tìm thấy.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mã Loại Chứng Từ</th>
                    <th>Tên Loại Chứng Từ</th>
                    <th>Ghi Chú</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loaichungtus as $loaichungtu)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $loaichungtu->ma_loai_chung_tu }}</td>
                    <td>{{ $loaichungtu->ten_loai_chung_tu }}</td>
                    <td>{{ $loaichungtu->ghi_chu ?? 'Không có' }}</td>
                    <td>
                        <a href="{{ route('loaichungtu.show', $loaichungtu->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('loaichungtu.edit', $loaichungtu->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('loaichungtu.destroy', $loaichungtu->id) }}" method="POST" style="display:inline;">
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