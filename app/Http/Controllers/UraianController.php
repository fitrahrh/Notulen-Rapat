<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\DPA;
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
        $dpa = DPA::all();
        $bidang = Bidang::all();
        return view('uraian.create', compact('kegiatan', 'dpa', 'bidang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_uraian' => 'required',
            'kegiatan_id' => 'required|exists:kegiatan,kegiatan_id',
        ]);
    
        try {
            $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);
            $dpa = $kegiatan->dpa;
            if (!$dpa) {
                return redirect()->back()->withErrors(['error' => 'Dpa tidak ditemukan untuk kegiatan ini.']);
            }
            $bidang = $dpa->bidang;
            if (!$bidang) {
                return redirect()->back()->withErrors(['error' => 'Bidang tidak ditemukan untuk Dpa ini.']);
            }
    
            // Tambahkan log untuk debugging
            \Log::info('Dpa ditemukan: ', ['dpa_id' => $dpa->dpa_id]);
            \Log::info('Bidang ditemukan: ', ['bidang_id' => $bidang->bidang_id]);
    
            $uraian = new Uraian([
                'name_uraian' => $request->name_uraian,
                'kegiatan_id' => $kegiatan->kegiatan_id,
                'dpa_id' => $dpa->dpa_id,
                'bidang_id' => $bidang->bidang_id,
            ]);
    
            $uraian->save();
    
            // Log the saved uraian
            \Log::info('Uraian saved:', $uraian->toArray());
    
            return redirect()->route('uraian.index')->with('success', 'Uraian berhasil disimpan.');
        } catch (Exception $e) {
            // Log the exception
            \Log::error('Error saving uraian:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }    public function show(Uraian $uraian)
    {
        return view('uraian.show', compact('uraian'));
    }

    public function edit($id)
    {
        $uraian = Uraian::findOrFail($id);
        $kegiatan = Kegiatan::all();
        $dpa = DPA::all();
        $bidang = Bidang::all();
        return view('uraian.edit', compact('uraian', 'kegiatan', 'dpa', 'bidang'));
    }
    
    public function update(Request $request, $id)
    {
        try {
            $uraian = Uraian::findOrFail($id);
    
            $request->validate([
                'name_uraian' => 'required',
                'kegiatan_id' => 'required|exists:kegiatan,kegiatan_id',
            ]);
    
            $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);
            $dpa = $kegiatan->dpa;
            if (!$dpa) {
                return redirect()->back()->withErrors(['error' => 'Dpa tidak ditemukan untuk kegiatan ini.']);
            }
            $bidang = $dpa->bidang;
            if (!$bidang) {
                return redirect()->back()->withErrors(['error' => 'Bidang tidak ditemukan untuk Dpa ini.']);
            }
    
            // Tambahkan log untuk debugging
            \Log::info('Dpa ditemukan: ', ['dpa_id' => $dpa->dpa_id]);
            \Log::info('Bidang ditemukan: ', ['bidang_id' => $bidang->bidang_id]);
    
            // Update uraian dengan data yang divalidasi dan dpa serta bidang yang sesuai
            $uraian->update([
                'name_uraian' => $request->name_uraian,
                'kegiatan_id' => $kegiatan->kegiatan_id,
                'dpa_id' => $dpa->dpa_id,
                'bidang_id' => $bidang->bidang_id,
            ]);
    
            return redirect()->route('uraian.index')->with('success', 'Uraian berhasil diperbarui.');
        } catch (Exception $e) {
            // Tangani kesalahan dan kembalikan pesan error
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui uraian: ' . $e->getMessage()]);
        }
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