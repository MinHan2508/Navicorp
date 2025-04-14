@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">⚙️ Phân quyền cho vai trò: <strong>{{ $vaiTro->ten_vai_tro }}</strong></h3>

    <form method="POST" action="{{ route('vaitro_quyenhan.update', $vaiTro->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach ($tatCaQuyen as $quyen)
                <div class="col-md-4 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="quyen_ids[]" value="{{ $quyen->id }}"
                               id="quyen_{{ $quyen->id }}"
                               {{ in_array($quyen->id, $quyenDaGan) ? 'checked' : '' }}>
                        <label class="form-check-label" for="quyen_{{ $quyen->id }}">
                            {{ $quyen->ma_quyen }} – {{ $quyen->ten_quyen }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary mt-3">💾 Lưu phân quyền</button>
        <a href="{{ route('vaitro_quyenhan.index') }}" class="btn btn-secondary mt-3">↩ Quay lại</a>
    </form>
</div>
@endsection
