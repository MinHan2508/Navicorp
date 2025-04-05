@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">📋 Danh sách Đối tác</h2>
        <a href="{{ route('doitac.create') }}" class="btn btn-success">➕ Thêm mới</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($doiTacs->isEmpty())
        <div class="alert alert-info">Không có đối tác nào.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Tên đối tác</th>
                        <th>Loại</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Người đại diện</th>
                        <th>Mã số thuế</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doiTacs as $doiTac)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $doiTac->ten_doi_tac }}</td>
                        <td>{{ $doiTac->loai_doi_tac }}</td>
                        <td>{{ $doiTac->email ?? '-' }}</td>
                        <td>{{ $doiTac->sdt ?? '-' }}</td>
                        <td>{{ $doiTac->nguoi_dai_dien ?? '-' }}</td>
                        <td>{{ $doiTac->ma_so_thue ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('doitac.edit', $doiTac->id) }}" class="btn btn-sm btn-warning">✏️</a>
                            <form action="{{ route('doitac.destroy', $doiTac->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xoá đối tác này?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $doiTacs->links() }}
        </div>
    @endif
</div>
@endsection
