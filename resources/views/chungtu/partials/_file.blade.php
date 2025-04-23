@php
    $fileExtension = pathinfo($chungTu->duong_dan, PATHINFO_EXTENSION);
    $fileUrl = route('chungtu.viewFile', $chungTu->id);
@endphp

<div id="file-preview-loading" class="text-center text-muted py-3">
    <div class="spinner-border text-primary mb-2" role="status"></div><br>
    Đang tải file, vui lòng chờ...
</div>

<div id="file-preview-content" class="border rounded mt-2 p-2 bg-light d-none">
    @if ($fileExtension === 'pdf')
        <iframe id="preview-frame" src="{{ $fileUrl }}" width="100%" height="600px" class="border" onload="hideLoading()"></iframe>
    @elseif (in_array($fileExtension, ['doc', 'docx', 'xls', 'xlsx']))
        <iframe id="preview-frame" src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" width="100%" height="600px" class="border" onload="hideLoading()"></iframe>
    @else
        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary mt-2">Tải xuống file</a>
        <script>hideLoading();</script>
    @endif
</div>
