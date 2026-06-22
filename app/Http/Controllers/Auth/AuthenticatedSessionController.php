<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
       // 1. Validasi kredensial login
        $request->authenticate();

        // 2. Cegah serangan fiksasi sesi (Session Fixation)
        $request->session()->regenerate();

        // 3. Logika Distribusi Gerbang (Dynamic Redirect)
        $role = $request->user()->role;

        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($role === 'panitia') {
            return redirect()->intended(route('panitia.dashboard'));
        } elseif ($role === 'siswa') {
            return redirect()->intended(route('student.dashboard'));
        }

        // Jalur darurat (Fallback) jika role tidak dikenali
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
