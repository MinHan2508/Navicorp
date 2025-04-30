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
    public function nguoiNhan()
    {
        return $this->belongsTo(User::class, 'id_nguoi_nhan');
    }

    public function phongBan()
    {
        return $this->belongsTo(PhongBan::class, 'id_phong_ban');
    }

    public function doiTac()
    {
        return $this->belongsTo(DoiTac::class, 'id_doi_tac');
    }

    public function chungTu()
    {
        return $this->belongsTo(ChungTu::class, 'id_chung_tu');
    }
    
}
