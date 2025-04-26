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
                📄 Danh sách tất cả Chứng từ
                @if($filter && isset($filterLabels[$filter]))
                    : <span class="fw-bold text-danger">{{ $filterLabels[$filter] }}</span>
                @endif
            </h2>

            <a href="{{ route('chungtu.create') }}" class="btn btn-success">➕ Tạo mới</a>
        </div>

        @if($chungTus->isEmpty())
            <div class="alert alert-info">Không có chứng từ nào được tìm thấy.</div>
        @else

            <form method="GET" class="row g-3 mb-4 border rounded p-3 shadow-sm bg-white">

                {{-- Hàng 1: Mã, Tiêu đề, Số hiệu, Loại --}}
                <div class="col-md-3">
                    <input type="text" name="ma_chung_tu" value="{{ request('ma_chung_tu') }}" class="form-control"
                        placeholder="🔎 Mã chứng từ">
                </div>
                <div class="col-md-3">
                    <input type="text" name="tieu_de" value="{{ request('tieu_de') }}" class="form-control"
                        placeholder="🔎 Tiêu đề">
                </div>
                <div class="col-md-3">
                    <input type="text" name="so_hieu" value="{{ request('so_hieu') }}" class="form-control"
                        placeholder="🔎 Số hiệu">
                </div>
                <div class="col-md-3">
                    <input type="text" name="loai" value="{{ request('loai') }}" class="form-control"
                        placeholder="🔎 Loại chứng từ">
                </div>

                {{-- Hàng 2: Trạng thái, Người tạo, Phòng ban --}}
                <div class="col-md-4">
                    <select name="id_trang_thai" class="form-select">
                        <option value="">-- Trạng thái --</option>
                        @foreach($trangThais as $trangThai)
                            <option value="{{ $trangThai->id }}" {{ request('id_trang_thai') == $trangThai->id ? 'selected' : '' }}>
                                {{ $trangThai->ten_trang_thai }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="id_nguoi_tao" class="form-select">
                        <option value="">-- Người tạo --</option>
                        @foreach($nguoiTaos as $user)
                            <option value="{{ $user->id }}" {{ request('id_nguoi_tao') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="id_phong_ban" class="form-select">
                        <option value="">-- Phòng ban --</option>
                        @foreach($phongBans as $pb)
                            <option value="{{ $pb->id }}" {{ request('id_phong_ban') == $pb->id ? 'selected' : '' }}>
                                {{ $pb->ten_phong_ban }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Hàng 3: Ngày --}}
                <div class="col-md-6">
                    <input type="date" name="tu_ngay" class="form-control" value="{{ request('tu_ngay') }}"
                        placeholder="Từ ngày">
                </div>
                <div class="col-md-6">
                    <input type="date" name="den_ngay" class="form-control" value="{{ request('den_ngay') }}"
                        placeholder="Đến ngày">
                </div>

                {{-- Nút --}}
                <div class="col-12 text-end mt-2">
                    <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
                    <a href="{{ route('chungtu.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Đặt
                        lại</a>
                </div>

            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle shadow-sm">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th style="width: 40px;">#</th>
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
                                            <td class="text-nowrap">{{ $chungTu->ma_chung_tu }}</td>
                                            <td class="text-truncate" style="max-width: 200px;" title="{{ $chungTu->tieu_de }}">
                                                {{ $chungTu->tieu_de }}</td>
                                            <td class="text-nowrap">{{ $chungTu->so_hieu ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $chungTu->loaiChungTu->ten_loai_chung_tu ?? 'N/A' }}</span>
                                            </td>
                                            <td class="text-truncate" style="max-width: 200px;" title="{{ $chungTu->trich_yeu }}">
                                                {{ $chungTu->trich_yeu ?? '-' }}
                                            </td>
                                            <td class="text-nowrap">{{ $chungTu->noi_ban_hanh ?? '-' }}</td>
                                            <td class="text-center">
                                                {{ optional($chungTu->ngay_ban_hanh)->format('d/m/Y') ?? '-' }}
                                            </td>
                                            <td class="text-center text-nowrap">
                                                @if($chungTu->ngay_hieu_luc)
                                                    {{ \Carbon\Carbon::parse($chungTu->ngay_hieu_luc)->format('d/m/Y') }}
                                                    <br>→<br>
                                                    {{ $chungTu->ngay_het_hieu_luc ? \Carbon\Carbon::parse($chungTu->ngay_het_hieu_luc)->format('d/m/Y') : 'Không rõ' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $chungTu->huong->ten_huong_chung_tu ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark">
                                                    {{ $chungTu->trangThai->ten_trang_thai ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-nowrap">
                                                <strong>{{ $chungTu->nguoiTao->name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $chungTu->nguoiTao->email ?? '' }}</small>
                                            </td>
                                            <td class="text-center">
                                                @if($chungTu->nguoiTao && $chungTu->nguoiTao->phongBan)
                                                    <span class="badge bg-secondary">
                                                        {{ $chungTu->nguoiTao->phongBan->ten_phong_ban }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-truncate" style="max-width: 150px;">
                                                {{ $chungTu->nguoiGuiDoiTac->ten_doi_tac ?? '-' }}
                                            </td>
                                            <td class="text-center">{{ $chungTu->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                {!! $chungTu->ky_so ? '✅' : '❌' !!}
                                            </td>
                                            <td class="text-center text-nowrap">
                                                {{-- Nút xem: luôn hiển thị --}}
                                                <a href="{{ route('chungtu.show', $chungTu->id) }}" class="btn btn-sm btn-outline-info"
                                                    title="Xem">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                {{-- Điều kiện: là người tạo --}}
                                                @php
                                                    $laNguoiTao = auth()->id() === $chungTu->id_nguoi_tao;
                                                    $maTrangThai = $chungTu->trangThai->ma_trang_thai ?? '';
                                                @endphp

                                                {{-- Nút sửa nếu là người tạo và trạng thái là TAO_MOI hoặc TU_CHOI --}}
                                                @if($laNguoiTao && in_array($maTrangThai, ['TAO_MOI', 'TU_CHOI']))
                                                    <a href="{{ route('chungtu.edit', $chungTu->id) }}" class="btn btn-sm btn-outline-warning"
                                                        title="Sửa">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endif

                                                {{-- Nút xoá chỉ khi trạng thái là TAO_MOI --}}
                                                @if($laNguoiTao && $maTrangThai === 'TAO_MOI')
                                                    <form action="{{ route('chungtu.destroy', $chungTu->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa chứng từ này?')"
                                                            class="btn btn-sm btn-outline-danger" title="Xóa">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>


                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>
@endsection