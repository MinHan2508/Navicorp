@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
    @php
    $filterLabels = [
        'tao_moi' => 'Đã Khởi Tạo',
        'cho_truong_phong' => 'Chờ Trưởng phòng duyệt',
        'cho_lanh_dao' => 'Chờ Lãnh đạo duyệt',
        'da_duyet' => 'Đã Duyệt',
        'cho_ky_so' => 'Chờ Ký số',
        'da_ky_so' => 'Đã Ký số',
        'cho_gui' => 'Chờ Gửi đi',
        'da_gui_di' => 'Đã Gửi đi',
        'tu_choi' => 'Bị Từ chối',
    ];

    $filter = request('filter');
@endphp

<h2 class="text-primary">
    📄 Danh sách Chứng từ
    @if($filter && isset($filterLabels[$filter]))
        : <span class="fw-bold text-danger">{{ $filterLabels[$filter] }}</span>
    @endif
</h2>

        <a href="{{ route('chungtu.create') }}" class="btn btn-success">➕ Tạo mới</a>
    </div>

    @if($chungTus->isEmpty())
        <div class="alert alert-info">Không có chứng từ nào được tìm thấy.</div>
    @else

    <form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <input type="text" name="ma_chung_tu" value="{{ request('ma_chung_tu') }}" class="form-control" placeholder="🔎 Tìm mã chứng từ">
    </div>
    <div class="col-md-3">
        <input type="text" name="tieu_de" value="{{ request('tieu_de') }}" class="form-control" placeholder="🔎 Tìm tiêu đề">
    </div>
    <div class="col-md-3">
        <input type="text" name="so_hieu" value="{{ request('so_hieu') }}" class="form-control" placeholder="🔎 Tìm số hiệu">
    </div>
    <div class="col-md-3">
        <input type="text" name="loai" value="{{ request('loai') }}" class="form-control" placeholder="🔎 Tìm loại chứng từ">
    </div>
    <div class="col-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
        <a href="{{ route('chungtu.index') }}" class="btn btn-outline-secondary">Đặt lại</a>
    </div>
</form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Mã</th>
                        <th>Tiêu đề</th>
                        <th>Số hiệu</th>
                        <th>Loại</th>
                        <th>Trích yếu</th>
                        <th>Nơi ban hành</th>
                        <th>Ngày ban hành</th>
                        <th>Hiệu lực</th>
                        
                        <th>Hướng</th>
                        <th>Trạng thái</th>
                        <th>Người tạo</th>
                        <th>Phòng ban</th>
                        <th>Đối tác</th>
                        <th>Ngày tạo</th>
                        <th>Ký số</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chungTus as $chungTu)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $chungTu->ma_chung_tu }}</td>
                        <td>{{ $chungTu->tieu_de }}</td>
                        <td>{{ $chungTu->so_hieu ?? '-' }}</td>
                        <td><span class="badge bg-info">{{ $chungTu->loaiChungTu->ten_loai_chung_tu ?? 'N/A' }}</span></td>
                        <td>{{ $chungTu->trich_yeu ?? '-' }}</td>
                        <td>{{ $chungTu->noi_ban_hanh ?? '-' }}</td>
                        <td class="text-center">
                            {{ $chungTu->ngay_ban_hanh ? \Carbon\Carbon::parse($chungTu->ngay_ban_hanh)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="text-center">
                            @if($chungTu->ngay_hieu_luc)
                                {{ \Carbon\Carbon::parse($chungTu->ngay_hieu_luc)->format('d/m/Y') }}
                                <br>→
                                {{ $chungTu->ngay_het_hieu_luc ? \Carbon\Carbon::parse($chungTu->ngay_het_hieu_luc)->format('d/m/Y') : 'Không rõ' }}
                            @else
                                -
                            @endif
                        </td>
                     
                       
                        <td class="text-center">
                            {{ $chungTu->huong->ten_huong_chung_tu ?? '-' }}
                        </td>



                        <td><span class="badge bg-warning text-dark">{{ $chungTu->trangThai->ten_trang_thai ?? 'N/A' }}</span></td>
                        <td>
                            {{ $chungTu->nguoiTao->name ?? 'N/A' }}<br>
                            <small class="text-muted">{{ $chungTu->nguoiTao->email ?? '' }}</small>
                        </td>
                        
                        <td>
                            @if($chungTu->nguoiTao && $chungTu->nguoiTao->phongBan)
                                <span class="badge bg-secondary">{{ $chungTu->nguoiTao->phongBan->ten_phong_ban }}</span>
                            @else
                                <span class="text-muted">Chưa có</span>
                            @endif
                        </td>
                        <td>{{ $chungTu->nguoiGuiDoiTac->ten_doi_tac ?? '-' }}</td>
                        <td>{{ $chungTu->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $chungTu->ky_so ? '✅' : '❌' }}</td>
                        <td class="text-center">
                            <a href="{{ route('chungtu.show', $chungTu->id) }}" class="btn btn-sm btn-outline-info">👁️</a>
                            <a href="{{ route('chungtu.edit', $chungTu->id) }}" class="btn btn-sm btn-outline-warning">✏️</a>
                            <form action="{{ route('chungtu.destroy', $chungTu->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa chứng từ này?')">🗑️</button>
                            </form>
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
