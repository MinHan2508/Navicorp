<?php

namespace App\Http\Controllers;

use App\Models\NguoiNhanChungTu;
use App\Models\ChungTu;
use App\Models\User;
use App\Models\PhongBan;
use App\Models\DoiTac;
use Illuminate\Http\Request;

class NguoiNhanChungTuController extends Controller
{
    /**
     * Hiển thị form chọn nhiều người nhận chứng từ
     */
    public function create($idChungTu)
    {
        $chungTu = ChungTu::findOrFail($idChungTu);
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

        // Lưu từng user được chọn
        if ($request->filled('id_users')) {
            foreach ($request->id_users as $userId) {
                NguoiNhanChungTu::create([
                    'id_chung_tu' => $idChungTu,
                    'id_nguoi_nhan' => $userId,
                    'loai_nguoi_nhan' => 'user',
                    'da_xem' => false,
                    'ghi_chu' => $request->ghi_chu,
                ]);
            }
        }

        // Lưu từng phòng ban được chọn
        if ($request->filled('id_phong_bans')) {
            foreach ($request->id_phong_bans as $phongBanId) {
                NguoiNhanChungTu::create([
                    'id_chung_tu' => $idChungTu,
                    'id_phong_ban' => $phongBanId,
                    'loai_nguoi_nhan' => 'phong_ban',
                    'da_xem' => false,
                    'ghi_chu' => $request->ghi_chu,
                ]);
            }
        }

        // Lưu từng đối tác được chọn
        if ($request->filled('id_doi_tacs')) {
            foreach ($request->id_doi_tacs as $doiTacId) {
                NguoiNhanChungTu::create([
                    'id_chung_tu' => $idChungTu,
                    'id_doi_tac' => $doiTacId,
                    'loai_nguoi_nhan' => 'doi_tac',
                    'da_xem' => false,
                    'ghi_chu' => $request->ghi_chu,
                ]);
            }
        }

        return redirect()->route('chungtu.index')->with('success', 'Gửi chứng từ thành công!');
    }
}
