<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kiểm tra chữ ký số</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .wrap {
            max-width: 600px; margin: auto; padding: 30px;
            background: #eaf1ff; border-radius: 8px;
            text-align: center; box-shadow: 0 0 10px #ccc;
        }
        .btn {
            padding: 10px 20px; background: #007bff; color: #fff;
            border: none; border-radius: 5px; cursor: pointer;
        }
        #result { text-align: left; margin-top: 20px; background: #fff; padding: 10px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
    </style>
</head>
<body>
    <div class="wrap">
        <h2>🔐 Kiểm tra văn bản ký số</h2>
        <form id="form-upload" enctype="multipart/form-data">
            <input type="file" name="file" id="file" accept=".xml,.pdf,.docx" required>
            <br><br>
            <button class="btn" type="submit">Kiểm tra</button>
        </form>
        <div id="result" style="display:none;">
            <div id="status"></div>
            <table id="table-result" style="display:none;">
                <tr><th>Đơn vị ký</th><td id="dv"></td></tr>
                <tr><th>Thời gian ký</th><td id="tg"></td></tr>
                <tr><th>Chủ thể</th><td id="ct"></td></tr>
            </table>
        </div>
    </div>

    <script>
        document.getElementById("form-upload").onsubmit = async function(e) {
            e.preventDefault();
            const fileInput = document.getElementById("file");
            const formData = new FormData();
            formData.append("file", fileInput.files[0]);

            const res = await fetch("{{ route('kiemtra.handle') }}", {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });

            const data = await res.json();
            const result = document.getElementById("result");
            const table = document.getElementById("table-result");

            document.getElementById("status").innerText = data.msg;
            result.style.display = "block";

            if (data.success) {
                table.style.display = "table";
                document.getElementById("dv").innerText = data.data?.don_vi_ky ?? 'Không có';
                document.getElementById("tg").innerText = data.data?.signing_time ?? 'Không có';
                document.getElementById("ct").innerText = data.data?.subject ?? 'Không có';
            } else {
                table.style.display = "none";
            }
        }
    </script>
</body>
</html>
