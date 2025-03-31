<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
    public function getFullStoragePathAttribute()
    {
        // Lấy mã loại chứng từ, nếu không có thì gán 'khac'
        $maLoai = $this->loaiChungTu->ma_loai_chung_tu;

        // Lấy ngày cập nhật (ưu tiên updated_at), fallback = now()
        $updated = $this->updated_at ?? now();
        $year = Carbon::parse($updated)->format('Y');
        $month = Carbon::parse($updated)->format('m');

        // Kết hợp đường dẫn: storage/<ma_loai>/<năm>/<tháng>/<tên file>
        return "storage/{$maLoai}/{$year}/{$month}/{$this->duong_dan}";
    }

}
