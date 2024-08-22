<?php

namespace App\Http\Controllers;

use App\Models\DPA;
use App\Models\Kegiatan;
use App\Models\Jadwal;
use App\Models\Uraian;
use Illuminate\Http\Request;
use Exception;

class KegiatanController extends Controller
{
    public function index()
    {
    // Pengecekan role jika bukan admin maka tidak bisa mengakses
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $kegiatans = Kegiatan::all();
        $dpa = DPA::all();
        return view('kegiatan.index', compact('kegiatans', 'dpa'));
    }

    public function create()
    {   
        $dpa = DPA::all();
        return view('kegiatan.create', compact('dpa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_kegiatan' => 'required|unique:kegiatan,name_kegiatan',
            'dpa_id' => 'required|exists:dpa,dpa_id',
        ]);

        Kegiatan::create($validated);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan created successfully');
    }
    public function show(Kegiatan $kegiatan)
    {
        return view('kegiatan.show', compact('kegiatan'));
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $dpa = DPA::all();
        return view('kegiatan.edit', compact('kegiatan', 'dpa'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $validated = $request->validate([
            'name_kegiatan' => 'required|unique:kegiatan,name_kegiatan,' . $kegiatan->kegiatan_id . ',kegiatan_id',
            'dpa_id' => 'required|exists:dpa,dpa_id',
        ]);

        $kegiatan->update($validated);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan updated successfully');
    }

    public function destroy($id)
    {
        try {
            $kegiatan = Kegiatan::findOrFail($id);
    
            // Check for related records in other tables
            $relatedRecordsCount = Uraian::where('kegiatan_id', $id)->count(); // Replace RelatedModel with the actual related model
            $relatedJadwalCount = Jadwal::where('kegiatan_id', $id)->count();
    
            if ($relatedRecordsCount > 0 || $relatedJadwalCount > 0) {
                return redirect()->route('kegiatan.index')->with('error', 'Cannot delete Kegiatan because it has related records.');
            }
    
            $kegiatan->delete();
            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('kegiatan.index')->with('error', $e->getMessage());
        }
    }
}