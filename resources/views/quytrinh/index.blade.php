@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Sơ đồ quy trình xử lý chứng từ</h2>

    @foreach ($dsQuyTrinh as $idHuong => $nhomQuyTrinh)
        <div class="mb-5">
            <h4 class="text-primary mb-4">
                <i class="bi bi-signpost-2-fill"></i> Quy trình xử lý của: {{ $nhomQuyTrinh->first()->huong->ten_huong_chung_tu }}
            </h4>

            <div class="timeline-container d-flex flex-wrap gap-4 justify-content-start">
                @foreach ($nhomQuyTrinh as $quytrinh)
                    <div class="timeline-item card shadow-sm border-0 text-center px-3 pt-4 pb-3 position-relative" style="min-width: 220px;">
                        {{-- Circle số thứ tự --}}
                        <div class="timeline-step bg-primary text-white rounded-circle position-absolute top-0 start-50 translate-middle d-flex align-items-center justify-content-center"
                             style="width: 50px; height: 50px; font-weight: bold; font-size: 18px;">
                            {{ str_pad($quytrinh->thu_tu, 2, '0', STR_PAD_LEFT) }}
                        </div>

                        {{-- Nội dung bên dưới --}}
                        <div class="timeline-content mt-3 pt-2">
                            <h6 class="fw-bold mb-1">{{ $quytrinh->mo_ta ?? 'Không ghi chú' }}</h6>
                            <div class="small text-secondary">
                             
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="text-center mt-5">
        <a href="{{ route('quytrinh.create') }}" class="btn btn-success px-4 py-2">+ Thêm bước mới</a>
    </div>
</div>


@endsection
