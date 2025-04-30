@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-primary">Danh sách Nhân sự</h1>
            <a href="{{ route('users.create') }}" class="btn btn-success">+ Tạo người dùng mới</a>
            <a href="{{ route('users.excel') }}" class="btn btn-success">+ Tạo Danh Sách người dùng mới excel</a>
        </div>



        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="ten" class="form-control" placeholder="🔎 Tên" value="{{ request('ten') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="email" class="form-control" placeholder="🔎 Email" value="{{ request('email') }}">
            </div>
            <div class="col-md-3">
                <select name="id_vaitro" class="form-select">
                    <option value="">-- Vai trò --</option>
                    @foreach($vaiTros as $vt)
                        <option value="{{ $vt->id }}" {{ request('id_vaitro') == $vt->id ? 'selected' : '' }}>
                            {{ $vt->ten_vai_tro }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="id_phongban" class="form-select">
                    <option value="">-- Phòng ban --</option>
                    @foreach($phongBans as $pb)
                        <option value="{{ $pb->id }}" {{ request('id_phongban') == $pb->id ? 'selected' : '' }}>
                            {{ $pb->ten_phong_ban }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Đặt lại</a>
            </div>
        </form>



        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>TT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Phòng ban</th>
                        <th>SĐT</th>
                        <th>Ngày sinh</th>
                        <th>Địa chỉ</th>
                        <th>Giới tính</th>
                        <th>Ảnh</th>

                        <th>Trạng thái</th>
                        @if(auth()->user()->vaiTro->ma_vai_tro === 'admin')
                            <th>Hành động</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            {{-- Vai trò --}}
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $user->vaiTro->ten_vai_tro ?? '---' }}
                                </span>
                            </td>

                            {{-- Phòng ban --}}
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $user->phongBan->ten_phong_ban ?? '---' }}
                                </span>
                            </td>

                            <td>{{ $user->sdt }}</td>
                            <td>{{ $user->ngay_sinh ? \Carbon\Carbon::parse($user->ngay_sinh)->format('d/m/Y') : 'Chưa có' }}
                            </td>
                            <td>{{ $user->dia_chi }}</td>
                            <td>{{ ucfirst($user->gioi_tinh) }}</td>

                            {{-- Ảnh đại diện --}}
                            <td>
                                @if ($user->anh)
                                    <img src="{{ route('user.avatar', basename($user->anh)) }}" alt="Ảnh đại diện" width="70"
                                        height="90">
                                @else
                                    <span class="text-muted">Chưa có ảnh</span>
                                @endif
                            </td>



                            {{-- Trạng thái --}}
                            <td>
                                <span class="badge {{ $user->trang_thai == 'Hoạt động' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->trang_thai }}
                                </span>
                            </td>

                            {{-- Hành động --}}
                            <td>
                                @if(auth()->user()->vaiTro->ma_vai_tro === 'admin')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">✏ Sửa</a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            🗑 Xóa
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection