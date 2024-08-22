<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Uraian;
use Illuminate\Http\Request;
use Exception;
use App\Models\Jadwal;

class UraianController extends Controller
{
    public function index()
    {
        // Pengecekan role jika bukan admin maka tidak bisa mengakses
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $uraian = Uraian::all();
        $kegiatan = Kegiatan::all();
        return view('uraian.index', compact('uraian', 'kegiatan'));
    }

    public function create()
    {   
        $kegiatan = Kegiatan::all();
        return view('uraian.create', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_uraian' => 'required',
            'kegiatan_id' => 'required|exists:kegiatan,kegiatan_id',
        ]);

        Uraian::create($validated);

        return redirect()->route('uraian.index')->with('success', 'Uraian created successfully');
    }

    public function show(Uraian $uraian)
    {
        return view('uraian.show', compact('uraian'));
    }

    public function edit($id)
    {
        $uraian = Uraian::findOrFail($id);
        $kegiatan = Kegiatan::all();
        return view('uraian.edit', compact('uraian', 'kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $uraian = Uraian::findOrFail($id);

        $validated = $request->validate([
            'name_uraian' => 'required',
            'kegiatan_id' => 'required|exists:kegiatan,kegiatan_id',
        ]);

        $uraian->update($validated);

        return redirect()->route('uraian.index')->with('success', 'Uraian updated successfully');
    }

    public function destroy($id)
    {
        try {
            $uraian = Uraian::findOrFail($id);
    
            // Check for related records in other tables
            $relatedRecordsCount = Jadwal::where('uraian_id', $id)->count(); // Replace RelatedModel with the actual related model
    
            if ($relatedRecordsCount > 0) {
                return redirect()->route('uraian.index')->with('error', 'Cannot delete Uraian because it has related records.');
            }
    
            $uraian->delete();
            return redirect()->route('uraian.index')->with('success', 'Uraian deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('uraian.index')->with('error', $e->getMessage());
        }    
    }
}