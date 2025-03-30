<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChungTu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chung_tus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ma_chung_tu',
        'tieu_de',
        'duong_dan',
        'ghi_chu',
        'id_loai_chung_tu',
        'nguoi_tao_id',
        'nguoi_gui_doi_tac_id',
        'trang_thai_id',
    ];

    /**
     * Define the relationship with the LoaiChungTu model.
     */
    public function loaiChungTu()
    {
        return $this->belongsTo(\App\Models\LoaiChungTu::class, 'id_loai_chung_tu');
    }

    /**
     * Define the relationship with the User model (Nguoi Tao).
     */
    public function nguoiTao()
    {
        return $this->belongsTo(\App\Models\User::class, 'nguoi_tao_id');
    }

    /**
     * Define the relationship with the DoiTac model (Nguoi Gui Doi Tac).
     */
    public function nguoiGuiDoiTac()
    {
        return $this->belongsTo(\App\Models\DoiTac::class, 'nguoi_gui_doi_tac_id');
    }

    /**
     * Define the relationship with the TrangThaiChungTu model.
     */
    public function trangThai()
    {
        return $this->belongsTo(\App\Models\TrangThaiChungTu::class, 'trang_thai_id');
    }
}
