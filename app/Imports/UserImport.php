<?php

namespace App\Imports;

use App\Models\User;
use App\Models\VaiTro;
use App\Models\PhongBan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $vaiTro = VaiTro::where('ma_vai_tro', $row['ma_vai_tro'])->first();
        $phongBan = PhongBan::where('ma_phong_ban', $row['ma_phong_ban'])->first();

        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? '12345678'),
            'sdt' => $row['sdt'] ?? null,
            'dia_chi' => $row['dia_chi'] ?? null,
            'gioi_tinh' => $row['gioi_tinh'] ?? 'Khác',
            'ngay_sinh' => isset($row['ngay_sinh']) ? date('Y-m-d', strtotime($row['ngay_sinh'])) : null,
            'id_vaitro' => $vaiTro->id ?? null,
            'id_phongban' => $phongBan->id ?? null,
            'trang_thai' => $row['trang_thai'] ?? 'Hoạt động',
        ]);

    }
}
