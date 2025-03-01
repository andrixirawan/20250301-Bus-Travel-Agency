<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Stats -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="text-gray-500 text-sm mb-1">Total Bus</div>
            <div class="text-2xl font-bold">{{ $totalBuses }}</div>
          </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="text-gray-500 text-sm mb-1">Total Rute</div>
            <div class="text-2xl font-bold">{{ $totalRoutes }}</div>
          </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="text-gray-500 text-sm mb-1">Perjalanan Hari Ini</div>
            <div class="text-2xl font-bold">{{ $todayTrips }}</div>
          </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="text-gray-500 text-sm mb-1">Transaksi Hari Ini</div>
            <div class="text-2xl font-bold">{{ $todayTransactions }}</div>
          </div>
        </div>
      </div>

      <!-- Recent Transactions -->
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Transaksi Terbaru</h3>
            <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat
              Semua</a>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Pelanggan
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Rute
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Total
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach ($recentTransactions as $transaction)
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
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Today's Trips -->
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Perjalanan Hari Ini</h3>
            <a href="{{ route('trips.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Bus
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Rute
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Waktu
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach ($todayTripsList as $trip)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      <div class="font-medium text-gray-900">{{ $trip->bus->name }}</div>
                      <div class="text-gray-500">Kapasitas: {{ $trip->bus->capacity }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      <div class="font-medium text-gray-900">
                        {{ $trip->route->fromCity->name }} - {{ $trip->route->toCity->name }}
                      </div>
                      <div class="text-gray-500">
                        Rp {{ number_format($trip->route->price, 0, ',', '.') }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      <div class="font-medium text-gray-900">
                        {{ $trip->departure_time->format('H:i') }} -
                        {{ $trip->arrival_time->format('H:i') }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      <span @class([
                          'px-2 py-0.5 text-xs font-medium rounded',
                          'bg-yellow-100 text-yellow-800' => $trip->status === 'scheduled',
                          'bg-blue-100 text-blue-800' => $trip->status === 'departed',
                          'bg-green-100 text-green-800' => $trip->status === 'arrived',
                          'bg-red-100 text-red-800' => $trip->status === 'cancelled',
                      ])>
                        {{ ucfirst($trip->status) }}
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

