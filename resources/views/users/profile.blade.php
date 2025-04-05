@extends('layouts.app')

@section('content')

<section class="section profile py-4">
    <div class="row g-4">
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
                    <h5 class="text-muted">{{ optional($user->vaiTro)->ten_vai_tro ?? 'Không rõ vai trò' }}</h5>
                    @if($user->phongBan)
                        <h6 class="text-muted">{{ $user->phongBan->ten_phong_ban }}</h6>
                    @else
                        <h6 class="text-muted">Chưa có phòng ban</h6>
                    @endif
                    <div class="social-links mt-3">
                        <a href="#" class="mx-1 text-secondary"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" class="mx-1 text-secondary"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="mx-1 text-secondary"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="mx-1 text-secondary"><i class="bi bi-linkedin fs-5"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card shadow-sm border-light rounded-4">
                <div class="card-body pt-4 px-4">
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
                        <div class="tab-pane fade show active" id="profile-overview" role="tabpanel">
                            <h5 class="card-title">Thông tin mô tả</h5>
                            <p class="small fst-italic text-muted">{{ $user->ghi_chu }}</p>

                            <h5 class="card-title mt-4">Chi tiết hồ sơ</h5>

                            @php
                                $fields = [
                                    'Tên' => $user->name,
                                    'Email' => $user->email,
                                    'Số điện thoại' => $user->sdt,
                                    'Ngày sinh' => $user->ngay_sinh ? \Carbon\Carbon::parse($user->ngay_sinh)->format('d/m/Y') : 'Chưa có',
                                    'Địa chỉ' => $user->dia_chi,
                                    'Giới tính' => $user->gioi_tinh,
                                    'Vai trò' => optional($user->vaiTro)->ten_vai_tro,
                                    'Phòng ban' => optional($user->phongBan)->ten_phong_ban ?? 'Chưa có',
                                    
                                    'Trạng thái' => $user->trang_thai,
                                   
                                ];
                            @endphp

                            @foreach($fields as $label => $value)
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 text-muted fw-semibold">{{ $label }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $value }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="profile-edit" role="tabpanel">
                            <h5 class="card-title">Chỉnh sửa thông tin</h5>
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Tên</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>

                                <!-- ngày sinh -->
                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Ngày sinh</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="date" class="form-control" name="ngay_sinh" value="{{ old('ngay_sinh', $user->ngay_sinh) }}">
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Số điện thoại</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="text" class="form-control" name="sdt" value="{{ old('sdt', $user->sdt) }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Địa chỉ</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="text" class="form-control" name="dia_chi" value="{{ old('dia_chi', $user->dia_chi) }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Giới tính</label>
                                    <div class="col-lg-9 col-md-8">
                                        <select name="gioi_tinh" class="form-select" required>
                                            <option value="Nam" {{ old('gioi_tinh', $user->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                                            <option value="Nữ" {{ old('gioi_tinh', $user->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                            <option value="Khác" {{ old('gioi_tinh', $user->gioi_tinh) == 'Khác' ? 'selected' : '' }}>Khác</option>
                                        </select>
                                    </div>
                                </div>
                                

                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Ảnh đại diện</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="file" class="form-control" name="anh" id="anh" accept="image/*">

                                        <div class="row mt-3 text-center">
                                            {{-- Ảnh hiện tại --}}
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Ảnh hiện tại</label><br>
                                                @if ($user->anh)
                                                    <img src="{{ route('user.avatar', basename($user->anh)) }}"
                                                        alt="Ảnh đại diện"
                                                        class="img-thumbnail rounded mx-auto d-block"
                                                        style="width: 150px; height: 200px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted d-block mt-2">Chưa có</span>
                                                @endif
                                            </div>

                                            {{-- Ảnh xem trước --}}
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Xem trước</label><br>
                                                <img id="preview"
                                                    class="img-thumbnail rounded mx-auto d-block"
                                                    style="width: 150px; height: 200px; object-fit: cover; display: none;"
                                                    alt="Xem trước ảnh mới">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-lg-3 col-md-4 col-form-label">Mô tả</label>
                                    <div class="col-lg-9 col-md-8">
                                        <textarea class="form-control" name="ghi_chu" rows="1">{{ old('ghi_chu', $user->ghi_chu) }}</textarea>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary px-4">Lưu thay đổi</button>
                                </div>
                            </form>
                        </div>

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
                                    <label class="col-lg-3 col-md-4 col-form-label">Xác nhận mật khẩu</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="password" class="form-control" name="new_password_confirmation" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary px-4">Cập nhật mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
