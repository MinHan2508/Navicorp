<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ChungTu extends Model
{
    use HasFactory;

    protected $table = 'chung_tus';

    protected $fillable = [
        'ma_chung_tu',
        'tieu_de',
        'so_hieu',
        'duong_dan',
        'trich_yeu',
        'noi_ban_hanh',
        'ngay_ban_hanh',
        'ngay_hieu_luc',
        'ngay_het_hieu_luc',
        'ky_so',
        'ghi_chu',
        'id_loai_chung_tu',
        'id_nguoi_tao',
        'id_trang_thai_hien_tai',
        'id_nguoi_gui_doi_tac',
        'id_huong',
    ];
    

    public function loaiChungTu()
    {
        return $this->belongsTo(LoaiChungTu::class, 'id_loai_chung_tu');
    }

    public function nguoiTao()
    {
        return $this->belongsTo(User::class, 'id_nguoi_tao');
    }

    public function nguoiGuiDoiTac()
    {
        return $this->belongsTo(DoiTac::class, 'id_nguoi_gui_doi_tac');
    }

    public function trangThai()
    {
        return $this->belongsTo(TrangThaiChungTu::class, 'id_trang_thai_hien_tai');
    }

    public function huong()
    {
        return $this->belongsTo(\App\Models\HuongChungTu::class, 'id_huong');
    }

    public function getFullStoragePathAttribute()
    {
        $maLoai = $this->loaiChungTu->ma_loai_chung_tu ?? 'khac';
        $updated = $this->updated_at ?? now();
        $year = Carbon::parse($updated)->format('Y');
        $month = Carbon::parse($updated)->format('m');
        return "storage/{$maLoai}/{$year}/{$month}/{$this->duong_dan}";
    }
}
