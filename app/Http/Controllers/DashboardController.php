<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Trip;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        return view('dashboard', [
            'totalBuses' => Bus::count(),
            'totalRoutes' => Route::count(),
            'todayTrips' => Trip::whereDate('departure_time', $today)->count(),
            'todayTransactions' => Transaction::whereDate('created_at', $today)->count(),
            'recentTransactions' => Transaction::with(['trip.route.fromCity', 'trip.route.toCity'])
                ->latest()
                ->take(5)
                ->get(),
            'todayTripsList' => Trip::with(['bus', 'route.fromCity', 'route.toCity'])
                ->whereDate('departure_time', $today)
                ->orderBy('departure_time')
                ->get()
        ]);
    }
} 