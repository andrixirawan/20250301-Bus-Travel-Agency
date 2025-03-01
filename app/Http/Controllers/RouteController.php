<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::with(['fromCity', 'toCity'])->latest()->paginate(10);
        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::orderBy('name')->get();
        return view('routes.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_city_id' => ['required', 'exists:cities,id', 'different:to_city_id'],
            'to_city_id' => ['required', 'exists:cities,id', 'different:from_city_id'],
            // 'distance' => ['required', 'numeric', 'min:1'],
            // 'duration' => ['required', 'numeric', 'min:1'],
            'price' => ['required', 'numeric', 'min:1000']
        ], [
            'from_city_id.required' => 'Kota asal harus dipilih',
            'from_city_id.exists' => 'Kota asal tidak valid',
            'from_city_id.different' => 'Kota asal dan tujuan tidak boleh sama',
            'to_city_id.required' => 'Kota tujuan harus dipilih',
            'to_city_id.exists' => 'Kota tujuan tidak valid',
            'to_city_id.different' => 'Kota tujuan dan asal tidak boleh sama',
            // 'distance.required' => 'Jarak harus diisi',
            // 'distance.numeric' => 'Jarak harus berupa angka',
            // 'distance.min' => 'Jarak minimal 1 km',
            // 'duration.required' => 'Durasi harus diisi',
            // 'duration.numeric' => 'Durasi harus berupa angka',
            // 'duration.min' => 'Durasi minimal 1 jam',
            'price.required' => 'Harga harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal Rp 1.000'
        ]);

        try {
            DB::beginTransaction();
            
            Route::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('routes.index')
                ->with('success', 'Rute berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data rute');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        $cities = City::orderBy('name')->get();
        return view('routes.edit', compact('route', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'from_city_id' => ['required', 'exists:cities,id', 'different:to_city_id'],
            'to_city_id' => ['required', 'exists:cities,id', 'different:from_city_id'],
            // 'distance' => ['required', 'numeric', 'min:1'],
            // 'duration' => ['required', 'numeric', 'min:1'],
            'price' => ['required', 'numeric', 'min:1000']
        ], [
            'from_city_id.required' => 'Kota asal harus dipilih',
            'from_city_id.exists' => 'Kota asal tidak valid',
            'from_city_id.different' => 'Kota asal dan tujuan tidak boleh sama',
            'to_city_id.required' => 'Kota tujuan harus dipilih',
            'to_city_id.exists' => 'Kota tujuan tidak valid',
            'to_city_id.different' => 'Kota tujuan dan asal tidak boleh sama',
            // 'distance.required' => 'Jarak harus diisi',
            // 'distance.numeric' => 'Jarak harus berupa angka',
            // 'distance.min' => 'Jarak minimal 1 km',
            // 'duration.required' => 'Durasi harus diisi',
            // 'duration.numeric' => 'Durasi harus berupa angka',
            // 'duration.min' => 'Durasi minimal 1 jam',
            'price.required' => 'Harga harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal Rp 1.000'
        ]);

        try {
            DB::beginTransaction();
            
            $route->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('routes.index')
                ->with('success', 'Rute berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data rute');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        try {
            DB::beginTransaction();
            
            $route->delete();
            
            DB::commit();
            
            return redirect()
                ->route('routes.index')
                ->with('success', 'Rute berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data rute');
        }
    }
}
