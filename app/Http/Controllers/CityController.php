<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::latest()->paginate(10);
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Inisialisasi array kosong untuk old input jika ada error
        $tourist_attractions = old('tourist_attractions', ['']);
        return view('cities.create', compact('tourist_attractions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tourist_attractions' => ['required', 'array', 'min:1'],
            'tourist_attractions.*' => ['required', 'string', 'max:255']
        ], [
            'name.required' => 'Nama kota harus diisi',
            'name.max' => 'Nama kota maksimal 255 karakter',
            'tourist_attractions.required' => 'Tempat wisata harus diisi',
            'tourist_attractions.array' => 'Format tempat wisata tidak valid',
            'tourist_attractions.min' => 'Minimal harus ada 1 tempat wisata',
            'tourist_attractions.*.required' => 'Nama tempat wisata harus diisi',
            'tourist_attractions.*.max' => 'Nama tempat wisata maksimal 255 karakter'
        ]);

        try {
            DB::beginTransaction();
            
            // Filter out empty tourist attractions
            $validated['tourist_attractions'] = array_filter($validated['tourist_attractions']);
            
            $city = City::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('cities.index')
                ->with('success', 'Kota berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data kota');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        // Gunakan old input jika ada error, jika tidak gunakan data dari database
        $tourist_attractions = old('tourist_attractions', $city->tourist_attractions);
        return view('cities.edit', compact('city', 'tourist_attractions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tourist_attractions' => ['required', 'array', 'min:1'],
            'tourist_attractions.*' => ['required', 'string', 'max:255']
        ], [
            'name.required' => 'Nama kota harus diisi',
            'name.max' => 'Nama kota maksimal 255 karakter',
            'tourist_attractions.required' => 'Tempat wisata harus diisi',
            'tourist_attractions.array' => 'Format tempat wisata tidak valid',
            'tourist_attractions.min' => 'Minimal harus ada 1 tempat wisata',
            'tourist_attractions.*.required' => 'Nama tempat wisata harus diisi',
            'tourist_attractions.*.max' => 'Nama tempat wisata maksimal 255 karakter'
        ]);

        try {
            DB::beginTransaction();
            
            // Filter out empty tourist attractions
            $validated['tourist_attractions'] = array_filter($validated['tourist_attractions']);
            
            $city->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('cities.index')
                ->with('success', 'Kota berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data kota');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        try {
            DB::beginTransaction();
            
            $city->delete();
            
            DB::commit();
            
            return redirect()
                ->route('cities.index')
                ->with('success', 'Kota berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data kota');
        }
    }
}
