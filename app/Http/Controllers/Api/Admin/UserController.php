<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user (Pencarian & Filter)
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->latest()->paginate(10);

        return response()->json($users);
    }

    /**
     * Simpan user baru ke database
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User baru berhasil didaftarkan.',
            'data' => $user
        ], 201);
    }

    /**
     * Tampilkan detail user
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update data user
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        // Cegah lockout diri sendiri
        if ($user->id === auth()->id() && $validated['role'] !== $user->role) {
            return response()->json([
                'message' => 'Anda tidak dapat mengubah peran (role) Anda sendiri untuk mencegah lockout.'
            ], 422);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Informasi user berhasil diperbarui.',
            'data' => $user
        ]);
    }

    /**
     * Hapus user
     */
    public function destroy(User $user): JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri.'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'message' => 'User berhasil dihapus dari sistem.'
        ]);
    }

    /**
     * Reset password user
     */
    public function resetPassword(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'message' => 'Kata sandi pengguna ' . $user->name . ' berhasil direset.'
        ]);
    }
}
