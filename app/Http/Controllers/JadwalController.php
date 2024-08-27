<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Jenisrapat;
use App\Models\Kegiatan;
use App\Models\Dpa;
use App\Models\Uraian;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Notulen;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;


class JadwalController extends Controller
{       
    // WEB Methods
    public function index()
    {
        // Dapatkan user yang sedang login
        $user = auth()->user();
    
        if (in_array($user->role, ['user', 'admin'])) {
            $jadwal = Jadwal::all();
        } else {
            // Dapatkan pegawai yang terkait dengan user yang sedang login
            $pegawai = $user->pegawai;
    
            // Dapatkan bidang yang terkait dengan pegawai
            $bidang = $pegawai->bidang;
    
            // Dapatkan jadwal yang terkait dengan bidang tersebut
            $jadwal = Jadwal::whereHas('dpa', function ($query) use ($bidang) {
                $query->where('bidang_id', $bidang->bidang_id);
            })->get();
        }
    
        $kegiatan = Kegiatan::all();
        $dpa = Dpa::all();
        $uraian = Uraian::all();
        $jenis = Jenisrapat::all();

        // Pastikan $pegawai didefinisikan sebelum digunakan dalam compact
        if (!isset($pegawai)) {
            $pegawai = Pegawai::with('bidang')->get();
        }
    
        return view('jadwal-rapat.index', compact('jadwal', 'kegiatan', 'dpa', 'uraian', 'jenis', 'pegawai'));
    }

    public function create()
    {
        $kegiatan = Kegiatan::all();
        $dpa = Dpa::all();
        $uraian = Uraian::all();
        $jenis = Jenisrapat::all();
        $pegawai = Pegawai::with('bidang')->get();
        return view('jadwal-rapat.create', compact('kegiatan', 'dpa', 'uraian', 'jenis', 'pegawai'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name_rapat' => 'required',
        'jenis_rapat_id' => 'required|exists:jenis_rapat,jenis_rapat_id',
        'tanggal' => 'required|date',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i',
        'tempat_rapat' => 'required',
        'keterangan' => 'nullable',
        'uraian_id' => 'required|exists:uraian,uraian_id',
    ]);

    try {
        $uraian = Uraian::findOrFail($request->uraian_id);
        $kegiatan = $uraian->kegiatan;
        $dpa = $kegiatan->dpa;

        $jadwal = new Jadwal([
            'name_rapat' => $request->name_rapat,
            'jenis_rapat_id' => $request->jenis_rapat_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tempat_rapat' => $request->tempat_rapat,
            'keterangan' => $request->keterangan,
            'uraian_id' => $request->uraian_id,
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'dpa_id' => $dpa->dpa_id,
        ]);

        // Debugging
        \Log::info('Jadwal data:', $jadwal->toArray());

        $jadwal->save();

        return redirect()->route('jadwal-rapat.index')->with('success', 'Jadwal rapat berhasil disimpan.');
    } catch (Exception $e) {
        \Log::error('Error saving jadwal:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan jadwal rapat.']);
    }
}


    public function show(Jadwal $jadwal)
    {
        return view('jadwal-rapat.show', compact('jadwal'));
    }

    public function destroy($id)
    {
        try{
            $jadwal = Jadwal::findOrFail($id);

            $relatedRecordsCount = Notulen::where('jadwal_id', $id)->count();

            if ($relatedRecordsCount > 0) {
                return redirect()->route('jadwal-rapat.index')->with('error', 'Cannot delete jadwal because it has related notulen records.');
            }

            $jadwal->delete();
            return redirect()->route('jadwal-rapat.index')->with('success', 'Jadwal deleted successfully');            
        } catch (ModelNotFoundException $e) {
            return redirect()->route('jadwal-rapat.index')->with('error', 'Jadwal not found');
        }
    }
    
    public function edit($id)
{
    $jadwal = Jadwal::findOrFail($id);
    $kegiatan = Kegiatan::all();
    $dpa = Dpa::all();
    $uraian = Uraian::all();
    $jenisRapat = Jenisrapat::all(); // Tambahkan ini jika Anda memerlukan jenis rapat
    return view('jadwal-rapat.edit', compact('jadwal', 'kegiatan', 'dpa', 'uraian', 'jenisRapat'));
}

