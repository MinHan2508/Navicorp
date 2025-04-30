<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\NguoiNhanChungTu;
use App\Models\ChungTu;
use App\Models\User;
use App\Models\PhongBan;
use App\Models\DoiTac;
use Illuminate\Http\Request;
use App\Mail\GuiChungTuMail;

class NguoiNhanChungTuController extends Controller
{
    /**
     * Hiển thị form chọn nhiều người nhận chứng từ
     */
    public function create($idChungTu)
    {
        $chungTu = ChungTu::with('trangThaiDen')->findOrFail($idChungTu);
        $user = auth()->user();


        // Nếu hợp lệ thì lấy danh sách người nhận
        $users = User::all();
        $phongBans = PhongBan::all();
        $doiTacs = DoiTac::all();

        return view('nguoinhanchungtu.create', compact('chungTu', 'users', 'phongBans', 'doiTacs'));
    }


    /**
     * Xử lý lưu nhiều người nhận chứng từ
     */

    public function store(Request $request, $idChungTu)
    {
        $request->validate([
            'id_users' => 'nullable|array',
            'id_users.*' => 'exists:users,id',
            'id_phong_bans' => 'nullable|array',
            'id_phong_bans.*' => 'exists:phong_bans,id',
            'id_doi_tacs' => 'nullable|array',
            'id_doi_tacs.*' => 'exists:doi_tacs,id',
            'ghi_chu' => 'nullable|string'
        ]);

        $chungTu = ChungTu::findOrFail($idChungTu);

        // Lấy danh sách đã gửi
        $daGui = NguoiNhanChungTu::where('id_chung_tu', $idChungTu)->get();
        $usersDaGui = $daGui->where('loai_nguoi_nhan', 'user')->pluck('id_nguoi_nhan')->toArray();
        $phongBansDaGui = $daGui->where('loai_nguoi_nhan', 'phong_ban')->pluck('id_phong_ban')->toArray();
        $doiTacsDaGui = $daGui->where('loai_nguoi_nhan', 'doi_tac')->pluck('id_doi_tac')->toArray();

        // Tách dữ liệu người chọn mới
        $usersChon = $request->input('id_users', []);
        $phongBansChon = $request->input('id_phong_bans', []);
        $doiTacsChon = $request->input('id_doi_tacs', []);

        $usersMoi = array_diff($usersChon, $usersDaGui);
        $phongBansMoi = array_diff($phongBansChon, $phongBansDaGui);
        $doiTacsMoi = array_diff($doiTacsChon, $doiTacsDaGui);

        // Nếu tất cả đều trùng
        if (empty($usersMoi) && empty($phongBansMoi) && empty($doiTacsMoi)) {
            $nguoiTrung = [];

            foreach ($usersChon as $id) {
                if (in_array($id, $usersDaGui)) {
                    $user = User::find($id);
                    $nguoiTrung[] = '👤 ' . ($user->name ?? '[User đã xoá]');
                }
            }

            foreach ($phongBansChon as $id) {
                if (in_array($id, $phongBansDaGui)) {
                    $pb = PhongBan::find($id);
                    $nguoiTrung[] = '🏢 ' . ($pb->ten_phong_ban ?? '[Phòng đã xoá]');
                }
            }

            foreach ($doiTacsChon as $id) {
                if (in_array($id, $doiTacsDaGui)) {
                    $dt = DoiTac::find($id);
                    $nguoiTrung[] = '🤝 ' . ($dt->ten_doi_tac ?? '[Đối tác đã xoá]');
                }
            }

            $thongBao = "❌ Các đối tượng sau đã nhận chứng từ này trước đó:<br>" . implode('<br>', $nguoiTrung);

            return redirect()
                ->route('chungtu.show', $idChungTu)
                ->with('error_html', $thongBao)
                ->with('modal_open', true);
        }

        // 📤 Gửi cho cá nhân (user)
        foreach ($usersMoi as $userId) {
            $user = User::find($userId);
            if ($user && $user->email) {
                Mail::to($user->email)->queue(new GuiChungTuMail($chungTu, false, $request->ghi_chu));

            }

            NguoiNhanChungTu::create([
                'id_chung_tu' => $idChungTu,
                'id_nguoi_nhan' => $userId,
                'loai_nguoi_nhan' => 'user',
                'da_xem' => false,
                'ghi_chu' => $request->ghi_chu,
            ]);
        }

        // 📤 Gửi cho phòng ban
        foreach ($phongBansMoi as $phongBanId) {
            // Gửi mail cho toàn bộ nhân viên
            $nhanViens = User::where('id_phongban', $phongBanId)
                ->whereNotNull('email')
                ->get();

            foreach ($nhanViens as $nv) {
                Mail::to($user->email)->queue(new GuiChungTuMail($chungTu, false, $request->ghi_chu));

            }

            // Lưu nhận cho phòng ban
            NguoiNhanChungTu::create([
                'id_chung_tu' => $idChungTu,
                'id_phong_ban' => $phongBanId,
                'loai_nguoi_nhan' => 'phong_ban',
                'da_xem' => false,
                'ghi_chu' => $request->ghi_chu,
            ]);
        }

        // 📤 Gửi cho đối tác
        foreach ($doiTacsMoi as $doiTacId) {
            $dt = DoiTac::find($doiTacId);
            if ($dt && $dt->email) {
                Mail::to($user->email)->queue(new GuiChungTuMail($chungTu, true, $request->ghi_chu));

            }

            NguoiNhanChungTu::create([
                'id_chung_tu' => $idChungTu,
                'id_doi_tac' => $doiTacId,
                'loai_nguoi_nhan' => 'doi_tac',
                'da_xem' => false,
                'ghi_chu' => $request->ghi_chu,
            ]);
        }

        return redirect()
            ->route('chungtu.show', $idChungTu)
            ->with('success', '📤 Đã gửi chứng từ thành công!');
    }





    public function showDaGui($idChungTu, Request $request)
    {
        $chungTu = ChungTu::findOrFail($idChungTu);

        $nguoiNhans = NguoiNhanChungTu::with(['nguoiNhan', 'phongBan', 'doiTac'])
            ->where('id_chung_tu', $idChungTu)
            ->get();

        // Tìm kiếm nếu có từ khoá
        if ($request->filled('q')) {
            $keyword = mb_strtolower($request->q);

            $nguoiNhans = $nguoiNhans->filter(function ($nn) use ($keyword) {
                $fields = [];

                if ($nn->loai_nguoi_nhan === 'user') {
                    $fields[] = $nn->nguoiNhan->name ?? '';
                    $fields[] = $nn->nguoiNhan->email ?? '';
                }

                if ($nn->loai_nguoi_nhan === 'phong_ban') {
                    $fields[] = $nn->phongBan->ten_phong_ban ?? '';
                }

                if ($nn->loai_nguoi_nhan === 'doi_tac') {
                    $fields[] = $nn->doiTac->ten_doi_tac ?? '';
                    $fields[] = $nn->doiTac->email ?? '';
                }

                // So khớp keyword
                return collect($fields)->filter(function ($f) use ($keyword) {
                    return str_contains(mb_strtolower($f), $keyword);
                })->isNotEmpty();
            });
        }

        return view('nguoinhanchungtu.show_da_gui', compact('chungTu', 'nguoiNhans'));
    }


}
