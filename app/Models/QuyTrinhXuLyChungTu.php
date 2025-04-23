<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuyTrinhXuLyChungTu extends Model
{
    use HasFactory;

    protected $table = 'quy_trinh_xu_ly_chung_tu';

    protected $fillable = [
        'id_tu_trang_thai',
        'id_den_trang_thai',
        'id_huong',
        'thu_tu',
        'mo_ta',
    ];

    public function tuTrangThai()
    {
        return $this->belongsTo(TrangThaiChungTu::class, 'id_tu_trang_thai');
    }

    public function denTrangThai()
    {
        return $this->belongsTo(TrangThaiChungTu::class, 'id_den_trang_thai');
    }

    public function huong()
    {
        return $this->belongsTo(HuongChungTu::class, 'id_huong');
    }



    // Load luôn cả trạng thái đích trong mọi truy vấn
    protected static function booted()
    {
        static::addGlobalScope('withTrangThai', function ($builder) {
            $builder->with(['tuTrangThai', 'denTrangThai', 'huong']);
        });
    }
}
