@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo người dùng mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>⚠️ Vui lòng kiểm tra các lỗi bên dưới!</strong>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="...@navicorp.com" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="default_password" onclick="setDefaultPassword()">
            <label class="form-check-label" for="default_password">Tạo mật khẩu mặc định (12345678)</label>
        </div>

        <div class="form-group">
            <label for="id_vaitro">Vai trò</label>
            <select class="form-control @error('id_vaitro') is-invalid @enderror" name="id_vaitro" required>
                @foreach($vaiTros as $vaiTro)
                    <option value="{{ $vaiTro->id }}" {{ old('id_vaitro') == $vaiTro->id ? 'selected' : '' }}>{{ $vaiTro->ten_vai_tro }}</option>
                @endforeach
            </select>
            @error('id_vaitro')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="ngay_sinh">Ngày sinh</label>
            <input type="date" class="form-control @error('ngay_sinh') is-invalid @enderror" name="ngay_sinh" value="{{ old('ngay_sinh') }}">
            @error('ngay_sinh')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="id_phongban">Phòng ban</label>
            <select class="form-control @error('id_phongban') is-invalid @enderror" name="id_phongban" required>
                @foreach($phongbans as $phongban)
                    <option value="{{ $phongban->id }}" {{ old('id_phongban') == $phongban->id ? 'selected' : '' }}>{{ $phongban->ten_phong_ban }}</option>
                @endforeach
            </select>
            @error('id_phongban')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="sdt">Số điện thoại</label>
            <input type="text" class="form-control @error('sdt') is-invalid @enderror" name="sdt" value="{{ old('sdt') }}">
            @error('sdt')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="dia_chi">Địa chỉ</label>
            <input type="text" class="form-control @error('dia_chi') is-invalid @enderror" name="dia_chi" value="{{ old('dia_chi') }}">
            @error('dia_chi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="gioi_tinh">Giới tính</label>
            <select class="form-control @error('gioi_tinh') is-invalid @enderror" name="gioi_tinh" required>
                <option value="Nam" {{ old('gioi_tinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ old('gioi_tinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                <option value="Khác" {{ old('gioi_tinh') == 'Khác' ? 'selected' : '' }}>Khác</option>
            </select>
            @error('gioi_tinh')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="anh">Ảnh đại diện</label>
            <input type="file" class="form-control @error('anh') is-invalid @enderror" name="anh" accept="image/*">
            <img id="preview" src="#" alt="Ảnh xem trước" style="display: none; width: 100px; margin-top: 10px;">
            @error('anh')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="trang_thai">Trạng thái</label>
            <select class="form-control @error('trang_thai') is-invalid @enderror" name="trang_thai" required>
                <option value="Hoạt động" {{ old('trang_thai') == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                <option value="Khóa" {{ old('trang_thai') == 'Khóa' ? 'selected' : '' }}>Khóa</option>
                <option value="Khác" {{ old('trang_thai') == 'Khác' ? 'selected' : '' }}>Khác</option>
            </select>
            @error('trang_thai')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="ghi_chu">Ghi chú</label>
            <textarea class="form-control @error('ghi_chu') is-invalid @enderror" name="ghi_chu" rows="2">{{ old('ghi_chu') }}</textarea>
            @error('ghi_chu')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>

<script>
function setDefaultPassword() {
    const isChecked = document.getElementById('default_password').checked;
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    if (isChecked) {
        passwordField.value = '12345678';
        confirmPasswordField.value = '12345678';
        passwordField.setAttribute('readonly', true);
        confirmPasswordField.setAttribute('readonly', true);
    } else {
        passwordField.value = '';
        confirmPasswordField.value = '';
        passwordField.removeAttribute('readonly');
        confirmPasswordField.removeAttribute('readonly');
    }
}

document.querySelector('input[name="anh"]').addEventListener('change', function(event) {
    let reader = new FileReader();
    reader.onload = function() {
        let preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
});
</script>
@endsection
