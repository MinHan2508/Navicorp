<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuChungTu extends Model
{
    use HasFactory;



    protected $fillable = [
        'id_chung_tu',
        'id_nguoi_thay_doi',
        'id_trang_thai_moi',
        'ghi_chu',
    ];

        public function chungTu()
    {
        return $this->belongsTo(ChungTu::class, 'id_chung_tu');
    }

    public function nguoiThayDoi()
    {
        return $this->belongsTo(User::class, 'id_nguoi_thay_doi');
    }

    public function trangThaiMoi()
    {
        return $this->belongsTo(TrangThaiChungTu::class, 'id_trang_thai_moi');
    }

       


}
