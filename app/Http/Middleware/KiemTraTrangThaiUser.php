<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KiemTraTrangThaiUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->trang_thai === 'Khóa') {
            Auth::logout(); // Đăng xuất
        
            return redirect()->route('user.biKhoa', ['ly_do' => $user->ghi_chu ?? 'Tài khoản bị khóa.']);

        }
        return $next($request);
    }
}
