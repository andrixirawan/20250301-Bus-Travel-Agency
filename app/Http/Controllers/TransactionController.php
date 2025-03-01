<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Transaction;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['trip.bus', 'trip.route.fromCity', 'trip.route.toCity'])
            ->latest()
            ->paginate(10);
            
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trips = Trip::with(['bus', 'route.fromCity', 'route.toCity'])
            ->where('status', '!=', 'cancelled')
            ->get();
            
        return view('transactions.create', compact('trips'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => ['required', 'exists:trips,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_contact' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string']
        ], [
            'trip_id.required' => 'Perjalanan harus dipilih',
            'trip_id.exists' => 'Perjalanan tidak valid',
            'customer_name.required' => 'Nama pelanggan harus diisi',
            'customer_name.string' => 'Nama pelanggan harus berupa teks',
            'customer_name.max' => 'Nama pelanggan maksimal 255 karakter',
            'customer_contact.required' => 'Kontak pelanggan harus diisi',
            'customer_contact.string' => 'Kontak pelanggan harus berupa teks',
            'customer_contact.max' => 'Kontak pelanggan maksimal 255 karakter',
            'quantity.required' => 'Jumlah tiket harus diisi',
            'quantity.integer' => 'Jumlah tiket harus berupa angka',
            'quantity.min' => 'Jumlah tiket minimal 1',
            'notes.string' => 'Catatan harus berupa teks'
        ]);

        try {
            DB::beginTransaction();
            
            $trip = Trip::findOrFail($validated['trip_id']);
            
            // Hitung total harga
            $validated['total_price'] = $trip->route->price * $validated['quantity'];
            
            // Set status default menggunakan string value
            $validated['payment_status'] = PaymentStatus::PENDING->value;
            $validated['transaction_status'] = TransactionStatus::PENDING->value;
            
            // Log untuk debugging
            \Log::info('Validated data:', $validated);
            
            Transaction::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            \Log::error('Error creating transaction: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan transaksi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $trips = Trip::with(['bus', 'route.fromCity', 'route.toCity'])
            ->where('status', '!=', 'cancelled')
            ->get();
            
        return view('transactions.edit', compact('transaction', 'trips'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'trip_id' => ['required', 'exists:trips,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_contact' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'payment_status' => ['required', 'string', 'in:' . implode(',', array_column(PaymentStatus::cases(), 'value'))],
            'transaction_status' => ['required', 'string', 'in:' . implode(',', array_column(TransactionStatus::cases(), 'value'))],
            'notes' => ['nullable', 'string']
        ], [
            'trip_id.required' => 'Perjalanan harus dipilih',
            'trip_id.exists' => 'Perjalanan tidak valid',
            'customer_name.required' => 'Nama pelanggan harus diisi',
            'customer_name.string' => 'Nama pelanggan harus berupa teks',
            'customer_name.max' => 'Nama pelanggan maksimal 255 karakter',
            'customer_contact.required' => 'Kontak pelanggan harus diisi',
            'customer_contact.string' => 'Kontak pelanggan harus berupa teks',
            'customer_contact.max' => 'Kontak pelanggan maksimal 255 karakter',
            'quantity.required' => 'Jumlah tiket harus diisi',
            'quantity.integer' => 'Jumlah tiket harus berupa angka',
            'quantity.min' => 'Jumlah tiket minimal 1',
            'payment_status.required' => 'Status pembayaran harus dipilih',
            'payment_status.in' => 'Status pembayaran tidak valid',
            'transaction_status.required' => 'Status transaksi harus dipilih',
            'transaction_status.in' => 'Status transaksi tidak valid',
            'notes.string' => 'Catatan harus berupa teks'
        ]);

        try {
            DB::beginTransaction();
            
            $trip = Trip::findOrFail($validated['trip_id']);
            
            // Hitung total harga
            $validated['total_price'] = $trip->route->price * $validated['quantity'];
            
            $transaction->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui transaksi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function cancel(Transaction $transaction)
    {
        try {
            DB::beginTransaction();
            
            $transaction->update([
                'transaction_status' => TransactionStatus::CANCELLED
            ]);
            
            DB::commit();
            
            return redirect()
                ->route('transactions.index')
                ->with('success', 'Transaksi berhasil dibatalkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat membatalkan transaksi');
        }
    }
}
