@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">


            @php
                $routeName = Route::currentRouteName();
                $filter = request('filter');
                $filterLabels = [
                    'tao_moi' => 'Đã Khởi Tạo',
                    'cho_truong_phong' => 'Chờ Trưởng phòng duyệt',
                    'cho_lanh_dao' => 'Chờ Lãnh đạo duyệt',
                    'da_duyet' => 'Đã Duyệt',
                    'cho_ky_so' => 'Chờ Ký số',
                    'da_ky_so' => 'Đã Ký số',
                    'cho_gui' => 'Chờ Gửi đi',
                    'da_gui' => 'Đã Gửi đi',
                    'cho_gui_di' => 'Chờ Gửi đi',
                    'da_ban_hanh' => 'Đã Ban hành',
                    'tu_choi' => 'Bị Từ chối',
                ];

                // Xác định tiêu đề động
                $title = '📄Tất Cả Chứng từ';
                if ($routeName === 'chungtu.index.di') {
                    $title = 'Chứng từ đi';
                } elseif ($routeName === 'chungtu.index.noi_bo') {
                    $title = 'Chứng từ nội bộ';
                } elseif ($routeName === 'chungtu.index.den') {
                    $title = 'Chứng từ đến';
                }
            @endphp
            <h2>
                <span class="text-dark">DANH SÁCH:</span>
                <span class="text-primary">
                    {{ $title }}
                    @if($filter && isset($filterLabels[$filter]))
                        : <span class="fw-bold text-danger">{{ $filterLabels[$filter] }}</span>
                    @endif
                </span>
            </h2>



           
        </div>

        @if($chungTus->isEmpty())
            <div class="alert alert-info">Không có chứng từ nào được tìm thấy.</div>
        @else

            <form method="GET" class="row g-3 mb-4 border rounded p-3 shadow-sm bg-white">


                @php
                    $routeName = Route::currentRouteName();
                    $anHuong = in_array($routeName, ['chungtu.index.di', 'chungtu.index.noi_bo', 'chungtu.index.den']);
                @endphp

                @php
                    $laNoiBo = $routeName === 'chungtu.index.noi_bo';
                @endphp

                @if(!$anHuong)
                    <div class="col-md-12">
                        <select name="huong" class="form-select">
                            <option value="">🔎 Chọn hướng chứng từ</option>
                            @foreach($huongChungTus as $huong)
                                <option value="{{ $huong->ten_huong_chung_tu }}" {{ request('huong') == $huong->ten_huong_chung_tu ? 'selected' : '' }}>
                                    {{ $huong->ten_huong_chung_tu }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

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
                    <select name="loai" class="form-select">
                        <option value="">🔎 Chọn loại chứng từ</option>
                        @foreach($loaiChungTus as $loai)
                            <option value="{{ $loai->ten_loai_chung_tu }}" {{ request('loai') == $loai->ten_loai_chung_tu ? 'selected' : '' }}> {{ $loai->ten_loai_chung_tu }}

                            </option>
                        @endforeach
                    </select>
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
                    <input type="text" name="id_nguoi_tao" class="form-control" placeholder="🔎 Người tạo (Tên hoặc Email)"
                        value="{{ request('id_nguoi_tao') }}">

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
                <div class="d-flex align-items-center gap-2">
                    <label for="tu_ngay" class="form-label mb-0">Từ ngày:</label>
                    <input type="date" id="tu_ngay" name="tu_ngay" class="form-control w-auto"
                        value="{{ request('tu_ngay') ? \Carbon\Carbon::parse(request('tu_ngay'))->format('Y-m-d') : '' }}">

                    <label for="den_ngay" class="form-label mb-0 ms-3">Đến ngày:</label>
                    <input type="date" id="den_ngay" name="den_ngay" class="form-control w-auto"
                        value="{{ request('den_ngay') ? \Carbon\Carbon::parse(request('den_ngay'))->format('Y-m-d') : '' }}">

                    <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
                    <a href="http://localhost/NAVICORP/public/chungtu" class="btn btn-outline-secondary"><i
                            class="bi bi-x-circle"></i> Đặt lại</a>
                </div>



                {{-- Nút --}}
                <!-- <div class="col-12 text-end mt-2">
                    <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
                    <a href="{{ route('chungtu.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Đặt
                        lại</a>
                </div> -->

            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle shadow-sm">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th style="width: 40px;">#</th>

                            @if(!$anHuong)
                                <th>Hướng</th>
                            @endif
                            <th>Mã</th>
                            <th>Tiêu đề</th>
                            <th>Số hiệu</th>
                            <th>Loại</th>
                            <th>Trích yếu</th>
                            <th>Nơi ban hành</th>
                            <th>Ngày ban hành</th>
                            <th>Hiệu lực</th>

                            <th>Trạng thái</th>
                            <th>Người tạo</th>
                            <th>Phòng ban</th>
                            @if(!$laNoiBo)
                                <th>Đối tác</th>
                            @endif
                            <th>Ngày tạo</th>
                            <th>Ký số</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chungTus as $chungTu)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>

                                @if(!$anHuong)
                                    <td class="text-center">{{ $chungTu->huong->ten_huong_chung_tu ?? '-' }}</td>
                                @endif
                                <td class="text-nowrap">{{ $chungTu->ma_chung_tu }}</td>
                                <td class="text-truncate" style="max-width: 200px;" title="{{ $chungTu->tieu_de }}">
                                    {{ $chungTu->tieu_de }}
                                </td>
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

                                <td class="text-center">
                                    @php

                                        $maTrangThai = $chungTu->trangThai->ma_trang_thai ?? null;
                                        $badgeClass = match ($maTrangThai) {
                                            'TAO_MOI' => 'bg-primary text-white',
                                            'DA_DUYET_CAP_PHONG' => 'bg-warning text-dark',
                                            'DA_DUYET' => 'bg-success text-white',
                                            'KY_SO' => 'bg-primary text-white',
                                            'DA_KY_SO' => 'bg-success text-white',
                                            'DA_GUI' => 'bg-info text-white',
                                            'DA_BAN_HANH' => 'bg-info text-white',
                                            'TU_CHOI' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white',
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ $chungTu->trangThai->ten_trang_thai ?? 'Chưa xác định' }}
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
                                @if(!$laNoiBo)
                                    <td class="text-truncate" style="max-width: 200px;">
                                        @if($chungTu->nguoiGuiDoiTac)
                                            <strong>{{ $chungTu->nguoiGuiDoiTac->ten_doi_tac }}</strong><br>
                                            <small class="text-muted">{{ $chungTu->nguoiGuiDoiTac->email ?? '-' }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                @endif
                                <td class="text-center">{{ $chungTu->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    {!! $chungTu->ky_so ? '✅' : '❌' !!}
                                </td>

                                <td class="text-center text-nowrap">
                                    {{-- Nút xem: luôn hiển thị --}}


                                    {{-- Nút xem: luôn hiển thị --}}


                                    <a href="{{ route('chungtu.show.hashid', $chungTu->hashid) }}"
                                        class="btn btn-sm btn-outline-primary" title="Xem chi tiết chứng từ">
                                        <i class="bi bi-eye me-1"></i> </a>


                                    {{-- Điều kiện: là người tạo --}}

                                    @php

                                        $laNguoiTao = auth()->id() === $chungTu->id_nguoi_tao;

                                        $maTrangThai = $chungTu->trangThai->ma_trang_thai ?? '';

                                    @endphp


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

                {{-- Hiển thị phân trang --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
                    <div>
                        {{-- Phân trang --}}
                        {{ $chungTus->links() }}
                    </div>

                    <div class="d-flex align-items-center mt-2 mt-md-0">
                        <form method="GET" id="form-per-page" class="d-flex align-items-center">
                            {{-- Giữ lại các filter đang chọn --}}
                            @foreach(request()->except('per_page', 'page') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach

                            <label for="per_page" class="me-2 fw-bold">Hiển thị:</label>
                            <select name="per_page" id="per_page" class="form-select form-select-sm w-auto"
                                onchange="document.getElementById('form-per-page').submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 dòng / trang</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 dòng / trang</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 dòng / trang</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 dòng / trang</option>
                            </select>
                        </form>
                    </div>
                </div>


            </div>

        @endif
    </div>
@endsection

<link rel="stylesheet" href="{{ asset('css/chungtu.css') }}">
<script src="{{ asset('js/hover_actions.js') }}"></script>