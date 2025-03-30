<?php

namespace App\Http\Controllers;


use App\Models\PhongBan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // Thêm dòng này



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

        $users = User::with('phongBans')->get(); // Lấy danh sách user + phòng ban

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'vaitro' => 'required|in:giamdoc,nv,truongphong',
            'sdt' => 'nullable|string|max:20|unique:users',
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'required|in:nam,nu',
            'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate ảnh
            'trang_thai' => 'required|in:Hoạt động,Khóa',
            'phong_ban' => 'required|integer|exists:phong_bans,id',
            
        ]);

        // Xử lý upload ảnh
        $imagePath = null;
        if ($request->hasFile('anh')) {
            $file = $request->file('anh');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('img/anhthe/', $fileName);
            $imagePath =  $fileName;
        }

        // Tạo user mới
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->vaitro = $request->vaitro;
        $user->sdt = $request->sdt;
        $user->dia_chi = $request->dia_chi;
        $user->gioi_tinh = $request->gioi_tinh;
        $user->anh = $imagePath;
        $user->trang_thai = $request->trang_thai;
        $user->save();

        // Gán user vào phòng ban
       // $user->phongBans()->attach($request->phongban_id);

        $user->phongBans()->attach($request->phong_ban);  

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Hiển thị form chỉnh sửa user.
     */
    public function edit($id)
    {
        // $user = User::findOrFail($id);
        // $phongbans = PhongBan::all();
        // return view('users.edit', compact('user', 'phongbans'));

        $user = User::with('phongBans')->findOrFail($id);
        $phongBans = PhongBan::all(); // Lấy danh sách phòng ban

        return view('users.edit', compact('user', 'phongBans'));

    }

    /**
     * Cập nhật thông tin user.
     */
    public function update(Request $request, $id)
{
    $request->validate([
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
        // Xóa ảnh cũ nếu tồn tại
        if ($user->anh && file_exists(public_path('storage/img/ANHTHE/' . $user->anh))) {
            unlink(public_path('storage/img/ANHTHE/' . $user->anh));
        }

        // Upload ảnh mới
        $file = $request->file('anh');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('storage/img/ANHTHE');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $fileName);

        // Lưu tên file ảnh vào DB
        $user->anh = $fileName;
    }

    // Cập nhật thông tin user
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'vaitro' => $request->vaitro,
        'sdt' => $request->sdt,
        'dia_chi' => $request->dia_chi,
        'gioi_tinh' => $request->gioi_tinh,
        'trang_thai' => $request->trang_thai,
    ]);

    // Cập nhật phòng ban
    //$user->phongBans()->sync($request->phong_ban);
    $user->phongBans()->sync([$request->phong_ban]);

    return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công.');
}

    /**
     * Xóa user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Xóa ảnh nếu có
        if ($user->anh) {
            Storage::delete(str_replace('storage/', 'public/', $user->anh));
        }

        $user = User::findOrFail($id);

        // Xóa tất cả phân công liên quan trước khi xóa user
        $user->phanCongs()->delete(); 
    
        // Xóa user
        $user->delete();
    
        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa.');

        
    }

    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông tin cá nhân.');
        }
    
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
        return view('users.profile', compact('user'));
    }




    /**
     * Xử lý tải lên Excel.
     */
 
} 