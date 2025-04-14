<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuyenHan extends Model
{
    use HasFactory;
    protected $table = 'quyen_hans';
    protected $fillable = [
        'ma_quyen',
        'ten_quyen',
    ];

    public function vaiTros()
{
    return $this->belongsToMany(
        \App\Models\VaiTro::class,
        'vai_tro_quyen_han',
        'id_quyenhan',
        'id_vaitro'
    );
}


}
