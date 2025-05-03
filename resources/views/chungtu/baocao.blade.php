@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-primary">📊 Báo cáo thống kê chung</h2>

        {{-- === PHẦN 1: BÁO CÁO CHUNG === --}}
        <div class="row">

            {{-- Hướng chứng từ --}}
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header fw-bold bg-light">🚩 Thống kê theo hướng chứng từ</div>
                    <div class="card-body">
                        <ul class="mb-0">
                            @foreach($thongKeHuong as $item)
                                <li>{{ $item->huong->ten_huong_chung_tu ?? 'Không xác định' }}: {{ $item->tong }} chứng từ</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Phòng ban --}}
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header fw-bold bg-light">🏢 Thống kê theo phòng ban</div>
                    <div class="card-body">
                        <ul class="mb-0">
                            @foreach($thongKePhongBan as $item)
                                <li>{{ $item->ten_phong_ban ?? 'Không xác định' }}: {{ $item->tong }} chứng từ</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>





            {{-- Loại chứng từ --}}
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header fw-bold bg-light">📄 Thống kê theo loại chứng từ</div>
                    <div class="card-body">
                        <ul class="mb-0">
                            @foreach($thongKeTheoLoai as $item)
                                <li>{{ $item->loaiChungTu->ten_loai_chung_tu ?? 'Không xác định' }}: {{ $item->tong }} chứng từ
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Trạng thái --}}
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header fw-bold bg-light">📌 Thống kê theo trạng thái</div>
                    <div class="card-body">
                        <ul class="mb-0">
                            @foreach($thongKeTrangThai as $item)
                                <li>{{ $item->trangThai->ten_trang_thai ?? 'Không xác định' }}: {{ $item->tong }} chứng từ</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>



        </div>

        {{-- === PHẦN 2: BÁO CÁO THEO HƯỚNG CHI TIẾT === --}}
        <div class="mt-4">
            <h4 class="mb-4 text-primary">🚩 Thống kê chi tiết theo từng hướng chứng từ</h4>

            <div class="row">
                @foreach ($tatCaHuong as $idHuong => $tenHuong)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-primary text-white fw-bold text-center">
                                {{ $tenHuong }}
                            </div>
                            <div class="card-body">
                                {{-- Theo trạng thái --}}
                                @if(isset($thongKeHuongChiTietTrangThai[$idHuong]))
                                    <div class="mb-2"><b>📌 Theo trạng thái: </b></div>
                                    <ul class="mb-3">
                                        @foreach ($thongKeHuongChiTietTrangThai[$idHuong] as $item)
                                            <li>
                                                {{ $tatCaTrangThai[$item->id_trang_thai_hien_tai] ?? 'Không rõ' }}:
                                                <strong>{{ $item->tong }}</strong> chứng từ
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                {{-- Theo loại chứng từ --}}
                                @if(isset($thongKeHuongChiTietLoai[$idHuong]))
                                    <div class="mb-2"><b>📎 Theo loại chứng từ:</b></div>
                                    <ul>
                                        @foreach ($thongKeHuongChiTietLoai[$idHuong] as $item)
                                            <li>
                                                {{ $tatCaLoai[$item->id_loai_chung_tu] ?? 'Không rõ' }}:
                                                <strong>{{ $item->tong }}</strong> chứng từ
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>





    </div>
@endsection