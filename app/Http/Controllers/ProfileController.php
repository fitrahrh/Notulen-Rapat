<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Intervention\Image\Facades\Image;
use App\Models\Pegawai;
use Exception;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;
    
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|string|min:8|confirmed',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        // Update data di tabel users
        $user->name = $request->name;
        $user->email = $request->email;
        $pegawai->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('ttd')) {
            $file = $request->file('ttd');
            $filename = 'ttd_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/ttd'), $filename);
            $user->ttd = $filename;
        }
        $user->save();
    
        // Update data di tabel pegawai
        $pegawai->alamat = $request->alamat;
        $pegawai->no_hp = $request->no_hp;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updateProfileApi(Request $request) {
        try {
            $user = Auth::user();
            $pegawai = $user->pegawai;
    
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
                'current_password' => 'required_with:password|string',
                'password' => 'nullable|string|confirmed',
                'alamat' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string|max:15',
                'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
                'ttd' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            //cek password lama
            if ($request->filled('password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json(['error' => 'Current password is incorrect'], 400);
                }
                $user->password = Hash::make($request->password);
            }
    
            // Update user data
            if ($request->filled('name')) {
                $user->name = $request->name;
            }
            if ($request->filled('email')) {
                $user->email = $request->email;
                $pegawai->email = $request->email;
            }
    
            $user->save();
    
            // Update pegawai data
            if ($request->filled('alamat')) {
                $pegawai->alamat = $request->alamat;
            }
            if ($request->filled('no_hp')) {
                $pegawai->no_hp = $request->no_hp;
            }
            if ($request->filled('jenis_kelamin')) {
                $pegawai->jenis_kelamin = $request->jenis_kelamin;
            }
            if ($request->hasFile('ttd')) {
                $ttdName = time().'.'.$request->ttd->extension();
                $request->ttd->move(public_path('images'), $ttdName);
                $pegawai->ttd = $ttdName;
            }
    
            $pegawai->save();
    
            return response()->json([
                'message' => 'Profile updated successfully!',
                'user' => $user->load('pegawai')
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update profile', 'errors' => $e->getMessage()], 500);
        }
    }
}
