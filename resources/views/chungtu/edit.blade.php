@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-primary mb-4">📝 Cập nhật chứng từ</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('chungtu.update', $chungTu->id) }}" method="POST" enctype="multipart/form-data" class="shadow p-4 bg-light rounded">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_trang_thai_hien_tai" value="{{ \App\Models\TrangThaiChungTu::where('ma_trang_thai', 'TAO_MOI')->first()->id }}">

        {{-- Hidden input hướng --}}
        <input type="hidden" name="id_huong" value="{{ $chungTu->id_huong }}">

        {{-- Người tạo --}}
        <input type="hidden" name="id_nguoi_tao" value="{{ $chungTu->id_nguoi_tao }}">
        <div class="mb-3">
            <label class="form-label">Người tạo</label>
            <input class="form-control" value="{{ $chungTu->nguoiTao->email ?? 'Không rõ' }}" disabled>
        </div>

        {{-- Form dùng chung --}}
        @include('chungtu.partials._form_create', [
            'chungTu' => $chungTu,
            'loaiChungTus' => $loaiChungTus,
            'doiTacs' => $doiTacs,
            'huongMacDinh' => $chungTu->id_huong
        ])
        {{-- Preview file --}}
    @include('chungtu.partials._file', ['chungTu' => $chungTu])

    {{-- JS xử lý SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/tu_choi.js') }}"></script>
   

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
            <a href="{{ route('chungtu.index') }}" class="btn btn-secondary">← Quay lại</a>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('duong_dan');
        const previewLink = document.getElementById('filePreviewLink');
        const previewName = document.getElementById('filePreviewName');

        input.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                previewLink.href = "#";
                previewName.innerText = file.name;
                previewLink.classList.remove('d-none');
            } else {
                previewLink.classList.add('d-none');
                previewName.innerText = '';
            }
        });
    });
</script>
@endpush