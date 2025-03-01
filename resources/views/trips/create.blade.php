<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h2 class="text-2xl font-semibold mb-6">Tambah Perjalanan Baru</h2>

          <form action="{{ route('trips.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="bus_id" class="block text-sm font-medium mb-2">Bus</label>
                  <select id="bus_id" name="bus_id"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('bus_id') border-red-500 @enderror">
                    <option value="">Pilih Bus</option>
                    @foreach ($buses as $bus)
                      <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                        {{ $bus->name }} (Kapasitas: {{ $bus->capacity }})
                      </option>
                    @endforeach
                  </select>
                  @error('bus_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="route_id" class="block text-sm font-medium mb-2">Rute</label>
                  <select id="route_id" name="route_id"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('route_id') border-red-500 @enderror">
                    <option value="">Pilih Rute</option>
                    @foreach ($routes as $route)
                      <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                        {{ $route->fromCity->name }} - {{ $route->toCity->name }}
                        (Rp {{ number_format($route->price, 0, ',', '.') }})
                      </option>
                    @endforeach
                  </select>
                  @error('route_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="departure_time" class="block text-sm font-medium mb-2">Waktu Keberangkatan</label>
                  <input type="datetime-local" id="departure_time" name="departure_time"
                    value="{{ old('departure_time') }}"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('departure_time') border-red-500 @enderror">
                  @error('departure_time')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="arrival_time" class="block text-sm font-medium mb-2">Waktu Kedatangan</label>
                  <input type="datetime-local" id="arrival_time" name="arrival_time" value="{{ old('arrival_time') }}"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('arrival_time') border-red-500 @enderror">
                  @error('arrival_time')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div>
                <label for="status" class="block text-sm font-medium mb-2">Status</label>
                <select id="status" name="status"
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('status') border-red-500 @enderror">
                  <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Terjadwal
                  </option>
                  <option value="departed" {{ old('status') == 'departed' ? 'selected' : '' }}>Berangkat</option>
                  <option value="arrived" {{ old('status') == 'arrived' ? 'selected' : '' }}>Sampai</option>
                  <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Batal</option>
                </select>
                @error('status')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div class="flex justify-end gap-x-2">
                <a href="{{ route('trips.index') }}"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                  Batal
                </a>
                <button type="submit"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                  Simpan
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
