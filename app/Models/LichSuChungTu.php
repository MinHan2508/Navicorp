<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuChungTu extends Model
{
    use HasFactory;

    public function chungTu()
    {
        return $this->belongsTo(ChungTu::class, 'chung_tu_id');
    }

    public function nguoiThayDoi()
    {
        return $this->belongsTo(User::class, 'nguoi_thay_doi_id');
    }

    public function trangThaiMoi()
    {
        return $this->belongsTo(TrangThai::class, 'trang_thai_moi_id');
    }
}
