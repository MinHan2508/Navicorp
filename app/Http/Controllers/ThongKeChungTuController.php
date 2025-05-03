<?PHP

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChungTu;
use App\Models\LoaiChungTu;
use App\Models\TrangThai;
use App\Models\PhongBan;
use Illuminate\Support\Facades\DB;

class ThongKeChungTuController extends Controller
{
    public function index()
    {
        // Tổng số chứng từ theo loại
        $thongKeTheoLoai = ChungTu::select('id_loai_chung_tu', DB::raw('count(*) as tong'))
            ->groupBy('id_loai_chung_tu')
            ->with('loaiChungTu')
            ->get();

        // Tổng số chứng từ theo trạng thái
        $thongKeTrangThai = ChungTu::select('id_trang_thai_hien_tai', DB::raw('count(*) as tong'))
            ->groupBy('id_trang_thai_hien_tai')
            ->with('trangThai')
            ->get();

        // Thống kê hướng chứng từ
        $thongKeHuong = ChungTu::select('id_huong', DB::raw('count(*) as tong'))
            ->groupBy('id_huong')
            ->with('huong')
            ->get();

        // Số lượng chứng từ theo phòng ban
        $thongKePhongBan = DB::table('chung_tus')
            ->join('users', 'chung_tus.id_nguoi_tao', '=', 'users.id')
            ->join('phong_bans', 'users.id_phongban', '=', 'phong_bans.id')
            ->select('phong_bans.ten_phong_ban', DB::raw('count(*) as tong'))
            ->groupBy('phong_bans.ten_phong_ban')
            ->get();


        // Thống kê chi tiết trạng thái trong từng hướng
        $thongKeHuongChiTietTrangThai = ChungTu::select('id_huong', 'id_trang_thai_hien_tai', DB::raw('count(*) as tong'))
            ->groupBy('id_huong', 'id_trang_thai_hien_tai')
            ->get()
            ->groupBy('id_huong');
        $thongKeHuongChiTietLoai = ChungTu::select('id_huong', 'id_loai_chung_tu', DB::raw('count(*) as tong'))
            ->groupBy('id_huong', 'id_loai_chung_tu')
            ->get()
            ->groupBy('id_huong');
        
        $tatCaLoai = DB::table('loai_chung_tus')->pluck('ten_loai_chung_tu', 'id');

        // Lấy danh sách hướng và trạng thái để hiển thị tên
        $tatCaHuong = DB::table('huong_chung_tus')->pluck('ten_huong_chung_tu', 'id');
        $tatCaTrangThai = DB::table('trang_thai_chung_tus')->pluck('ten_trang_thai', 'id');

        return view('chungtu.baocao', compact(
            'thongKeTheoLoai',
            'thongKeTrangThai',
            'thongKeHuong',
            'thongKePhongBan',
            'thongKeHuongChiTietTrangThai',
            'thongKeHuongChiTietLoai',
            'tatCaLoai',
            'tatCaHuong',
            'tatCaTrangThai'

        ));
    }

}
