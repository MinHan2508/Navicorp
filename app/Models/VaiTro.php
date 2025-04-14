<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class VaiTro extends Model
{
    use HasFactory;
    protected $table = 'vai_tros';

    protected $fillable = [
        'ma_vai_tro',
        'ten_vai_tro',
        'ghi_chu',
    ];
    public function quyenHans()
{
    return $this->belongsToMany(
        \App\Models\QuyenHan::class,   // Model liên kết
        'vai_tro_quyen_han',           // Tên bảng pivot
        'id_vaitro',                   // Cột FK tới bảng VaiTro
        'id_quyenhan'                  // Cột FK tới bảng QuyenHan
    );
}

}

