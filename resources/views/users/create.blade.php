@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo người dùng mới</h1>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="example@navicorp.com"  required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="form-group">
            <label for="vaitro">Vai trò</label>
            <select class="form-control" id="vaitro" name="vaitro" required>
                <option value="giamdoc">Giám đốc</option>
                <option value="nv">Nhân viên</option>
                <option value="truongphong">Trưởng phòng</option>
            </select>
        </div>
        <div class="form-group">
            <label for="sdt">Số điện thoại</label>
            <input type="text" class="form-control" id="sdt" name="sdt">
        </div>
        <div class="form-group">
            <label for="dia_chi">Địa chỉ</label>
            <input type="text" class="form-control" id="dia_chi" name="dia_chi">
        </div>
        <div class="form-group">
            <label for="gioi_tinh">Giới tính</label>
            <select class="form-control" id="gioi_tinh" name="gioi_tinh" required>
                <option value="nam">Nam</option>
                <option value="nu">Nữ</option>
            </select>
        </div>

        <!-- Upload ảnh -->
        <div class="form-group">
            <label for="anh">Ảnh đại diện</label>
            <input type="file" class="form-control" id="anh" name="anh" accept="image/*">
        </div>

        <!-- Xem trước ảnh -->
        <img id="preview" src="#" alt="Ảnh xem trước" style="display: none; width: 100px; margin-top: 10px;">

        <div class="form-group">
            <label for="trang_thai">Trạng thái</label>
            <select class="form-control" id="trang_thai" name="trang_thai" required>
                <option value="Hoạt động">Hoạt động</option>
                <option value="Khóa">Khóa</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phongban_id">Phòng ban</label>
            <select class="form-control" name="phongban_id" required>
                @foreach($phongbans as $phongban)
                    <option value="{{ $phongban->id }}">{{ $phongban->ten_phong_ban }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>

<script>
document.getElementById('anh').addEventListener('change', function(event) {
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
