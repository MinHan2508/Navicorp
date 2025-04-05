<?php
namespace App\Http\Controllers;

use App\Models\DoiTac;
use Illuminate\Http\Request;

class DoiTacController extends Controller
{
    public function index()
    {
        $doiTacs = DoiTac::latest()->paginate(10);
        return view('doitac.index', compact('doiTacs'));
    }

    public function create()
    {
        return view('doitac.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_doi_tac' => 'required|string|max:255',
            'dia_chi' => 'nullable|string|max:255',
            'sdt' => 'nullable|string|max:20|unique:doi_tacs,sdt',
            'email' => 'nullable|email|max:100|unique:doi_tacs,email',
            'loai_doi_tac' => 'required|in:Cá nhân,Tổ chức,Nhà Nước,Khác',
            'ma_so_thue' => 'nullable|string|max:255',
            'nguoi_dai_dien' => 'nullable|string|max:255',
            'chuc_vu_dai_dien' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'ghi_chu' => 'nullable|string',
        ]);

        DoiTac::create($validated);
        return redirect()->route('doitac.index')->with('success', 'Đối tác đã được tạo thành công.');
    }

    public function edit($id)
    {
        $doiTac = DoiTac::findOrFail($id);
        return view('doitac.edit', compact('doiTac'));
    }

    public function update(Request $request, $id)
    {
        $doiTac = DoiTac::findOrFail($id);

        $validated = $request->validate([
            'ten_doi_tac' => 'required|string|max:255',
            'dia_chi' => 'nullable|string|max:255',
            'sdt' => 'nullable|string|max:20|unique:doi_tacs,sdt,' . $doiTac->id,
            'email' => 'nullable|email|max:100|unique:doi_tacs,email,' . $doiTac->id,
            'loai_doi_tac' => 'required|in:Cá nhân,Tổ chức,Nhà Nước,Khác',
            'ma_so_thue' => 'nullable|string|max:255',
            'nguoi_dai_dien' => 'nullable|string|max:255',
            'chuc_vu_dai_dien' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'ghi_chu' => 'nullable|string',
        ]);

        $doiTac->update($validated);
        return redirect()->route('doitac.index')->with('success', 'Đối tác đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $doiTac = DoiTac::findOrFail($id);
        $doiTac->delete();

        return redirect()->route('doitac.index')->with('success', 'Đối tác đã được xóa.');
    }
}
