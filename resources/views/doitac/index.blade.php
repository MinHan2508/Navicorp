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
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th>#</th>
                        <th style="min-width: 220px;" >Tên đối tác</th>
                        <th>Loại</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Mã số thuế</th>
                        <th>Fax</th>
                        <th>Người đại diện</th>
                        <th>Chức vụ</th>
                        <th>Website</th>
                        <th>Địa chỉ</th>
                        <th>Ghi chú</th>
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
                        <td>{{ $doiTac->ma_so_thue ?? '-' }}</td>
                        <td>{{ $doiTac->fax ?? '-' }}</td>
                        <td>{{ $doiTac->nguoi_dai_dien ?? '-' }}</td>
                        <td>{{ $doiTac->chuc_vu_dai_dien ?? '-' }}</td>
                        <td>
                            @if($doiTac->website)
                                <a href="{{ $doiTac->website }}" target="_blank">{{ $doiTac->website }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $doiTac->dia_chi ?? '-' }}</td>
                        <td>{{ $doiTac->ghi_chu ?? '-' }}</td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('doitac.show', $doiTac->id) }}" class="btn btn-sm btn-outline-info" title="Xem"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('doitac.edit', $doiTac->id) }}" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('doitac.destroy', $doiTac->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá đối tác này?')" title="Xoá">
                                    <i class="bi bi-trash"></i>
                                </button>
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
