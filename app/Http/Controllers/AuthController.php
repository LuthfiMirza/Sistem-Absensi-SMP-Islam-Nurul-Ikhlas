<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            "title" => "Masuk"
        ]);
    }

    public function authenticate(LoginRequest $request)
    {
        $remember = $request->boolean('remember');
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials, $remember)) { // login gagal
            request()->session()->regenerate();
            $data = [
                "success" => true,
                "redirect_to" => auth()->user()->isUser() ? route('home.index') : route('dashboard.index'),
                "message" => "Login berhasil, silahkan tunggu!"
            ];
            return response()->json($data);
        }

        $data = [
            "success" => false,
            "message" => "Login gagal, silahkan coba lagi!"
        ];
        return response()->json($data)->setStatusCode(400);
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->regenerate();
        request()->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Anda berhasil keluar.');
    }

    public function profile()
    {
        return view('profile.index', [
            'title' => 'Profil Saya',
            'user' => auth()->user()
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini harus diisi',
            'password.required' => 'Password baru harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = auth()->user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini tidak benar']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil diperbarui');
    }
}
