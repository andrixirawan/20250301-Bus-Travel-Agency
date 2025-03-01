<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h2 class="text-2xl font-semibold mb-6">Edit Transaksi</h2>

          <form action="{{ route('transactions.update', $transaction) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
              <div>
                <label for="trip_id" class="block text-sm font-medium mb-2">Perjalanan</label>
                <select id="trip_id" name="trip_id"
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('trip_id') border-red-500 @enderror">
                  <option value="">Pilih Perjalanan</option>
                  @foreach ($trips as $trip)
                    <option value="{{ $trip->id }}"
                      {{ old('trip_id', $transaction->trip_id) == $trip->id ? 'selected' : '' }}>
                      {{ $trip->route->fromCity->name }} - {{ $trip->route->toCity->name }}
                      ({{ $trip->departure_time->format('d/m/Y H:i') }})
                      - {{ $trip->bus->name }}
                      - Rp {{ number_format($trip->route->price, 0, ',', '.') }}
                    </option>
                  @endforeach
                </select>
                @error('trip_id')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="customer_name" class="block text-sm font-medium mb-2">Nama Pelanggan</label>
                  <input type="text" id="customer_name" name="customer_name"
                    value="{{ old('customer_name', $transaction->customer_name) }}"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('customer_name') border-red-500 @enderror">
                  @error('customer_name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="customer_contact" class="block text-sm font-medium mb-2">Kontak Pelanggan</label>
                  <input type="text" id="customer_contact" name="customer_contact"
                    value="{{ old('customer_contact', $transaction->customer_contact) }}"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('customer_contact') border-red-500 @enderror">
                  @error('customer_contact')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="quantity" class="block text-sm font-medium mb-2">Jumlah Tiket</label>
                  <input type="number" id="quantity" name="quantity"
                    value="{{ old('quantity', $transaction->quantity) }}" min="1"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('quantity') border-red-500 @enderror">
                  @error('quantity')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="payment_status" class="block text-sm font-medium mb-2">Status Pembayaran</label>
                  <select id="payment_status" name="payment_status"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('payment_status') border-red-500 @enderror">
                    @foreach (App\Enums\PaymentStatus::cases() as $status)
                      <option value="{{ $status->value }}"
                        {{ old('payment_status', $transaction->payment_status->value) === $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                      </option>
                    @endforeach
                  </select>
                  @error('payment_status')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div>
                <label for="transaction_status" class="block text-sm font-medium mb-2">Status Transaksi</label>
                <select id="transaction_status" name="transaction_status"
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('transaction_status') border-red-500 @enderror">
                  @foreach (App\Enums\TransactionStatus::cases() as $status)
                    <option value="{{ $status->value }}"
                      {{ old('transaction_status', $transaction->transaction_status->value) === $status->value ? 'selected' : '' }}>
                      {{ $status->label() }}
                    </option>
                  @endforeach
                </select>
                @error('transaction_status')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="notes" class="block text-sm font-medium mb-2">Catatan</label>
                <textarea id="notes" name="notes" rows="3"
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('notes') border-red-500 @enderror">{{ old('notes', $transaction->notes) }}</textarea>
                @error('notes')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div class="flex justify-end gap-x-2">
                <a href="{{ route('transactions.index') }}"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                  Batal
                </a>
                <button type="submit"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                  Simpan Perubahan
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
