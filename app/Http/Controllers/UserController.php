<?php

namespace App\Http\Controllers;

use App\Models\{PhongBan, VaiTro, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('id_vaitro')) {
            $query->where('id_vaitro', $request->input('id_vaitro'));
        }

        $query->where('id', '!=', 1)
              ->where('id', '!=', auth()->id());

        $users = $query->with(['phongBan', 'vaiTro'])->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $phongbans = PhongBan::all();
        $vaiTros = VaiTro::all();
        return view('users.create', compact('phongbans', 'vaiTros'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_vaitro' => 'nullable|exists:vai_tros,id',
            'sdt' => 'nullable|string|max:20|unique:users',
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'ngay_sinh' => 'nullable|date',
            'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trang_thai' => 'required|in:Hoạt động,Khóa,Khác',
            'id_phongban' => 'nullable|exists:phong_bans,id',
            'ghi_chu' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('anh')) {
            $file = $request->file('anh');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('img/anhthe', $fileName, 'local');
            $imagePath = $fileName;
        }

        $user = new User();
        $user->fill($validated);
        $user->password = Hash::make($validated['password']);
        $user->anh = $imagePath;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Người dùng được tạo thành công.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $phongBans = PhongBan::all();
        $vaiTros = VaiTro::all();

        return view('users.edit', compact('user', 'phongBans', 'vaiTros'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'id_vaitro' => 'nullable|exists:vai_tros,id',
            'sdt' => 'nullable|string|max:20|unique:users,sdt,' . $id,
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'ngay_sinh' => 'nullable|date',
            'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trang_thai' => 'required|in:Hoạt động,Khóa,Khác',
            'id_phongban' => 'nullable|exists:phong_bans,id',
            'ghi_chu' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('anh')) {
            if ($user->anh && Storage::disk('local')->exists($user->anh)) {
                Storage::disk('local')->delete($user->anh);
            }
            $file = $request->file('anh');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('img/anhthe', $fileName, 'local');
            $user->anh = $fileName;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sdt' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'ngay_sinh' => 'nullable|date',
            'anh' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ghi_chu' => 'nullable|string',
        ]);

        if ($request->hasFile('anh')) {
            $file = $request->file('anh');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('img/anhthe', $filename);
            $validated['anh'] = $filename;
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Mật khẩu cũ không đúng.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Mật khẩu đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->anh && Storage::disk('local')->exists($user->anh)) {
            Storage::disk('local')->delete($user->anh);
        }

        $user->phanCongs()->delete();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa.');
    }

    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông tin cá nhân.');
        }

        $user = Auth::user();
        return view('users.profile', compact('user'));
    }
}