@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo người dùng mới</h1>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" placeholder="example@navicorp.com" required>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="default_password" onclick="setDefaultPassword()">
            <label class="form-check-label" for="default_password">Tạo mật khẩu mặc định (12345678)</label>
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
        </script>

        <div class="form-group">
            <label for="id_vaitro">Vai trò</label>
            <select class="form-control" name="id_vaitro" required>
                @foreach($vaiTros as $vaiTro)
                    <option value="{{ $vaiTro->id }}">{{ $vaiTro->ten_vai_tro }}</option>
                @endforeach
            </select>
        </div>

        <!--Ngày sinh -->
        <div class="form-group">
            <label for="ngay_sinh">Ngày sinh</label>
            <input type="date" class="form-control" name="ngay_sinh" required>
        




        <div class="form-group">
            <label for="id_phongban">Phòng ban</label>
            <select class="form-control" name="id_phongban" required>
                @foreach($phongbans as $phongban)
                    <option value="{{ $phongban->id }}">{{ $phongban->ten_phong_ban }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="sdt">Số điện thoại</label>
            <input type="text" class="form-control" name="sdt">
        </div>

        <div class="form-group">
            <label for="dia_chi">Địa chỉ</label>
            <input type="text" class="form-control" name="dia_chi">
        </div>

        <div class="form-group">
            <label for="gioi_tinh">Giới tính</label>
            <select class="form-control" name="gioi_tinh" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        </div>

        <div class="form-group">
            <label for="anh">Ảnh đại diện</label>
            <input type="file" class="form-control" name="anh" accept="image/*">
            <img id="preview" src="#" alt="Ảnh xem trước" style="display: none; width: 100px; margin-top: 10px;">
        </div>

        <div class="form-group">
            <label for="trang_thai">Trạng thái</label>
            <select class="form-control" name="trang_thai" required>
                <option value="Hoạt động">Hoạt động</option>
                <option value="Khóa">Khóa</option>
                <option value="Khác">Khác</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ghi_chu">Ghi chú</label>
            <textarea class="form-control" name="ghi_chu" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>

<script>
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