public function update(Request $request, $id)
{
    $jadwal = Jadwal::findOrFail($id);
    \Log::info('Request data:', $request->all());

    try {
        $request->merge([
            'jam_mulai' => \Carbon\Carbon::parse($request->jam_mulai)->format('H:i'),
            'jam_selesai' => \Carbon\Carbon::parse($request->jam_selesai)->format('H:i'),
        ]);

        $validated = $request->validate([
            'name_rapat' => 'required',
            'jenis_rapat_id' => 'required|exists:jenis_rapat,jenis_rapat_id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'tempat_rapat' => 'required',
            'keterangan' => 'nullable',
            'uraian_id' => 'required|exists:uraian,uraian_id',
        ]);

        \Log::info('Validated data:', $validated);

        $uraian = Uraian::findOrFail($request->uraian_id);
        $kegiatan = $uraian->kegiatan;
        $dpa = $kegiatan->dpa;

        \Log::info('Related data:', [
            'uraian' => $uraian,
            'kegiatan' => $kegiatan,
            'dpa' => $dpa,
        ]);

        $jadwal->update([
            'name_rapat' => $request->name_rapat,
            'jenis_rapat_id' => $request->jenis_rapat_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tempat_rapat' => $request->tempat_rapat,
            'keterangan' => $request->keterangan,
            'uraian_id' => $request->uraian_id,
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'dpa_id' => $dpa->dpa_id,
        ]);

        \Log::info('Jadwal updated successfully');

        return redirect()->route('jadwal-rapat.index')->with('success', 'Jadwal updated successfully');
    } catch (Exception $e) {
        \Log::error('Error updating jadwal:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate jadwal rapat.']);
    }
}

