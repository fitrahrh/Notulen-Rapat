<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use Illuminate\Http\Request;
use Exception;

class BidangController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $bidang = bidang::all();
        return view('bidang.index', compact('bidang'));
    }

    public function create()
    {
        return view('bidang.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $validated = $request->validate([
            'name_bidang' => 'required|unique:bidang,name_bidang',
        ]);

        bidang::create($validated);

        return redirect()->route('bidang.index')->with('success', 'bidang created successfully');
    }

    public function edit($id)
    {
        $bidang = bidang::findOrFail($id);
        return view('bidang.edit', compact('bidang'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $bidang = bidang::findOrFail($id);

        $validated = $request->validate([
            'name_bidang' => 'required|unique:bidang,name_bidang,' . $bidang->bidang_id . ',bidang_id',
        ]);

        $bidang->update($validated);

        return redirect()->route('bidang.index')->with('success', 'bidang updated successfully');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            $bidang = Bidang::findOrFail($id);
            $bidang->delete();
            return redirect()->route('bidang.index')->with('success', 'Bidang deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('bidang.index')->with('error', $e->getMessage());
        }
    }
}