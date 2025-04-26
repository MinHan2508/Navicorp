@php
    use Illuminate\Support\Str;

    $fileExtension = Str::lower(pathinfo($chungTu->duong_dan, PATHINFO_EXTENSION));
    $fileUrl = route('chungtu.viewFile', $chungTu->id);
@endphp

@if($chungTu->duong_dan)
    <div class="mt-4">
        <h5 class="text-success">📎 File đính kèm:</h5>

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
                <div class="text-center mt-3">
                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary">
                        📥 Tải xuống file
                    </a>
                </div>
                <script>hideLoading();</script>
            @endif
        </div>
    </div>
@endif
