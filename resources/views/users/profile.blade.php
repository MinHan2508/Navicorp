@extends('layouts.app')

@section('content')

<body>
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        @if($user->anh)
                            <img src="{{ asset('storage/img/anhthe/' . basename($user->anh)) }}" alt="Profile" class="rounded-circle"  width="200" height="200">
                        @else
                            <span class="text-muted">Cập nhật ảnh</span>
                        @endif
                        <h2>{{ $user->name }}</h2>
                        <h3>{{ $user->vaitro }}</h3>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Thông tin cá nhân</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Chỉnh sửa thông tin</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Đổi mật khẩu</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2">
                            <!-- Thông tin cá nhân -->
                            <div class="tab-pane fade show active" id="profile-overview">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic">Thông tin mô tả về người dùng.</p>
                                <h5 class="card-title">Profile Details</h5>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Tên</div>
                            <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Email</div>
                            <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Số điện thoại</div>
                            <div class="col-lg-9 col-md-8">{{ $user->sdt }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Địa chỉ</div>
                            <div class="col-lg-9 col-md-8">{{ $user->dia_chi }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Giới tính</div>
                            <div class="col-lg-9 col-md-8">{{ $user->gioi_tinh }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Vai trò</div>
                            <div class="col-lg-9 col-md-8">{{ $user->vaitro }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Trạng thái</div>
                            <div class="col-lg-9 col-md-8">{{ $user->trang_thai }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Phòng ban</div>
                            <div class="col-lg-9 col-md-8">{{ $user->phongban->ten_phong_ban ?? 'Chưa có' }}</div>
                        </div>
                            </div>

                            <!-- Chỉnh sửa thông tin -->
                            <div class="tab-pane fade" id="profile-edit">
                                <h5 class="card-title">Chỉnh sửa thông tin</h5>

                                <form action="" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-md-4 label">Tên</label>
                                        <div class="col-lg-9 col-md-8">
                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-md-4 label">Số điện thoại</label>
                                        <div class="col-lg-9 col-md-8">
                                            <input type="text" class="form-control" name="sdt" value="{{ $user->sdt }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-md-4 label">Địa chỉ</label>
                                        <div class="col-lg-9 col-md-8">
                                            <input type="text" class="form-control" name="dia_chi" value="{{ $user->dia_chi }}">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Đổi mật khẩu -->
                            <div class="tab-pane fade" id="profile-change-password">
                                <h5 class="card-title">Đổi mật khẩu</h5>
                                <form action="" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-md-4 label">Mật khẩu cũ</label>
                                        <div class="col-lg-9 col-md-8">
                                            <input type="password" class="form-control" name="old_password">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-lg-3 col-md-4 label">Mật khẩu mới</label>
                                        <div class="col-lg-9 col-md-8">
                                            <input type="password" class="form-control" name="new_password">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- End tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

@endsection
