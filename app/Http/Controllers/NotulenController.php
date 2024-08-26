<?php

namespace App\Http\Controllers;

use App\Models\Notulen;
use App\Models\Pegawai;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotulenController extends Controller
{
    public function index()
    {
        // Dapatkan user yang sedang login
        $user = auth()->user();

        if ($user->role == 'admin') {
            $notulen = Notulen::with(['pic', 'penanggung_jawab', 'pencatat', 'user'])->get();
        }else {
            // Dapatkan pegawai yang terkait dengan user yang sedang login
            $pegawai = $user->pegawai;
    
            // Dapatkan bidang yang terkait dengan pegawai
            $bidang = $pegawai->bidang;
    
            // Dapatkan notulen yang terkait dengan bidang tersebut
            $notulen = Notulen::whereHas('jadwal.dpa', function ($query) use ($bidang) {
                $query->where('bidang_id', $bidang->bidang_id);
            })->with(['pic', 'penanggung_jawab', 'pencatat', 'user'])->get();
        }
        
        $pegawai = Pegawai::all();
        $jadwal = Jadwal::all();

        return view('notulen.index', compact('notulen', 'pegawai', 'jadwal'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'jadwal_id' => 'required',
            'jenis_surat' => 'required',
            'nomor_surat' => 'required',
            'surat_undangan' => 'nullable|file|mimes:pdf',
            'berkas_absen' => 'nullable|file|mimes:pdf',
            'berkas_spt' => 'nullable|file|mimes:pdf',
            'berkas_dokumentasi' => 'nullable|file|image',
            'pic_id' => 'required',
            'penanggung_jawab_id' => 'required',
            'pencatat_id' => 'required'
        ]);

        $notulen = new Notulen();
        $notulen->text = $request->text;
        $notulen->jenis_surat = $request->jenis_surat;
        $notulen->nomor_surat = $request->nomor_surat;
        $notulen->jadwal_id = $request->jadwal_id;
        $notulen->pegawai_id = auth()->user()->pegawai_id;
        $notulen->id_user = auth()->user()->id_user;

        if ($request->hasFile('surat_undangan')) {
            $file = $request->file('surat_undangan')->store('public/files');
            $notulen->surat_undangan = basename($file);
        }
        if ($request->hasFile('berkas_absen')) {
            $file = $request->file('berkas_absen')->store('public/files');
            $notulen->berkas_absen = basename($file);
        }
        if ($request->hasFile('berkas_spt')) {
            $file = $request->file('berkas_spt')->store('public/files');
            $notulen->berkas_spt = basename($file);
        }
        if ($request->hasFile('berkas_dokumentasi')) {
            $file = $request->file('berkas_dokumentasi')->store('public/photos');
            $notulen->berkas_dokumentasi = basename($file);
        }

        $notulen->pic_id = $request->pic_id;
        $notulen->penanggung_jawab_id = $request->penanggung_jawab_id;
        $notulen->pencatat_id = $request->pencatat_id;

        $notulen->save();

        return redirect()->route('notulen.index')->with('success', 'Notulen added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required',
            'jadwal_id' => 'required',
            'jenis_surat' => 'required',
            'nomor_surat' => 'required',
            'pic_id' => 'required',
            'penanggung_jawab_id' => 'required',
            'pencatat_id' => 'required'
        ]);
    
        $notulen = Notulen::findOrFail($id);
        $notulen->text = $request->text;
        $notulen->jenis_surat = $request->jenis_surat;
        $notulen->nomor_surat = $request->nomor_surat;
        $notulen->jadwal_id = $request->jadwal_id;
        $notulen->pic_id = $request->pic_id;
        $notulen->penanggung_jawab_id = $request->penanggung_jawab_id;
        $notulen->pencatat_id = $request->pencatat_id;
    
        $notulen->save();
    
        return redirect()->route('notulen.index')->with('success', 'Notulen updated successfully');
    }

    public function show($id)
    {
        $notulen = Notulen::findOrFail($id);
        return response()->json($notulen);
    }

    public function downloadPDF($id)
    {
        set_time_limit(120);
    
        $notulen = Notulen::with(['pic', 'penanggung_jawab', 'pencatat', 'user'])->findOrFail($id);
        $files = [
            'surat_undangan' => Storage::path('public/files/' . $notulen->surat_undangan),
            'berkas_absen' => Storage::path('public/files/' . $notulen->berkas_absen),
            'berkas_spt' => Storage::path('public/files/' . $notulen->berkas_spt),
            'berkas_dokumentasi' => Storage::path('public/photos/' . $notulen->berkas_dokumentasi)
        ];
    
        Log::info('Files: ', $files);
    
        // Pastikan direktori penyimpanan ada
        $storagePath = storage_path('app/public/files');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0775, true);
        }
    
        // Konversi konten Quill menjadi PDF menggunakan dompdf
        $html = view('notulen.pdf', compact('notulen'))->render();
        $dompdf = DomPDF::loadHTML($html);
        $quillPdfPath = $storagePath . '/quill_notulen.pdf';
        $dompdf->save($quillPdfPath);
    
        // Gabungkan PDF yang dihasilkan dengan file lainnya menggunakan Fpdi
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($quillPdfPath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);
        }
    
        foreach ($files as $key => $file) {
            if (file_exists($file)) {
                Log::info("File exists: $file");
                if (mime_content_type($file) == 'application/pdf') {
                    $pageCount = $pdf->setSourceFile($file);
                    Log::info("Page count for $key: $pageCount");
                    for ($i = 1; $i <= $pageCount; $i++) {
                        $templateId = $pdf->importPage($i);
                        $pdf->AddPage();
                        $pdf->useTemplate($templateId, ['adjustPageSize' => true]); // Adjust page size
                    }
                } elseif (mime_content_type($file) == 'image/jpeg' || mime_content_type($file) == 'image/png') {
                    list($width, $height) = getimagesize($file);
                    $pageWidth = $pdf->GetPageWidth();
                    $pageHeight = $pdf->GetPageHeight();
                    $maxWidth = $pageWidth - 20; // 10 units margin on each side
                    $maxHeight = $pageHeight - 20; // 10 units margin on each side
    
                    // Calculate scaling
                    $widthScale = $maxWidth / $width;
                    $heightScale = $maxHeight / $height;
                    $scale = min($widthScale, $heightScale);
    
                    $newWidth = $width * $scale;
                    $newHeight = $height * $scale;
    
                    $pdf->AddPage();
                    $pdf->Image($file, 10, 10, $newWidth, $newHeight);
                }
            } else {
                Log::warning("File does not exist: $file");
            }
        }
    
        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="notulen.pdf"'
        ]);
    }
    
    
    public function generatePDF($id)
    {
        set_time_limit(120);
    
        $notulen = Notulen::with(['pic', 'penanggung_jawab', 'pencatat', 'user'])->findOrFail($id);
        $files = [
            'surat_undangan' => Storage::path('public/files/' . $notulen->surat_undangan),
            'berkas_absen' => Storage::path('public/files/' . $notulen->berkas_absen),
            'berkas_spt' => Storage::path('public/files/' . $notulen->berkas_spt),
            'berkas_dokumentasi' => Storage::path('public/photos/' . $notulen->berkas_dokumentasi)
        ];
    
        // Pastikan direktori penyimpanan ada
        $storagePath = storage_path('app/public/files');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0775, true);
        }
    
        // Konversi konten Quill menjadi PDF menggunakan dompdf
        $html = view('notulen.pdf', compact('notulen'))->render();
        $dompdf = DomPDF::loadHTML($html);
        $quillPdfPath = $storagePath . '/quill_notulen.pdf';
        $dompdf->save($quillPdfPath);
    
        // Gabungkan PDF yang dihasilkan dengan file lainnya menggunakan Fpdi
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($quillPdfPath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);
        }
    
        foreach ($files as $key => $file) {
            if (file_exists($file)) {
                if (mime_content_type($file) == 'application/pdf') {
                    $pageCount = $pdf->setSourceFile($file);
                    for ($i = 1; $i <= $pageCount; $i++) {
                        $templateId = $pdf->importPage($i);
                        $pdf->AddPage();
                        $pdf->useTemplate($templateId, ['adjustPageSize' => true]); // Adjust page size
                    }
                } elseif (mime_content_type($file) == 'image/jpeg' || mime_content_type($file) == 'image/png') {
                    list($width, $height) = getimagesize($file);
                    $pageWidth = $pdf->GetPageWidth();
                    $pageHeight = $pdf->GetPageHeight();
                    $maxWidth = $pageWidth - 20; // 10 units margin on each side
                    $maxHeight = $pageHeight - 20; // 10 units margin on each side
    
                    // Calculate scaling
                    $widthScale = $maxWidth / $width;
                    $heightScale = $maxHeight / $height;
                    $scale = min($widthScale, $heightScale);
    
                    $newWidth = $width * $scale;
                    $newHeight = $height * $scale;
    
                    $pdf->AddPage();
                    $pdf->Image($file, 10, 10, $newWidth, $newHeight);
                }
            }
        }
    
        return response($pdf->Output('notulen.pdf', 'I'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="notulen.pdf"',
        ]);
    }

    public function destroy($id)
    {
        $notulen = Notulen::findOrFail($id);

        // Delete related files
        if ($notulen->surat_undangan) {
            Storage::delete('public/files/' . $notulen->surat_undangan);
        }
        if ($notulen->berkas_absen) {
            Storage::delete('public/files/' . $notulen->berkas_absen);
        }
        if ($notulen->berkas_spt) {
            Storage::delete('public/files/' . $notulen->berkas_spt);
        }
        if ($notulen->berkas_dokumentasi) {
            Storage::delete('public/photos/' . $notulen->berkas_dokumentasi);
        }

        // Delete notulen record
        $notulen->delete();

        return redirect()->route('notulen.index')->with('success', 'Notulen deleted successfully');
    }

    public function apiIndex()
    {
        $notulen = Notulen::with(['pic', 'penanggung_jawab', 'pencatat', 'user'])->get();
        return response()->json([
            'message' => 'Success',
            'notulen' => $notulen->map(function ($item) {
                return [
                    'notulen_id' => $item->notulen_id,
                    'text' => $item->text,
                    'jenis_surat' => $item->jenis_surat,
                    'nomor_surat' => $item->nomor_surat,
                    'surat_undangan' => $item->surat_undangan,
                    'berkas_absen' => $item->berkas_absen,
                    'berkas_spt' => $item->berkas_spt,
                    'berkas_dokumentasi' => $item->berkas_dokumentasi,
                    'pic' => $item->pic ? $item->pic->nama_pegawai : null,
                    'penanggung_jawab' => $item->penanggung_jawab ? $item->penanggung_jawab->nama_pegawai : null,
                    'pencatat' => $item->pencatat ? $item->pencatat->nama_pegawai : null,                
                ];
            })
        ]);
    }
    public function apiShow($id)
    {
        try {
            $notulen = Notulen::with(['pic', 'penanggung_jawab', 'pencatat', 'user'])->findOrFail($id);
            return response()->json([
                'message' => 'Success',
                'notulen' => [
                    'notulen_id' => $notulen->notulen_id,
                    'text' => $notulen->text,
                    'jenis_surat' => $notulen->jenis_surat,
                    'nomor_surat' => $notulen->nomor_surat,
                    'surat_undangan' => $notulen->surat_undangan,
                    'berkas_absen' => $notulen->berkas_absen,
                    'berkas_spt' => $notulen->berkas_spt,
                    'berkas_dokumentasi' => $notulen->berkas_dokumentasi,
                    'pic' => $notulen->pic ? $notulen->pic->nama_pegawai : null,
                    'penanggung_jawab' => $notulen->penanggung_jawab ? $notulen->penanggung_jawab->nama_pegawai : null,
                    'pencatat' => $notulen->pencatat ? $notulen->pencatat->nama_pegawai : null,
                ]
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }
    }

    public function apiDownloadPDF($id) {
        set_time_limit(120);
    
        try {
            $notulen = Notulen::with(['pic', 'penanggung_jawab', 'pencatat', 'user'])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Notulen not found'], 404);
        }
    
        $files = [
            'surat_undangan' => Storage::path('public/files/' . $notulen->surat_undangan),
            'berkas_absen' => Storage::path('public/files/' . $notulen->berkas_absen),
            'berkas_spt' => Storage::path('public/files/' . $notulen->berkas_spt),
            'berkas_dokumentasi' => Storage::path('public/photos/' . $notulen->berkas_dokumentasi)
        ];
    
        $storagePath = storage_path('app/public/files');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0775, true);
        }
    
        $html = view('notulen.pdf', compact('notulen'))->render();
        $dompdf = DomPDF::loadHTML($html);
        $dompdf->render();
        $quillPdfPath = $storagePath . '/quill_notulen.pdf';
        file_put_contents($quillPdfPath, $dompdf->output());
    
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($quillPdfPath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);
        }
    
        foreach ($files as $file) {
            if (file_exists($file)) {
                if (mime_content_type($file) == 'application/pdf') {
                    $pageCount = $pdf->setSourceFile($file);
                    for ($i = 1; $i <= $pageCount; $i++) {
                        $templateId = $pdf->importPage($i);
                        $pdf->AddPage();
                        $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                    }
                } elseif (mime_content_type($file) == 'image/jpeg' || mime_content_type($file) == 'image/png') {
                    list($width, $height) = getimagesize($file);
                    $pageWidth = $pdf->GetPageWidth();
                    $pageHeight = $pdf->GetPageHeight();
                    $maxWidth = $pageWidth - 20;
                    $maxHeight = $pageHeight - 20;
    
                    $widthScale = $maxWidth / $width;
                    $heightScale = $maxHeight / $height;
                    $scale = min($widthScale, $heightScale);
    
                    $newWidth = $width * $scale;
                    $newHeight = $height * $scale;
    
                    $pdf->AddPage();
                    $pdf->Image($file, 10, 10, $newWidth, $newHeight);
                }
            }
        }
    
        return response($pdf->Output('notulen.pdf', 'I'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="notulen.pdf"',
        ]);
    }

    public function apiGeneratePDF($id, $format)
    {
        set_time_limit(120);

        try {
            $notulen = Notulen::with(['pic', 'penanggung_jawab', 'pencatat', 'user'])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Notulen not found'], 404);
        }       
        
        $files = [
            'surat_undangan' => Storage::path('public/files/' . $notulen->surat_undangan),
            'berkas_absen' => Storage::path('public/files/' . $notulen->berkas_absen),
            'berkas_spt' => Storage::path('public/files/' . $notulen->berkas_spt),
            'berkas_dokumentasi' => Storage::path('public/photos/' . $notulen->berkas_dokumentasi)
        ];

        // Ensure the storage directory exists
        $storagePath = storage_path('app/public/files');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0775, true);
        }

        // Convert Quill content to PDF using dompdf
        $html = view('notulen.pdf', compact('notulen'))->render();
        $dompdf = DomPDF::loadHTML($html);
        $quillPdfPath = $storagePath . '/quill_notulen.pdf';
        $dompdf->save($quillPdfPath);

        // Merge the generated PDF with other files using Fpdi
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($quillPdfPath);
        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);
        }

        foreach ($files as $key => $file) {
            if (file_exists($file)) {
                if (mime_content_type($file) == 'application/pdf') {
                    $pageCount = $pdf->setSourceFile($file);
                    for ($i = 1; $i <= $pageCount; $i++) {
                        $templateId = $pdf->importPage($i);
                        $pdf->AddPage();
                        $pdf->useTemplate($templateId, ['adjustPageSize' => true]); // Adjust page size
                    }
                } elseif (mime_content_type($file) == 'image/jpeg' || mime_content_type($file) == 'image/png') {
                    list($width, $height) = getimagesize($file);
                    $pageWidth = $pdf->GetPageWidth();
                    $pageHeight = $pdf->GetPageHeight();
                    $maxWidth = $pageWidth - 20; // 10 units margin on each side
                    $maxHeight = $pageHeight - 20; // 10 units margin on each side

                    // Calculate scaling
                    $widthScale = $maxWidth / $width;
                    $heightScale = $maxHeight / $height;
                    $scale = min($widthScale, $heightScale);

                    $newWidth = $width * $scale;
                    $newHeight = $height * $scale;

                    $pdf->AddPage();
                    $pdf->Image($file, 10, 10, $newWidth, $newHeight);
                }
            }
        }

        return response($pdf->Output('notulen.pdf', 'I'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="notulen.pdf"',
        ]);
    }
}