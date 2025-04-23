<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::getUsers(true);
        return view('admin.users.list', compact('users'));
    }

    public function create()
    {
        return view('admin.users.add');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'status' => 'nullable|boolean',
                'id_role' => 'required|integer|in:' . implode(',', array_keys(User::getRoles()))
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => $request->status ?? 1,
                'id_role' => $request->id_role,
                'role' => $request->id_role == User::ROLES['admin'] ? 'admin' : 'user'
            ]);

            return redirect()->route('admin.users.list')
                ->with('success', 'Thêm người dùng thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm người dùng: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi thêm người dùng: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id_user)
    {
        $user = User::getUser($id_user);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id_user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$id_user.',id_user',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
                'status' => 'nullable|boolean',
                'id_role' => 'required|integer|in:' . implode(',', array_keys(User::getRoles()))
            ]);

            $user = User::findOrFail($id_user);
            
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => $request->status ?? $user->status,
                'id_role' => $request->id_role,
                'role' => $request->id_role == User::ROLES['admin'] ? 'admin' : 'user'
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            return redirect()->route('admin.users.list')
                ->with('success', 'Cập nhật người dùng thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật người dùng: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật người dùng: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deactivate($id_user)
    {
        try {
            $user = User::findOrFail($id_user);
            $user->deactivate();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã vô hiệu hóa người dùng thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi vô hiệu hóa người dùng: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi vô hiệu hóa người dùng'
            ], 500);
        }
    }

    public function activate($id_user)
    {
        try {
            $user = User::findOrFail($id_user);
            $user->activate();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã kích hoạt người dùng thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi kích hoạt người dùng: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi kích hoạt người dùng'
            ], 500);
        }
    }

    public function destroy($id_user)
    {
        try {
            $user = User::findOrFail($id_user);
            
            // Kiểm tra xem người dùng có đơn hàng đang chờ không
            $pendingOrders = DB::table('orders')
                ->where('id_user', $id_user)
                ->where('id_order_status', 1) // pending = 1
                ->exists();
                
            if ($pendingOrders) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa người dùng vì có đơn hàng đang chờ xử lý'
                ], 400);
            }
            
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa người dùng thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa người dùng: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa người dùng: ' . $e->getMessage()
            ], 500);
        }
    }
} 