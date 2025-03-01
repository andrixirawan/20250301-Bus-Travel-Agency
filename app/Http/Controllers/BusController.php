<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buses = Bus::latest()->paginate(10);
        return view('buses.index', compact('buses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1', 'max:100'],
        ], [
            'name.required' => 'Nama bus harus diisi',
            'name.max' => 'Nama bus maksimal 255 karakter',
            'capacity.required' => 'Kapasitas harus diisi',
            'capacity.integer' => 'Kapasitas harus berupa angka',
            'capacity.min' => 'Kapasitas minimal 1',
            'capacity.max' => 'Kapasitas maksimal 100',
        ]);

        try {
            DB::beginTransaction();
            
            $bus = Bus::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('buses.index')
                ->with('success', 'Bus berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data bus');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bus $bus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bus $bus)
    {
        return view('buses.edit', compact('bus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1', 'max:100'],
        ], [
            'name.required' => 'Nama bus harus diisi',
            'name.max' => 'Nama bus maksimal 255 karakter',
            'capacity.required' => 'Kapasitas harus diisi',
            'capacity.integer' => 'Kapasitas harus berupa angka',
            'capacity.min' => 'Kapasitas minimal 1',
            'capacity.max' => 'Kapasitas maksimal 100',
        ]);

        try {
            DB::beginTransaction();
            
            $bus->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('buses.index')
                ->with('success', 'Bus berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data bus');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bus $bus)
    {
        try {
            DB::beginTransaction();
            
            $bus->delete();
            
            DB::commit();
            
            return redirect()
                ->route('buses.index')
                ->with('success', 'Bus berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data bus');
        }
    }
}
