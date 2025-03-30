@extends('layouts.app')

@section('content')
<div class="container">
    

    <h2 class="mb-3">
    <label for="email" class="form-label fw-semibold">
        Chỉnh sửa thông tin cho tài khoản: 
        <span class="text-primary fw-bold">{{ old('email', $user->email) }}</span>
    </label>
    </h2>


    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="vaitro">Chức vụ</label>
            <select class="form-control" id="vaitro" name="vaitro" required>
                <option value="giamdoc" {{ old('vaitro', $user->vaitro) == 'giamdoc' ? 'selected' : '' }}>Giám đốc</option>
                <option value="nv" {{ old('vaitro', $user->vaitro) == 'nv' ? 'selected' : '' }}>Nhân viên</option>
                <option value="truongphong" {{ old('vaitro', $user->vaitro) == 'truongphong' ? 'selected' : '' }}>Trưởng phòng</option>
            </select>
        </div>

        <div class="form-group">
            <label for="sdt">Số điện thoại</label>
            <input type="text" class="form-control" id="sdt" name="sdt" value="{{ old('sdt', $user->sdt) }}">
        </div>

        <div class="form-group">
            <label for="dia_chi">Địa chỉ</label>
            <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="{{ old('dia_chi', $user->dia_chi) }}">
        </div>

        <div class="form-group">
            <label for="gioi_tinh">Giới tính</label>
            <select class="form-control" id="gioi_tinh" name="gioi_tinh" required>
                <option value="nam" {{ old('gioi_tinh', $user->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                <option value="nu" {{ old('gioi_tinh', $user->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <!-- <div class="form-group">
        <label for="anh">Ảnh đại diện</label>
        <input type="file" name="anh" class="form-control"> -->


    
        <div class="container mt-4">
            <label for="anh" class="form-label">Chọn ảnh đại diện:</label>
            <input type="file" name="anh" id="anh" class="form-control" accept="image/*">
            
            <!-- Khu vực hiển thị ảnh -->

            <div class="row mt-3 align-items-start">
                <div class="col-md-6 text-center">
                    <label class="form-label fw-semibold d-block">Ảnh hiện tại</label>
                    @if($user->anh)
                        <img src="{{ asset('storage/img/anhthe/' . basename($user->anh)) }}" 
                            alt="Ảnh đại diện" 
                            class="img-thumbnail rounded" 
                            style="max-width: 150px;">
                    @else
                        <span class="text-muted">Chưa có ảnh</span>
                    @endif
                </div>

                <div class="col-md-6 text-center">
                    <label class="form-label fw-semibold d-block">Xem trước ảnh mới(nếu có)</label>
                    <img id="preview" src="#" alt="Ảnh xem trước" 
                        class="img-thumbnail rounded" 
                        style="max-width: 150px; display: none;">
                </div>
            </div>




















            <!-- <div class="mt-3">
                <img id="preview" src="#" alt="Ảnh xem trước" style="max-width: 150px; display: none;">
            </div>
           </div>

          <div>ẢNH CŨ</div>
             @if($user->anh)
                        
            <img src="{{ asset('storage/img/anhthe/' . basename($user->anh)) }}" 
                                alt="Ảnh đại diện" 
                             > 
                        @else
                            <span class="text-muted">Cập nhật ảnh</span>
                        @endif -->
        </div>

        <div class="mb-3">
            <label for="phong_ban" class="form-label fw-bold">Phòng ban <span class="text-danger">*</span></label>
            <select class="form-select" id="phong_ban" name="phong_ban" required>
                <option value="" disabled selected>-- Chọn phòng ban --</option>
                @foreach ($phongBans as $phongBan)
                    <option value="{{ $phongBan->id }}"
                        {{ old('phong_ban', optional($user->phongBans->first())->id) == $phongBan->id ? 'selected' : '' }}>
                        {{ $phongBan->ten_phong_ban }}
                    </option>
                @endforeach
            </select>
        </div>



        <div class="form-group">
            <label for="trang_thai">Trạng thái</label>
            <select class="form-control" id="trang_thai" name="trang_thai" required>
                <option value="Hoạt động" {{ old('trang_thai', $user->trang_thai) == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                <option value="Khóa" {{ old('trang_thai', $user->trang_thai) == 'Khóa' ? 'selected' : '' }}>Khóa</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>



<!-- Thêm đoạn mã JavaScript để xem trước ảnh -->
<script>
document.getElementById('anh').addEventListener('change', function(event) {
    let file = event.target.files[0]; // Lấy file được chọn
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            let img = document.getElementById('preview');
            img.src = e.target.result; // Gán dữ liệu ảnh vào src
            img.style.display = 'block'; // Hiển thị ảnh
        };
        reader.readAsDataURL(file); // Đọc file dưới dạng URL
    }
});
</script>




@endsection   