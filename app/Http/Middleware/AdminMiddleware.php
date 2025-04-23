<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        // Kiểm tra xem người dùng có phải là admin không
        if (Auth::user()->id_role !== 1) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
} 