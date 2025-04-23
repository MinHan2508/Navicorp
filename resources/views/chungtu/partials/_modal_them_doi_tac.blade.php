<!-- Modal thêm đối tác -->

<div class="modal fade" id="modalThemDoiTac" tabindex="-1" aria-labelledby="modalThemDoiTacLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('doitac.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalThemDoiTacLabel">➕ Thêm Đối tác mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Tên và loại --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tên đối tác</label>
                            <input type="text" name="ten_doi_tac" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loại đối tác</label>
                            <select name="loai_doi_tac" class="form-select" required>
                                <option value="">-- Chọn loại --</option>
                                @foreach(['Cá nhân', 'Tổ chức', 'Nhà Nước', 'Khác'] as $loai)
                                    <option value="{{ $loai }}">{{ $loai }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Liên hệ --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="sdt" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        {{-- Thông tin pháp lý --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mã số thuế</label>
                            <input type="text" name="ma_so_thue" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fax</label>
                            <input type="text" name="fax" class="form-control">
                        </div>

                        {{-- Đại diện --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Người đại diện</label>
                            <input type="text" name="nguoi_dai_dien" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Chức vụ đại diện</label>
                            <input type="text" name="chuc_vu_dai_dien" class="form-control">
                        </div>

                        {{-- Web, địa chỉ, ghi chú --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="text" name="website" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="dia_chi" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="ghi_chu" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">💾 Lưu đối tác</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>
