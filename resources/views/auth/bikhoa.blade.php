<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Đăng nhập</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('img/admin/br_login.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            z-index: 2;
            position: relative;
        }

        .form-box,
        .toggle-box {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>


</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="form-box login" padding="60px">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1 style="margin: 10px;">🔒Tài khoản bạn</h1>

                <h1 style="margin: 10px;">Đã bị Khóa🔒</h1>

                <h2 class="text-danger fw-semibold my-4" style="margin: 10px;" color="red">

                    ❗ Lý do: {{ $lyDo }}
                </h2>


                <h4 class="text-danger fw-semibold my-4" style="margin: 10px;">

                    Vui lòng liên hệ quản trị hoặc phòng ban để mở khóa tài khoản của bạn!
                </h4>


                <a href="{{ route('home') }}" class="btn btn-secondary mt-3">
                    ⬅️ Quay lại trang chủ
                </a>


            </form>
        </div>


        <div class="toggle-box">
            <div class="toggle-panel toggle-left" style="padding: 20px;">
                <h1 class="fw-bold mb-2" style="margin: 10px;">CHÀO MỪNG</h1>
                <h1 class="fw-bold mb-2">ĐẾN VỚI</h1>
                <h1 class="fw-bold mb-2" style="margin: 10px;">HỆ THỐNG QUẢN LÝ</h1>
                <h1 class="fw-bold">CHỨNG TỪ</h1>


            </div>

        </div>
    </div>

    <script src="{{ asset('js/auth.js') }}"></script>

</body>

</html>