<?php
namespace App\Http\Controllers;

use App\Models\DPA;
use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Exception;

class DpaController extends Controller
{
    public function index()
    {
    // Pengecekan role jika bukan admin maka tidak bisa mengakses
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $dpa = DPA::all();
        $bidang = Bidang::all();
        return view('dpa.index', compact('dpa', 'bidang'));
    }

    public function create()
    {
        $bidang = Bidang::all();
        return view('dpa.create', compact('bidang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_dpa' => 'required|unique:dpa,name_dpa',
            'bidang_id' => 'required|exists:bidang,bidang_id',
        ]);

        DPA::create($validated);

        return redirect()->route('dpa.index')->with('success', 'DPA created successfully');
    }

    public function show(DPA $dpa)
    {
        return view('dpa.show', compact('dpa'));
    }

    public function edit($id)
    {
        $dpa = DPA::findOrFail($id);
        $bidang = Bidang::all();
        return view('dpa.edit', compact('dpa', 'bidang'));
    }

    public function update(Request $request, $id)
    {
        $dpa = DPA::findOrFail($id);

        $validated = $request->validate([
            'name_dpa' => 'required|unique:dpa,name_dpa,' . $dpa->dpa_id . ',dpa_id',
            'bidang_id' => 'required|exists:bidang,bidang_id',
        ]);

        $dpa->update($validated);

        return redirect()->route('dpa.index')->with('success', 'DPA updated successfully');
    }

    public function destroy($id)
    {
        try {
            $dpa = DPA::findOrFail($id);
    
            // Check for related records in other tables
            $relatedRecordsCount = Kegiatan::where('dpa_id', $id)->count(); // Replace RelatedModel with the actual related model
            $relatedJadwalCount = Jadwal::where('dpa_id', $id)->count();
    
            if ($relatedRecordsCount > 0 || $relatedJadwalCount > 0) {
                return redirect()->route('dpa.index')->with('error', 'Cannot delete DPA because it has related records.');
            }
    
            $dpa->delete();
            return redirect()->route('dpa.index')->with('success', 'DPA deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('dpa.index')->with('error', $e->getMessage());
        }
    }
}