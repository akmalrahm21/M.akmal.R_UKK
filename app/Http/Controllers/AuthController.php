<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return $this->redirectUserBasedOnRole();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return $this->redirectUserBasedOnRole();
        }

        return back()->withErrors(['email' => 'Email or password is incorrect']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    private function redirectUserBasedOnRole()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect()->route('admin.kamar.index');
        } elseif ($user->role == 'resepsionis') {
            return redirect()->route('resepsionis.index');
        } else {
            return redirect()->route('home');
        }
    }
}
