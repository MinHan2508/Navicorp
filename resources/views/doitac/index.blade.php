@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">📋 Danh sách Đối tác</h2>
            <a href="{{ route('doitac.create') }}" class="btn btn-outline-success">
    ➕ Tạo đối tác mới
</a>
        </div>
        <form method="GET" action="{{ route('doitac.index') }}" class="row g-2 mb-3">
            <div class="col-md-2">
                <input type="text" name="ten_doi_tac" class="form-control" placeholder="Tên đối tác"
                    value="{{ request('ten_doi_tac') }}">
            </div>
            <div class="col-md-2">
                <select name="loai_doi_tac" class="form-select">
                    <option value="">-- Loại --</option>
                    @foreach(['Cá nhân', 'Tổ chức', 'Nhà Nước', 'Khác'] as $loai)
                        <option value="{{ $loai }}" {{ request('loai_doi_tac') == $loai ? 'selected' : '' }}>{{ $loai }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="sdt" class="form-control" placeholder="SĐT" value="{{ request('sdt') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="ma_so_thue" class="form-control" placeholder="Mã số thuế"
                    value="{{ request('ma_so_thue') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="website" class="form-control" placeholder="Website"
                    value="{{ request('website') }}">
            </div>
            <div class="col-12 d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-primary me-2">🔍 Tìm kiếm</button>
                <a href="{{ route('doitac.index') }}" class="btn btn-secondary">↺ Đặt lại</a>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($danhSach->isEmpty())
            <div class="alert alert-info">Không có đối tác nào.</div>
        @else

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th>#</th>
                            <th style="min-width: 220px;">Tên đối tác</th>
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
                        @foreach ($danhSach as $doiTac)
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
                                    <a href="{{ route('doitac.show', $doiTac->id) }}" class="btn btn-sm btn-outline-info"
                                        title="Xem"><i class="bi bi-eye"></i></a>
                               

                                @php
                                    $vaiTro = auth()->user()->vaiTro->ma_vai_tro ?? '';
                                @endphp

                                @if($vaiTro === 'admin')
                                    <a href="{{ route('doitac.edit', $doiTac->id) }}" class="btn btn-sm btn-outline-warning"
                                        title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('doitac.destroy', $doiTac->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xoá đối tác này?')" title="Xoá">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $danhSach->appends(request()->query())->links() }}
            </div>

            <div class="mt-3">

                {{ $danhSach->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection