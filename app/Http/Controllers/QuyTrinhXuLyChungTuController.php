<?php
namespace App\Http\Controllers;

use App\Models\QuyTrinhXuLyChungTu;
use App\Models\HuongChungTu;
use App\Models\TrangThaiChungTu;
use Illuminate\Http\Request;

class QuyTrinhXuLyChungTuController extends Controller
{
    
    public function index()
{
    $dsQuyTrinhGoc = QuyTrinhXuLyChungTu::with(['huong', 'tuTrangThai', 'denTrangThai'])
        ->orderBy('id_huong')
        ->orderBy('thu_tu')
        ->get()
        ->groupBy('id_huong');

    // Gắn thêm bước khởi tạo vào đầu mỗi nhóm
    $dsQuyTrinh = $dsQuyTrinhGoc->map(function ($group) {
        $first = $group->first();

        $buocKhoiTao = (object)[
            'id' => 0,
            'thu_tu' => 1,
            'mo_ta' => 'Khởi tạo / Tiếp nhận',
            'created_at' => now(),
            'huong' => $first->huong,
            'tuTrangThai' => (object)['ten' => '-'],
            'denTrangThai' => (object)['ten' => 'Khởi tạo'],
        ];

        // Dịch lại các bước tiếp theo lên thứ tự sau 1
        foreach ($group as $item) {
            $item->thu_tu += 1;
        }

        return collect([$buocKhoiTao])->merge($group);
    });

    return view('quytrinh.index', compact('dsQuyTrinh'));

}


    public function create()
    {
        $dsHuong = HuongChungTu::all();
        $dsTrangThai = TrangThaiChungTu::all();
        return view('quytrinh.create', compact('dsHuong', 'dsTrangThai'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'id_huong' => 'required|exists:huong_chung_tus,id',
        'id_tu_trang_thai' => 'required|exists:trang_thai_chung_tus,id',
        'id_den_trang_thai' => 'required|exists:trang_thai_chung_tus,id',
        'mo_ta' => 'nullable|string',
    ]);

    // Tìm thứ tự cao nhất trong hướng tương ứng
    $maxThuTu = QuyTrinhXuLyChungTu::where('id_huong', $request->id_huong)->max('thu_tu');
    $thuTuMoi = is_null($maxThuTu) ? 1 : $maxThuTu + 1;

    $data = $request->all();
    $data['thu_tu'] = $thuTuMoi;

    QuyTrinhXuLyChungTu::create($data);

    return redirect()->route('quytrinh.index')->with('success', 'Tạo mới quy trình xử lý thành công.');
    }   


    public function show($id)
    {
        $quyTrinh = QuyTrinhXuLyChungTu::with(['huong', 'tuTrangThai', 'denTrangThai'])->findOrFail($id);
        return view('quytrinh.show', compact('quyTrinh'));
    }

    public function edit($id)
    {
        $quyTrinh = QuyTrinhXuLyChungTu::findOrFail($id);
        $dsHuong = HuongChungTu::all();
        $dsTrangThai = TrangThaiChungTu::all();
        return view('quytrinh.edit', compact('quyTrinh', 'dsHuong', 'dsTrangThai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_huong' => 'required|exists:huong_chung_tus,id',
            'id_tu_trang_thai' => 'required|exists:trang_thai_chung_tus,id',
            'id_den_trang_thai' => 'required|exists:trang_thai_chung_tus,id',
            'thu_tu' => 'nullable|integer',
            'mo_ta' => 'nullable|string',
        ]);

        $quyTrinh = QuyTrinhXuLyChungTu::findOrFail($id);
        $quyTrinh->update($request->all());

        return redirect()->route('quytrinh.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $quyTrinh = QuyTrinhXuLyChungTu::findOrFail($id);
        $quyTrinh->delete();

        return redirect()->route('quytrinh.index')->with('success', 'Xóa thành công.');
    }
}
