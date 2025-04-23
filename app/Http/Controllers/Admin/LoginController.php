<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.users.login');
    }

    public function showRegisterForm()
    {
        return view('admin.users.register');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Vui lòng nhập mật khẩu'
            ]);

            if (Auth::attempt($credentials)) {
                // Kiểm tra xem người dùng có phải là admin không
                if (Auth::user()->id_role !== 1) {
                    Auth::logout();
                    return back()->with('error', 'Bạn không có quyền truy cập trang này.');
                }

                $request->session()->regenerate();
                return redirect()->intended('admin/main');
            }

            return back()->with('error', 'Email hoặc mật khẩu không chính xác.');

        } catch (\Exception $err) {
            Log::error('Lỗi đăng nhập admin: ' . $err->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'id_role' => 1,
                'role' => 'admin'
            ]);

            Auth::guard('admin')->login($user);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Đăng ký thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.')
                ->withInput($request->except('password'));
        }
    }
} 