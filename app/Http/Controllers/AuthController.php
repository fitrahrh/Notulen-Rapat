<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Alert::success('Success', 'Login success !');
            return redirect()->intended('/dashboard');
        } else {
            Alert::error('Error', 'Login failed !');
            return redirect('/login');
        }
    }

    public function register()
    {
        $pegawais = Pegawai::all();

        return view('auth.register', [
            'title' => 'Register',
            'pegawais' => $pegawais,
        ]);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'passwordConfirm' => 'required|same:password',
            'pegawai_id' => 'nullable', 
        ]);

        $validated['password'] = Hash::make($request['password']);
        $validated['role'] = 'admin';

        $user = User::create($validated);

        Alert::success('Success', 'Register success !');
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Success', 'Logout success !');
        return redirect('/login');
    }

    public function showResetPasswordForm()
    {
        return view('auth.reset-password', [
            'title' => 'Reset Password',
        ]);
    }
    // reset password method
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if ($status === Password::RESET_LINK_SENT) {
            Alert::success('Success', __($status));
            return back();
        } else {
            Alert::error('Error', __($status));
            return back();
        }
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
    
        $response = Password::reset($request->only(
            'email', 'password', 'password_confirmation', 'token'
        ), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });
    
        return $response == Password::PASSWORD_RESET
                    ? redirect('/login')->with('status', __($response))
                    : back()->withErrors(['email' => [__($response)]]);
    }

    // API Login Method
    public function apiLogin(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        return response()->json([
            'message' => 'Login Gagal! Email Anda Salah!'
        ], 401);
    }

    if (!Hash::check($credentials['password'], $user->password)) {
        return response()->json([
            'message' => 'Login Gagal! Password Anda Salah!'
        ], 401);
    }

    Auth::login($user);
    $request->session()->regenerate();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful!',
        'user' => [
            'id' => $user->id_user,
            'name' => $user->name,
            'email' => $user->email,
            'profile_image' => $user->profile_image,
            'access_token' => $token
        ]
    ], 200);
}

    // API Register Method
    public function apiRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'pegawai_id' => 'nullable',
        ]);

        $validated['password'] = Hash::make($request['password']);
        $validated['role'] = 'admin';

        $user = User::create($validated);

        return response()->json([
            'message' => 'Registration successful!',
            'user' => $user
        ], 201);
    }

    // API Logout Method
    public function apiLogout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Log out success'], 200);
    }
}
