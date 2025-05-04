<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Đây là tên của cấu hình Hashids mặc định sẽ được sử dụng khi bạn gọi
    | Hashids::encode() hoặc decode() mà không chỉ rõ connection nào.
    |
    | Nếu bạn dùng nhiều cấu hình mã hóa khác nhau, có thể tạo thêm ở phần 'connections'
    | bên dưới và thay đổi 'default' tại đây.
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Danh sách các cấu hình mã hóa (connection) khác nhau.
    | Mỗi cấu hình có thể có:
    | - 'salt': chuỗi dùng để tăng độ ngẫu nhiên cho mã hóa (rất quan trọng)
    | - 'length': độ dài tối thiểu của chuỗi sau khi mã hóa
    | - 'alphabet': bộ ký tự được dùng trong mã hóa (nếu muốn giới hạn)
    */

    'connections' => [

        'main' => [
            // Chuỗi salt bảo mật, nên lấy từ biến môi trường .env để bảo mật hơn
            'salt' => env('HASHIDS_SALT', 'navico_chungtu_2025_supersecret'),

            // Độ dài tối thiểu của chuỗi hashid sau khi mã hóa (0 = không giới hạn)
            'length' => 64,

            // Có thể khai báo bảng chữ cái tùy chọn nếu muốn kiểm soát ký tự đầu ra
            // 'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ],

        'alternative' => [
            // Ví dụ: cấu hình khác nếu bạn cần cho model khác hoặc định dạng riêng
            'salt' => 'another-salt-key',
            'length' => 8,
            // 'alphabet' => 'abcdef1234567890'
        ],

    ],

];
