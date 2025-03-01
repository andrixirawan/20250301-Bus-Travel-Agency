<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Daftar Transaksi</h2>
            <a href="{{ route('transactions.create') }}"
              class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
              Tambah Transaksi
            </a>
          </div>

          <!-- Table -->
          <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
              <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                      <tr>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Pelanggan
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Perjalanan
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Jumlah
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Total
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Status
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Aksi
                        </th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      @foreach ($transactions as $transaction)
                        <tr>
                          <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="font-medium text-gray-900">{{ $transaction->customer_name }}</div>
                            <div class="text-gray-500">{{ $transaction->customer_contact }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="font-medium text-gray-900">
                              {{ $transaction->trip->route->fromCity->name }} -
                              {{ $transaction->trip->route->toCity->name }}
                            </div>
                            <div class="text-gray-500">
                              {{ $transaction->trip->departure_time->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-gray-500">{{ $transaction->trip->bus->name }}</div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->quantity }} tiket
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex flex-col gap-1">
                              <span @class([
                                  'px-2 py-0.5 text-xs font-medium rounded',
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
                                  'px-2 py-0.5 text-xs font-medium rounded',
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
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('transactions.show', $transaction) }}"
                              class="text-blue-600 hover:text-blue-900 mr-2">Detail</a>
                            <a href="{{ route('transactions.edit', $transaction) }}"
                              class="text-blue-600 hover:text-blue-900">Edit</a>
                            @if ($transaction->transaction_status !== 'cancelled')
                              <form action="{{ route('transactions.cancel', $transaction) }}" method="POST"
                                class="inline-block ml-2" onsubmit="return confirmCancel(event)">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                  Batalkan
                                </button>
                              </form>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div class="mt-4">
            {{ $transactions->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Show SweetAlert for success message
        @if (session('success'))
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
          });
        @endif

        // Show SweetAlert for error message
        @if (session('error'))
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: true
          });
        @endif
      });

      // Confirm cancel
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
