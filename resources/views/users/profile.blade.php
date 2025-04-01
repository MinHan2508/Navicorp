@extends('layouts.app')

@section('content')

<section class="section profile py-4">
    <div class="row g-4">
        <!-- Thông tin người dùng (trái) -->
        <div class="col-xl-4">
            <div class="card shadow-sm border-light rounded-4">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    @if($user->anh)
                        <img src="{{ route('user.avatar', basename($user->anh)) }}" alt="Profile"
                             class="rounded-circle shadow-sm" width="200" height="200">
                    @else
                        <div class="text-muted">Cập nhật ảnh</div>
                    @endif

                    <h2 class="mt-3">{{ $user->name }}</h2>
                    <h5 class="text-muted">{{ $user->vaitro }}</h5>

                    <div class="social-links mt-3">
                        <a href="#" class="mx-1 text-secondary"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" class="mx-1 text-secondary"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="mx-1 text-secondary"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="mx-1 text-secondary"><i class="bi bi-linkedin fs-5"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs chức năng (phải) -->
        <div class="col-xl-8">
            <div class="card shadow-sm border-light rounded-4">
                <div class="card-body pt-4 px-4">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" type="button" role="tab">Thông tin</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" type="button" role="tab">Chỉnh sửa</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" type="button" role="tab">Mật khẩu</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab: Thông tin cá nhân -->
                        <div class="tab-pane fade show active" id="profile-overview" role="tabpanel">
                            <h5 class="card-title">Thông tin mô tả</h5>
                            <p class="small fst-italic text-muted">Thông tin mô tả về người dùng.</p>

                            <h5 class="card-title mt-4">Chi tiết hồ sơ</h5>

                            @php
                                $fields = [
                                    'Tên' => $user->name,
                                    'Email' => $user->email,
                                    'Số điện thoại' => $user->sdt,
                                    'Địa chỉ' => $user->dia_chi,
                                    'Giới tính' => $user->gioi_tinh,
                                    'Vai trò' => $user->vaitro,
                                    'Trạng thái' => $user->trang_thai,
                                    'Phòng ban' => $user->phongBans->pluck('ten_phong_ban')->implode(', ') ?: 'Chưa có',

                                ];
                            @endphp

                            @foreach($fields as $label => $value)
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 text-muted fw-semibold">{{ $label }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $value }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Tab: Chỉnh sửa thông tin -->
                        <div class="tab-pane fade" id="profile-edit" role="tabpanel">
    <h5 class="card-title">Chỉnh sửa thông tin</h5>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tên -->
        <div class="row mb-3">
            <label class="col-lg-3 col-md-4 col-form-label">Tên</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
        </div>

        <!-- Số điện thoại -->
        <div class="row mb-3">
            <label class="col-lg-3 col-md-4 col-form-label">Số điện thoại</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" class="form-control" name="sdt" value="{{ old('sdt', $user->sdt) }}">
            </div>
        </div>

        <!-- Địa chỉ -->
        <div class="row mb-3">
            <label class="col-lg-3 col-md-4 col-form-label">Địa chỉ</label>
            <div class="col-lg-9 col-md-8">
                <input type="text" class="form-control" name="dia_chi" value="{{ old('dia_chi', $user->dia_chi) }}">
            </div>
        </div>

        <!-- Giới tính -->
        <div class="row mb-3">
            <label class="col-lg-3 col-md-4 col-form-label">Giới tính</label>
            <div class="col-lg-9 col-md-8">
                <select name="gioi_tinh" class="form-select" required>
                    <option value="nam" {{ old('gioi_tinh', $user->gioi_tinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                    <option value="nu" {{ old('gioi_tinh', $user->gioi_tinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                </select>
            </div>
        </div>

        <!-- Ảnh đại diện -->
        <div class="row mb-3">
            <label class="col-lg-3 col-md-4 col-form-label">Ảnh đại diện</label>
            <div class="col-lg-9 col-md-8">
                <input type="file" class="form-control" name="anh" id="anh" accept="image/*">
                <div class="row mt-3">
                    <div class="col-md-6 text-center">
                        <label class="form-label fw-semibold d-block">Ảnh hiện tại</label>
                        @if ($user->anh)
                            <img src="{{ route('user.avatar', basename($user->anh)) }}" alt="Ảnh đại diện" width="120" height="170">
                        @else
                            <span class="text-muted">Chưa có</span>
                        @endif
                    </div>
                    <div class="col-md-6 text-center">
                        <label class="form-label fw-semibold d-block">Xem trước</label>
                        <img id="preview" class="img-thumbnail rounded" style="max-width: 150px; display: none;" alt="Xem trước ảnh mới">
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút lưu -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Lưu thay đổi</button>
        </div>
    </form>
</div>




                        <!-- Tab: Đổi mật khẩu -->
                        <div class="tab-pane fade" id="profile-change-password" role="tabpanel">
                            <h5 class="card-title">Đổi mật khẩu</h5>
                            <form action="{{ route('profile.change-password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Mật khẩu cũ</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="password" class="form-control" name="old_password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Mật khẩu mới</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Xác nhận mật khẩu mới</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="password" class="form-control" name="new_password_confirmation" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary px-4">Cập nhật mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div> <!-- End tab-content -->






                    
                </div>
            </div>
        </div>
    </div>
</section>




<script>
document.getElementById('anh').addEventListener('change', function(event) {
    let file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            let img = document.getElementById('preview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>





@endsection
