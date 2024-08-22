<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    // Display a listing of the resource
    public function index(Request $request)
    {
    // Pengecekan role jika bukan admin maka tidak bisa mengakses
    if (auth()->user()->role !== 'admin') {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }        
        $search = $request->input('search');
        $pegawais = Pegawai::query()
            ->where('nama_pegawai', 'LIKE', "%{$search}%")
            ->orWhere('nip', 'LIKE', "%{$search}%")
            ->orWhere('jabatan', 'LIKE', "%{$search}%")
            ->paginate(10); // Menggunakan paginate dengan limit 10
    
        $bidangs = Bidang::all();
        
        return view('pegawai.index', compact('pegawais', 'bidangs', 'search'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        $bidangs = Bidang::all();
        return view('pegawai.create', compact('bidangs'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        //pengecekan role jika bukan admin maka tidak bisa mengakses
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('pegawai.index')->with('error', 'You do not have admin access');
        }

        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:pegawai',
            'jabatan' => 'required|string|max:255',
            'bidang_id' => 'nullable|exists:bidang,bidang_id',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pegawai',
            'password' => 'string|min:8|confirmed', // Pastikan password ada di request
        ]);

        $pegawai = Pegawai::create($request->all());

        // User sudah akan otomatis dibuat oleh event 'created' pada model Pegawai

        return redirect()->route('pegawai.index')->with('success', 'Pegawai created successfully.');
    }

    // Display the specified resource
    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $bidangs = Bidang::all();
        return view('pegawai.edit', compact('pegawai', 'bidangs'));
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        
        //pengecekan role jika bukan admin maka tidak bisa mengakses
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('pegawai.index')->with('error', 'You do not have admin access');
        }

        $pegawai = Pegawai::findOrFail($id);
    
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:pegawai,nip,' . $pegawai->pegawai_id . ',pegawai_id',
            'jabatan' => 'required|string|max:255',
            'bidang_id' => 'nullable|exists:bidang,bidang_id',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pegawai,email,' . $pegawai->pegawai_id . ',pegawai_id',
            'password' => 'nullable|confirmed',
        ]);
    
        $pegawai->update($request->all());
    
        // Update corresponding user data
        $user = User::where('pegawai_id', $pegawai->pegawai_id)->first();
        if ($user) {
            $user->name = $request->input('nama_pegawai');
            $user->email = $request->input('email');
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }
    
        return redirect()->route('pegawai.index')->with('success', 'Pegawai updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {

        //pengecekan role jika bukan admin maka tidak bisa mengakses
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('pegawai.index')->with('error', 'You do not have admin access');
        }

        $pegawai = Pegawai::findOrFail($id);
    
        // Hapus user yang terkait
        User::where('pegawai_id', $pegawai->pegawai_id)->delete();
    
        $pegawai->delete();
    
        return redirect()->route('pegawai.index')->with('success', 'Pegawai deleted successfully.');
    }

    // Function For API
    public function apiIndex()
    {
        $pegawais = Pegawai::all();
        return response()->json($pegawais);
    }

    public function apiStore(Request $request){
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:pegawai',
            'jabatan' => 'required|string|max:255',
            'bidang_id' => 'nullable|exists:bidang,bidang_id',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pegawai',
            'password' => 'string|min:8|confirmed', // Pastikan password ada di request
        ]);

        $pegawai = Pegawai::create($validated);
        return response()->json([
            'message' => 'Pegawai created successfully!',
            'pegawai' => [
                'pegawai_id' => $pegawai->pegawai_id,
                'nama_pegawai' => $pegawai->nama_pegawai,
                'nip' => $pegawai->nip,
                'jabatan' => $pegawai->jabatan,
                'bidang_id' => $pegawai->bidang_id,
                'alamat' => $pegawai->alamat,
                'jenis_kelamin' => $pegawai->jenis_kelamin,
                'no_hp' => $pegawai->no_hp,
                'email' => $pegawai->email,
            ]
        ]);
    }

public function apiShow($id)
{
    $pegawai = Pegawai::with('user')->findOrFail($id);
    return response()->json([
        'message' => 'Success',
        'pegawai' => [
            'pegawai_id' => $pegawai->pegawai_id,
            'nama_pegawai' => $pegawai->nama_pegawai,
            'nip' => $pegawai->nip,
            'jabatan' => $pegawai->jabatan,
            'bidang_id' => $pegawai->bidang_id,
            'alamat' => $pegawai->alamat,
            'jenis_kelamin' => $pegawai->jenis_kelamin,
            'no_hp' => $pegawai->no_hp,
            'email' => $pegawai->email,
            'profile_image' => $pegawai->user ? $pegawai->user->profile_image : null,
        ]
    ]);
}

    public function apiDestroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
    
        // Hapus user yang terkait
        User::where('pegawai_id', $pegawai->pegawai_id)->delete();
    
        $pegawai->delete();
    
        return response()->json([
            'message' => 'Pegawai deleted successfully!'
        ]);
    }
}