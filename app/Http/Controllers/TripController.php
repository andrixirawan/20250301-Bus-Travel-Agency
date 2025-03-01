<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::with(['bus', 'route.fromCity', 'route.toCity'])
            ->latest()
            ->paginate(10);
            
        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buses = Bus::orderBy('name')->get();
        $routes = Route::with(['fromCity', 'toCity'])->get();
        
        return view('trips.create', compact('buses', 'routes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => ['required', 'exists:buses,id'],
            'route_id' => ['required', 'exists:routes,id'],
            'departure_time' => ['required', 'date'],
            'arrival_time' => ['required', 'date', 'after:departure_time'],
            'status' => ['required', 'in:scheduled,departed,arrived,cancelled']
        ], [
            'bus_id.required' => 'Bus harus dipilih',
            'bus_id.exists' => 'Bus tidak valid',
            'route_id.required' => 'Rute harus dipilih',
            'route_id.exists' => 'Rute tidak valid',
            'departure_time.required' => 'Waktu keberangkatan harus diisi',
            'departure_time.date' => 'Format waktu keberangkatan tidak valid',
            'arrival_time.required' => 'Waktu kedatangan harus diisi',
            'arrival_time.date' => 'Format waktu kedatangan tidak valid',
            'arrival_time.after' => 'Waktu kedatangan harus setelah waktu keberangkatan',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            DB::beginTransaction();
            
            // Set default status jika tidak diisi
            $validated['status'] = $validated['status'] ?? 'scheduled';
            
            Trip::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('trips.index')
                ->with('success', 'Perjalanan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            \Log::error('Error creating trip: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data perjalanan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {
        $buses = Bus::orderBy('name')->get();
        $routes = Route::with(['fromCity', 'toCity'])->get();
        
        return view('trips.edit', compact('trip', 'buses', 'routes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'bus_id' => ['required', 'exists:buses,id'],
            'route_id' => ['required', 'exists:routes,id'],
            'departure_time' => ['required', 'date'],
            'arrival_time' => ['required', 'date', 'after:departure_time'],
            'status' => ['required', 'in:scheduled,departed,arrived,cancelled']
        ], [
            'bus_id.required' => 'Bus harus dipilih',
            'bus_id.exists' => 'Bus tidak valid',
            'route_id.required' => 'Rute harus dipilih',
            'route_id.exists' => 'Rute tidak valid',
            'departure_time.required' => 'Waktu keberangkatan harus diisi',
            'departure_time.date' => 'Format waktu keberangkatan tidak valid',
            'arrival_time.required' => 'Waktu kedatangan harus diisi',
            'arrival_time.date' => 'Format waktu kedatangan tidak valid',
            'arrival_time.after' => 'Waktu kedatangan harus setelah waktu keberangkatan',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            DB::beginTransaction();
            
            $trip->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('trips.index')
                ->with('success', 'Perjalanan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data perjalanan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        try {
            DB::beginTransaction();
            
            $trip->delete();
            
            DB::commit();
            
            return redirect()
                ->route('trips.index')
                ->with('success', 'Perjalanan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data perjalanan');
        }
    }
}
