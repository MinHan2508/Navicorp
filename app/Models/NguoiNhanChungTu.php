<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiNhanChungTu extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_chung_tu',
        'id_nguoi_nhan',
        'id_phong_ban',
        'id_doi_tac',
        'loai_nguoi_nhan',
        'da_xem',
        'thoi_gian_xem',
        'ghi_chu'
    ];
}
