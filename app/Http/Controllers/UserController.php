<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.users');
    }

    // DataTables verilerini döndüren fonksiyon
    public function getData()
    {
        $users = User::query();
        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '
                    <select class="form-select update-role" data-user-id="' . $user->id . '">
                        <option value="user" ' . ($user->role === 'user' ? 'selected' : '') . '>User</option>
                        <option value="admin" ' . ($user->role === 'admin' ? 'selected' : '') . '>Admin</option>
                    </select>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|in:user,admin',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı rolü başarıyla güncellendi.',
        ]);
    }
}
