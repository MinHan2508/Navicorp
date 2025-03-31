@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách Chứng từ</h1>
    <a href="{{ route('chungtu.create') }}" class="btn btn-primary mb-3">Tạo mới Chứng từ</a>

    @if($chungTus->isEmpty())
        <div class="alert alert-info">Không có chứng từ nào được tìm thấy.</div>
    @else
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Mã Chứng Từ</th>
                    <th>Tiêu Đề</th>
                    <th>Loại Chứng Từ</th>
                    <th>Trạng Thái</th>
                    <th>Người Tạo</th>
                    <th>Ngày Tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chungTus as $chungTu)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $chungTu->ma_chung_tu }}</td>
                    <td>{{ $chungTu->tieu_de }}</td>
                    <td>{{ $chungTu->loaiChungTu->ten_loai_chung_tu ?? 'N/A' }}</td>
                    <td>{{ $chungTu->trangThai->ten_trang_thai ?? 'N/A' }}</td>
                    <td>{{ $chungTu->nguoiTao->name ?? 'N/A' }} - {{ $chungTu->nguoiTao->email ?? 'N/A' }}</td>
                    <td>{{ $chungTu->created_at->format('d/m/Y') }}</td>
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
    @endif
</div>
@endsection