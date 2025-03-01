<x-app-layout>
  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <!-- Header -->
          <div class="text-center mb-8">
            <h2 class="text-2xl font-bold">Detail Transaksi</h2>
            <p class="text-gray-600">No. Transaksi: #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
            <p class="text-gray-600">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
          </div>

          <!-- Status Badges -->
          <div class="flex justify-center gap-4 mb-8">
            <span @class([
                'px-3 py-1 text-sm font-medium rounded-full',
                'bg-yellow-100 text-yellow-800' =>
                    $transaction->payment_status === 'pending',
                'bg-green-100 text-green-800' => $transaction->payment_status === 'paid',
                'bg-gray-100 text-gray-800' => $transaction->payment_status === 'expired',
                'bg-red-100 text-red-800' => $transaction->payment_status === 'failed',
                'bg-blue-100 text-blue-800' => $transaction->payment_status === 'refunded',
            ])>
              {{ $transaction->payment_status->label() }}
            </span>
            <span @class([
                'px-3 py-1 text-sm font-medium rounded-full',
                'bg-yellow-100 text-yellow-800' =>
                    $transaction->transaction_status === 'pending',
                'bg-blue-100 text-blue-800' =>
                    $transaction->transaction_status === 'confirmed',
                'bg-green-100 text-green-800' =>
                    $transaction->transaction_status === 'completed',
                'bg-red-100 text-red-800' =>
                    $transaction->transaction_status === 'cancelled',
            ])>
              {{ $transaction->transaction_status->label() }}
            </span>
          </div>

          <!-- Customer Info -->
          <div class="border-t border-gray-200 pt-4 mb-6">
            <h3 class="text-lg font-semibold mb-3">Informasi Pelanggan</h3>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <p class="text-sm text-gray-600">Nama</p>
                <p class="font-medium">{{ $transaction->customer_name }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-600">Kontak</p>
                <p class="font-medium">{{ $transaction->customer_contact }}</p>
              </div>
            </div>
          </div>

          <!-- Trip Info -->
          <div class="border-t border-gray-200 pt-4 mb-6">
            <h3 class="text-lg font-semibold mb-3">Informasi Perjalanan</h3>
            <div class="space-y-2">
              <div class="flex justify-between">
                <div>
                  <p class="text-sm text-gray-600">Rute</p>
                  <p class="font-medium">
                    {{ $transaction->trip->route->fromCity->name }} -
                    {{ $transaction->trip->route->toCity->name }}
                  </p>
                </div>
                <div class="text-right">
                  <p class="text-sm text-gray-600">Bus</p>
                  <p class="font-medium">{{ $transaction->trip->bus->name }}</p>
                </div>
              </div>
              <div class="flex justify-between">
                <div>
                  <p class="text-sm text-gray-600">Keberangkatan</p>
                  <p class="font-medium">{{ $transaction->trip->departure_time->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-right">
                  <p class="text-sm text-gray-600">Kedatangan</p>
                  <p class="font-medium">{{ $transaction->trip->arrival_time->format('d/m/Y H:i') }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Price Info -->
          <div class="border-t border-gray-200 pt-4 mb-6">
            <h3 class="text-lg font-semibold mb-3">Rincian Pembayaran</h3>
            <div class="space-y-2">
              <div class="flex justify-between">
                <p class="text-gray-600">Harga Tiket</p>
                <p>Rp {{ number_format($transaction->trip->route->price, 0, ',', '.') }}</p>
              </div>
              <div class="flex justify-between">
                <p class="text-gray-600">Jumlah Tiket</p>
                <p>{{ $transaction->quantity }}</p>
              </div>
              <div class="flex justify-between font-semibold text-lg pt-2 border-t">
                <p>Total</p>
                <p>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
              </div>
            </div>
          </div>

          <!-- Notes -->
          @if ($transaction->notes)
            <div class="border-t border-gray-200 pt-4 mb-6">
              <h3 class="text-lg font-semibold mb-2">Catatan</h3>
              <p class="text-gray-600">{{ $transaction->notes }}</p>
            </div>
          @endif

          <!-- Actions -->
          <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
            <a href="{{ route('transactions.index') }}"
              class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
              Kembali
            </a>
            <div class="flex gap-2">
              <a href="{{ route('transactions.edit', $transaction) }}"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                Edit
              </a>
              @if ($transaction->transaction_status !== 'cancelled')
                <form action="{{ route('transactions.cancel', $transaction) }}" method="POST" class="inline-block"
                  onsubmit="return confirmCancel(event)">
                  @csrf
                  @method('PATCH')
                  <button type="submit"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                    Batalkan
                  </button>
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      function confirmCancel(event) {
        event.preventDefault();
        const form = event.target;

        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Transaksi akan dibatalkan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, batalkan!',
          cancelButtonText: 'Tidak'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });

        return false;
      }
    </script>
  @endpush
</x-app-layout>
