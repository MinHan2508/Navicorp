<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo - {{ $tieuDeMail }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #ffffff;
            font-size: 16px;
            line-height: 1.6;
        }
        .container {
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        h1, h2, h3 {
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        .note {
            font-size: 14px;
            color: #6c757d;
            margin-top: 30px;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }
        .btn-action {
            margin-top: 30px;
            text-align: center;
        }
        .btn-action a {
            display: inline-block;
            padding: 10px 25px;
            background-color: #0d6efd;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }
        .btn-action a:hover {
            background-color: #084298;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Thông Báo Xử Lý Chứng Từ</h2>

    <p><strong>Kính gửi Quý Anh/Chị,</strong></p>

    <p>Hệ thống <strong>NAVICORP</strong> xin trân trọng thông báo có một chứng từ cần Quý Anh/Chị xem xét và xử lý như sau:</p>

    <table class="table">
        <tr>
            <th style="width: 35%;">Mã chứng từ</th>
            <td>{{ $chungTu->ma_chung_tu }}</td>
        </tr>
        <tr>
            <th>Tiêu đề chứng từ</th>
            <td>{{ $chungTu->tieu_de }}</td>
        </tr>
        <tr>
            <th>Ngày tạo</th>
            <td>{{ $chungTu->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Người tạo</th>
            <td>{{ $chungTu->nguoiTao->name ?? 'Không xác định' }} ({{ $chungTu->nguoiTao->email ?? 'Chưa có email' }})</td>
        </tr>
        <tr>
            <th>Trạng thái hiện tại</th>
            <td>{{ $chungTu->trangThai->ten_trang_thai ?? 'Chưa xác định' }}</td>
        </tr>
        <tr>
            <th>Yêu cầu xử lý</th>
            <td>
                {{ $moTaTrangThai ?? 'Xem xét và xử lý theo quy trình.' }}
            </td>
        </tr>
    </table>

    <div class="btn-action">
        <a href="{{ route('chungtu.show', $chungTu->id) }}">
            ➡ Xem Chi Tiết & Xử Lý Ngay
        </a>
    </div>

    <p class="note">
        <strong>Ghi chú:</strong><br>
        Đây là email thông báo tự động từ hệ thống <strong>NAVICORP</strong>. <br>
        Vui lòng không trả lời email này. Mọi thắc mắc xin liên hệ Bộ phận Công nghệ Thông tin.
    </p>

    <div class="signature">
        Trân trọng,<br>
        <strong>Hệ thống NAVICORP</strong>
    </div>
</div>

</body>
</html>