public function editrolan(Request $request, $id)
{
    if (auth()->user()->verifikator !== 'rolan') {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $jadwal = Jadwal::findOrFail($id);

    $request->validate([
        'mbis' => 'nullable|int',
        'rolan' => 'nullable|in:Sudah diambil,belum diambil',
        'verifikasi' => 'nullable|in:Belum,Sudah',
    ]);

    $jadwal->update([
        'mbis' => $request->mbis,
        'rolan' => $request->rolan,
        'verifikasi' => $request->verifikasi,
    ]);

    return redirect()->route('jadwal-rapat.index')->with('success', 'Jadwal updated successfully');
}

    public function getJadwal()
    {
        $jadwal = Jadwal::all();
    
        $events = $jadwal->map(function($jadwal) {
            return [
                'title' => $jadwal->name_rapat,
                'start' => $jadwal->tanggal . 'T' . $jadwal->jam_mulai,
                'end' => $jadwal->tanggal . 'T' . $jadwal->jam_selesai,
                'allDay' => false,
            ];
        });
    
        return response()->json($events);
    }
    
    // API Methods
    // DIBAWAH INI ADALAH FUNCTION UNTUK API


    // API ALL JADWAL

    public function apiIndex(Request $request)
    {
        // Dapatkan user yang sedang login
        $user = auth()->user();

        // Retrieve page and size from the request, set default values if not provided
        $page = $request->query('page', 1);
        $size = $request->query('size', 10);

        if (in_array($user->role, ['user', 'admin'])) {
            $jadwalQuery = Jadwal::query();
        } else {
            // Dapatkan pegawai yang terkait dengan user yang sedang login
            $pegawai = $user->pegawai;

            // Dapatkan bidang yang terkait dengan pegawai
            $bidang = $pegawai->bidang;

            // Dapatkan jadwal yang terkait dengan bidang tersebut
            $jadwalQuery = Jadwal::whereHas('dpa', function ($query) use ($bidang) {
                $query->where('bidang_id', $bidang->bidang_id);
            });
        }

        // Paginate the results
        $jadwal = $jadwalQuery->paginate($size, ['*'], 'page', $page);

        if ($jadwal->isEmpty()) {
            return response()->json([
                'message' => 'No data found'
            ], 404);
        }

        return response()->json([
            'message' => 'Success',
            'jadwal' => $jadwal->map(function ($item) {
                return [
                    'id' => $item->jadwal_id,
                    'name_rapat' => $item->name_rapat,
                    'jenis_rapat' => $item->jenis_rapat,
                    'tanggal' => $item->tanggal,
                    'jam_mulai' => $item->jam_mulai,
                    'jam_selesai' => $item->jam_selesai,
                    'tempat_rapat' => $item->tempat_rapat,
                    'mbis' => $item->mbis,
                    'rolan' => $item->rolan,
                    'verifikasi' => $item->verifikasi,
                    'keterangan' => $item->keterangan,
                    'dpa' => $item->dpa ? $item->dpa->name_dpa : null,
                    'kegiatan' => $item->kegiatan ? $item->kegiatan->name_kegiatan : null,
                    'uraian' => $item->uraian ? $item->uraian->name_uraian : null,
                    'notulen_id' => $item->notulen_id,
                ];
            }),
            'pagination' => [
                'current_page' => $jadwal->currentPage(),
                'total_pages' => $jadwal->lastPage(),
                'total_items' => $jadwal->total(),
                'items_per_page' => $jadwal->perPage(),
            ]
        ], 200);
    }

    // API SEARCH JADWAL
    public function searchJadwal(Request $request)
    {
        try {
    
            // Dapatkan user yang sedang login
            $user = auth()->user();
    
            // Dapatkan parameter pencarian dari request
            $searchName = $request->query('name_rapat');
            $searchDate = $request->query('tanggal');
            $searchType = $request->query('jenis_rapat');
    
            // Dapatkan parameter pagination dari request
            $page = $request->query('page', 1);
            $size = $request->query('size', 10);
    
            // Buat query dasar berdasarkan peran user
            if (in_array($user->role, ['user', 'admin'])) {
                $jadwalQuery = Jadwal::query();
            } else {
                // Dapatkan pegawai yang terkait dengan user yang sedang login
                $pegawai = $user->pegawai;
    
                // Dapatkan bidang yang terkait dengan pegawai
                $bidang = $pegawai->bidang;
    
                // Dapatkan jadwal yang terkait dengan bidang tersebut
                $jadwalQuery = Jadwal::whereHas('dpa', function ($query) use ($bidang) {
                    $query->where('bidang_id', $bidang->bidang_id);
                });
            }
    
            // Terapkan filter pencarian
            if (!empty($searchName)) {
                $jadwalQuery->where('name_rapat', 'LIKE', "%{$searchName}%");
            }
            if (!empty($searchDate)) {
                $jadwalQuery->where('tanggal', $searchDate);
            }
            if (!empty($searchType)) {
                $jadwalQuery->where('jenis_rapat', 'LIKE', "%{$searchType}%");
            }
    
            // Paginate hasil query
            $jadwal = $jadwalQuery->paginate($size, ['*'], 'page', $page);
    
            if ($jadwal->isEmpty()) {
                return response()->json([
                    'message' => 'No data found'
                ], 404);
            }
    
            return response()->json([
                'message' => 'Success',
                'jadwal' => $jadwal->map(function ($item) {
                    return [
                        'id' => $item->jadwal_id,
                        'name_rapat' => $item->name_rapat,
                        'jenis_rapat' => $item->jenis_rapat,
                        'tanggal' => $item->tanggal,
                        'jam_mulai' => $item->jam_mulai,
                        'jam_selesai' => $item->jam_selesai,
                        'tempat_rapat' => $item->tempat_rapat,
                        'mbis' => $item->mbis,
                        'rolan' => $item->rolan,
                        'verifikasi' => $item->verifikasi,
                        'keterangan' => $item->keterangan,
                        'dpa' => $item->dpa ? $item->dpa->name_dpa : null,
                        'kegiatan' => $item->kegiatan ? $item->kegiatan->name_kegiatan : null,
                        'uraian' => $item->uraian ? $item->uraian->name_uraian : null,
                        'notulen_id' => $item->notulen_id,
                    ];
                }),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // API CREATE JADWAL

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'name_rapat' => 'required',
            'jenis_rapat' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'tempat_rapat' => 'required',
            'mbis' => 'required|int',
            'rolan' => 'required|in:Sudah diambil,Belum diambil',
            'verifikasi' => 'required|in:Belum,Sudah',
            'keterangan' => 'nullable',
            'dpa_id' => 'required|exists:dpa,dpa_id',
            'kegiatan_id' => 'required|exists:kegiatan,kegiatan_id',
            'uraian_id' => 'required|exists:uraian,uraian_id',
        ]);


        $jadwal = Jadwal::create($validated);

        return response()->json([
            'message' => 'Jadwal created successfully!',
            'jadwal' => $jadwal
        ], 201);
    }

    // API SHOW JADWAL BY ID

    public function apiShow($id)
    {
        $jadwal = Jadwal::with('dpa')->findOrFail($id);
        return response()->json([
            'message' => 'Success',
            'jadwal' => [
                'id' => $jadwal->jadwal_id,
                'name_rapat' => $jadwal->name_rapat,
                'jenis_rapat' => $jadwal->jenis_rapat,
                'tanggal' => $jadwal->tanggal,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'tempat_rapat' => $jadwal->tempat_rapat,
                'mbis' => $jadwal->mbis,
                'rolan' => $jadwal->rolan,
                'verifikasi' => $jadwal->verifikasi,
                'keterangan' => $jadwal->keterangan,
                'dpa' => $jadwal->dpa ? $jadwal->dpa->name_dpa : null,
                'kegiatan_id' => $jadwal->kegiatan_id,
                'uraian_id' => $jadwal->uraian_id
            ]
        ]);
    }

    // API DELETE JADWAL BY ID
    public function apiDestroy(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return response()->json([
            'message' => 'Jadwal deleted successfully!'
        ]);
    }


    // FUNCTION UNTUK AJAX
    public function getKegiatanByDpa(Request $request)
    {
        $dpa_id = $request->input('dpa_id');
        $kegiatans = Kegiatan::where('dpa_id', $dpa_id)->get();
        return response()->json($kegiatans);
    }

    public function getUraianByKegiatan($request)
    {
        $kegiatan_id = $request->input('kegiatan_id');
        $uraians = Uraian::where('kegiatan_id', $kegiatan_id)->get();
        return response()->json($uraians);
    }
}