<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông báo chứng từ mới</title>
    <style>
        body {
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f7f9fc;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background-color: #fff;
            border: 1px solid #ddd;
            margin: 0 auto;
            padding: 30px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .info p {
            margin: 5px 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background-color: #2f80ed;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
        }

        .button:hover {
            background-color: #1565c0;
        }
    </style>
</head>

<body>
    <div class="container">
        @if ($laDoiTac)
            <h2 class="title">📄 Bạn có một chứng từ mới từ Công ty CP Nam Việt - NAVICO</h2>
        @else
            <h2 class="title">📄 Bạn có một chứng từ mới được gửi</h2>
        @endif
        @if ($laDoiTac)
            <div class="info mb-3">
                <p><strong>Tên công ty:</strong> Công Ty CP Nam Việt - NAVICO</p>
                <p><strong>Mã số thuế:</strong> 1600168736</p>
                <p><strong>Địa chỉ:</strong> 19D Trần Hưng Đạo, Phường Mỹ Quý, Tp. Long Xuyên, tỉnh An Giang</p>
            </div>
        @endif

        <div class="info">
            <p><strong>Mã chứng từ:</strong> {{ $chungTu->ma_chung_tu }}</p>
            <p><strong>Tiêu đề:</strong> {{ $chungTu->tieu_de }}</p>
            <p><strong>Trích yếu:</strong> {{ $chungTu->trich_yeu ?? '[Không có]' }}</p>
            <p><strong>Ngày ban hành:</strong>
                {{ \Carbon\Carbon::parse($chungTu->ngay_ban_hanh)->format('d/m/Y') ?? '-' }}
            </p>
            @if (!empty($ghiChuGui))
                <p><strong>Ghi chú từ người gửi:</strong> {{ $ghiChuGui }}</p>
            @endif
        </div>
        @if (!$laDoiTac)
        <a href="{{ route('chungtu.show', $chungTu->id) }}" class="button" target="_blank">
            👉 Xem chi tiết chứng từ/văn bản
        </a>
        @endif
        <a href="{{ $signedUrl }}" class="button" target="_blank">
            📥 Tải file chứng từ/văn bản
        </a>
        <p><strong> Liên hệ Người gửi:</strong> {{ $chungTu->nguoiTao->name }}
            ({{ $chungTu->nguoiTao->vaiTro->ten_vai_tro }} - {{ $chungTu->nguoiTao->phongBan->ten_phong_ban }})</p>

        <div class="footer">
            <p>Gửi từ Hệ thống quản lý chứng từ điện tử NAVICORP</p>
            <p>Đây là email tự động. Vui lòng không trả lời.</p>
        </div>
    </div>
</body>

</html>
<!--  -->