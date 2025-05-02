<div class="modal fade" id="modalKySo" tabindex="-1" aria-labelledby="modalKySoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" enctype="multipart/form-data"
          action="{{ route('chungtu.capnhatFileKySo', $chungTu->id) }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">✍️ Tải lên file đã ký số</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted">Chấp nhận: PDF, XML, DOCX, XLSX</p>
        <input type="file" name="file_ky_so" class="form-control" accept=".pdf,.xml,.docx,.xlsx" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">✅ Cập nhật</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
      </div>
    </form>
  </div>
</div>
