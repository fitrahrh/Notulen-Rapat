<?php

namespace App\Http\Controllers;

use App\Models\Jenisrapat;
use Illuminate\Http\Request;
use Exception;

class JenisRapatController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $Jenisrapat = Jenisrapat::all();
        return view('jenis-rapat.index', compact('Jenisrapat'));
    }

    public function create()
    {
        return view('jenis-rapat.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $validated = $request->validate([
            'jenis_rapat' => 'required|unique:jenis_rapat,jenis_rapat',
        ]);

        Jenisrapat::create($validated);

        return redirect()->route('jenis-rapat.index')->with('success', 'Jenis Rapat created successfully');
    }

    public function edit($id)
    {
        $Jenisrapat = Jenisrapat::findOrFail($id);
        return view('jenis-rapat.edit', compact('Jenisrapat'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $Jenisrapat = Jenisrapat::findOrFail($id);

        $validated = $request->validate([
            'jenis_rapat' => 'required|unique:jenis_rapat,jenis_rapat,' . $Jenisrapat->jenis_rapat_id . ',jenis_rapat_id',
        ]);

        $Jenisrapat->update($validated);

        return redirect()->route('jenis-rapat.index')->with('success', 'Jenis Rapat updated successfully');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            $Jenisrapat = Jenisrapat::findOrFail($id);
            $Jenisrapat->delete();
            return redirect()->route('jenis-rapat.index')->with('success', 'Jenis Rapat deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('jenis-rapat.index')->with('error', $e->getMessage());
        }
    }
}