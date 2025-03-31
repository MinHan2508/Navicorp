<?php

namespace App\Http\Controllers;

use App\Models\PhongBan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('vaitro')) {
            $query->where('vaitro', $request->input('vaitro'));
        }

        $query->where('id', '!=', 1)
              ->where('id', '!=', auth()->id());

        $users = $query->with('phongBans')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Hiển thị form tạo user.
     */
    public function create()
    {
        $phongbans = PhongBan::all();
        return view('users.create', compact('phongbans'));
    }

    /**
     * Lưu user mới vào database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'vaitro' => 'required|in:giamdoc,nv,truongphong',
            'sdt' => 'nullable|string|max:20|unique:users',
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'required|in:nam,nu',
            'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trang_thai' => 'required|in:Hoạt động,Khóa',
            'phongban_id' => 'required|integer|exists:phong_bans,id',
        ]);

        // Xử lý ảnh đại diện
        $imagePath = null;
        if ($request->hasFile('anh')) {
            $file = $request->file('anh');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('img/anhthe', $fileName, 'local'); // Lưu vào storage/app/img/anhthe
            $imagePath =  $fileName;
        }

        // Tạo user mới
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->vaitro = $validated['vaitro'];
        $user->sdt = $validated['sdt'];
        $user->dia_chi = $validated['dia_chi'];
        $user->gioi_tinh = $validated['gioi_tinh'];
        $user->anh = $imagePath;
        $user->trang_thai = $validated['trang_thai'];
        $user->save();

        // Gắn phòng ban cho user
        $user->phongBans()->attach($validated['phongban_id']);

        return redirect()->route('users.index')->with('success', 'Người dùng được tạo thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa user.
     */
    public function edit($id)
    {
        $user = User::with('phongBans')->findOrFail($id);
        $phongBans = PhongBan::all();
        return view('users.edit', compact('user', 'phongBans'));
    }

    /**
     * Cập nhật thông tin user.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'vaitro' => 'required|in:giamdoc,nv,truongphong',
            'sdt' => 'nullable|string|max:20|unique:users,sdt,' . $id,
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'required|in:nam,nu',
            'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trang_thai' => 'required|in:Hoạt động,Khóa',
            'phong_ban' => 'required|integer|exists:phong_bans,id',
        ]);

        $user = User::findOrFail($id);

        // Xử lý ảnh mới nếu có
        if ($request->hasFile('anh')) {
            if ($user->anh && Storage::disk('local')->exists($user->anh)) {
                Storage::disk('local')->delete($user->anh);
            }

            $file = $request->file('anh');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('img/anhthe', $fileName, 'local');
            $user->anh =  $fileName;
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'vaitro' => $validated['vaitro'],
            'sdt' => $validated['sdt'],
            'dia_chi' => $validated['dia_chi'],
            'gioi_tinh' => $validated['gioi_tinh'],
            'trang_thai' => $validated['trang_thai'],
        ]);

        $user->phongBans()->sync([$validated['phong_ban']]);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công.');
    }

    /**
     * Xóa user.
     */
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

    /**
     * Xem hồ sơ cá nhân.
     */
    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông tin cá nhân.');
        }

        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    /**
     * Xử lý tải lên Excel.
     */
}
