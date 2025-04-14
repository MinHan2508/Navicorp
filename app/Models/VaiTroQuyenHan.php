<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Model Pivot trung gian giữa VaiTro và QuyenHan
 * 
 * - Đại diện cho bảng trung gian `vai_tro_quyen_han`
 * - Sử dụng khi muốn truy cập bản ghi pivot như một model thực thụ
 * - Thích hợp khi cần thêm các field phụ vào pivot hoặc xử lý logic riêng
 */
class VaiTroQuyenHan extends Pivot
{
    /**
     * Tên bảng tương ứng trong CSDL
     * Mặc định Laravel sẽ suy đoán theo tên bảng pivot theo chuẩn alphabet
     * Nhưng vì tên bảng tùy chỉnh nên cần chỉ định rõ.
     */
    protected $table = 'vai_tro_quyen_han';

    /**
     * Vô hiệu hoá timestamps vì bảng này không có cột created_at / updated_at
     */
    public $timestamps = false;

    /**
     * Cho phép fill các trường này khi dùng create/update
     */
    protected $fillable = [
        'id_vaitro',     // FK đến bảng vai_tros
        'id_quyenhan'    // FK đến bảng quyen_hans
    ];
}
