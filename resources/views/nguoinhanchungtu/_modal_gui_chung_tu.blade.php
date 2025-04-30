<!-- Modal gửi chứng từ -->
<div class="modal fade" id="guiChungTuModal" tabindex="-1" aria-labelledby="guiChungTuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('nguoinhanchungtu.store', $chungTu->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guiChungTuModalLabel">📤 Gửi chứng từ: {{ $chungTu->tieu_de }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Chọn người dùng nội bộ</label>
                        <select name="id_users[]" class="form-select" multiple>
                            @foreach ($users as $userItem)
                                <option value="{{ $userItem->id }}">{{ $userItem->name }} ({{ $userItem->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chọn phòng ban</label>
                        <select name="id_phong_bans[]" class="form-select" multiple>
                            @foreach ($phongBans as $pb)
                                <option value="{{ $pb->id }}">{{ $pb->ten_phong_ban }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chọn đối tác</label>
                        <select name="id_doi_tacs[]" class="form-select" multiple>
                            @foreach ($doiTacs as $dt)
                                <option value="{{ $dt->id }}">{{ $dt->ten_doi_tac }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ghi chú (nếu có)</label>
                        <textarea name="ghi_chu" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">📤 Gửi chứng từ</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>
