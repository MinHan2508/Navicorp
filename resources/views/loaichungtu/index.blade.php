@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách loại chứng từ</h1>
    <a href="{{ route('loaichungtu.create') }}" class="btn btn-primary">Tạo loại chứng từ mới</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Mã loại chứng từ</th>
                <th>Tên loại chứng từ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loaichungtus as $loaichungtu)
            <tr>
                <td>{{ $loaichungtu->ma_loai_chung_tu }}</td>
                <td>{{ $loaichungtu->ten_loai_chung_tu }}</td>
                <td>
                    <a href="{{ route('loaichungtu.show', $loaichungtu->id) }}" class="btn btn-info">Xem</a>
                    <a href="{{ route('loaichungtu.edit', $loaichungtu->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('loaichungtu.destroy', $loaichungtu->id) }}" method="POST" style="display:inline-block;">
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