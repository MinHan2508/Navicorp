@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4">📥 Danh sách chứng từ gửi đến tôi</h3>

        {{-- Form tìm kiếm --}}
        <form method="GET" action="{{ route('chungtu.nhan') }}" class="row g-2 mb-4">
            <div class="col-md-2">
                <input type="text" name="ma_chung_tu" class="form-control" placeholder="Mã chứng từ"
                    value="{{ request('ma_chung_tu') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="tieu_de" class="form-control" placeholder="Tiêu đề"
                    value="{{ request('tieu_de') }}">
            </div>
            <div class="col-md-2">
                <select name="id_loai" class="form-select">
                    <option value="">-- Loại --</option>
                    @foreach($dsLoai ?? [] as $loai)
                        <option value="{{ $loai->id }}" {{ request('id_loai') == $loai->id ? 'selected' : '' }}>
                            {{ $loai->ten_loai_chung_tu }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="id_trang_thai" class="form-select">
                    <option value="">-- Trạng thái --</option>
                    @foreach($dsTrangThai ?? [] as $tt)
                        <option value="{{ $tt->id }}" {{ request('id_trang_thai') == $tt->id ? 'selected' : '' }}>
                            {{ $tt->ten_trang_thai }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="id_huong" class="form-select">
                    <option value="">-- Hướng --</option>
                    @foreach($dsHuong ?? [] as $h)
                        <option value="{{ $h->id }}" {{ request('id_huong') == $h->id ? 'selected' : '' }}>
                            {{ $h->ten_huong_chung_tu }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="noi_ban_hanh" class="form-control" placeholder="Nơi ban hành"
                    value="{{ request('noi_ban_hanh') }}">
            </div>

            <div class="col-md-2">
                <input type="text" name="nguoi_gui" class="form-control" placeholder="Người gửi"
                    value="{{ request('nguoi_gui') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="ngay_tu" class="form-control" value="{{ request('ngay_tu') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="ngay_den" class="form-control" value="{{ request('ngay_den') }}">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">🔍 Tìm kiếm</button>
            </div>
            <div class="col-md-2 d-grid">
                <a href="{{ route('chungtu.nhan') }}" class="btn btn-secondary">↺ Đặt lại</a>
            </div>
        </form>

        @if ($danhSachNhan->isEmpty())
            <div class="alert alert-info">Không có chứng từ nào phù hợp.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Hướng</th>
                            <th>Mã</th>
                            <th>Tiêu đề</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th>Nơi ban hành</th>

                            <th>Ngày gửi</th>
                            <th>File</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($danhSachNhan as $index => $muc)
                            @php
                                $chungTu = $muc->chungTu;
                                $stt = ($danhSachNhan->currentPage() - 1) * $danhSachNhan->perPage() + $index + 1;
                            @endphp
                            <tr>
                                <td>{{ $stt }}</td>
                                <td>{{ $chungTu->huong->ten_huong_chung_tu ?? '-' }}</td>
                                <td>{{ $chungTu->ma_chung_tu ?? '[N/A]' }}</td>
                                <td class="text-start">{{ $chungTu->tieu_de ?? '[N/A]' }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $chungTu->loaiChungTu->ten_loai_chung_tu ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $chungTu->trangThai->ma_trang_thai == 'DA_KY_SO' ? 'success' : 'warning' }}">
                                        {{ $chungTu->trangThai->ten_trang_thai ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ $chungTu->noi_ban_hanh ?? '-' }}</td>

                                <td>{{ $muc->created_at->format('d/m/Y H:i') }}</td>
                                <td>

                                    <a href="{{ URL::signedRoute('chungtu.download.signed', ['chungTu' => $chungTu->id]) }}"
                                        class="btn btn-sm btn-outline-success" target="_blank">
                                        🔐 Tải file 
                                    </a>
                                    

                                </td>
                                <td>
                                <a href="{{ route('chungtu.show.hashid', $chungTu->hashid) }}"
                                        class="btn btn-sm btn-outline-primary" title="Xem chi tiết chứng từ">
                                        <i class="bi bi-eye me-1"></i>Chi tiết </a>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $danhSachNhan->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection