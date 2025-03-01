<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h2 class="text-2xl font-semibold mb-6">Edit Rute</h2>

          <form action="{{ route('routes.update', $route) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="from_city_id" class="block text-sm font-medium mb-2">Kota Asal</label>
                  <select id="from_city_id" name="from_city_id"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('from_city_id') border-red-500 @enderror">
                    <option value="">Pilih Kota Asal</option>
                    @foreach ($cities as $city)
                      <option value="{{ $city->id }}"
                        {{ old('from_city_id', $route->from_city_id) == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('from_city_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="to_city_id" class="block text-sm font-medium mb-2">Kota Tujuan</label>
                  <select id="to_city_id" name="to_city_id"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('to_city_id') border-red-500 @enderror">
                    <option value="">Pilih Kota Tujuan</option>
                    @foreach ($cities as $city)
                      <option value="{{ $city->id }}"
                        {{ old('to_city_id', $route->to_city_id) == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('to_city_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label for="distance" class="block text-sm font-medium mb-2">Jarak (km)</label>
                  <input type="number" id="distance" name="distance" value="{{ old('distance', $route->distance) }}"
                    min="1"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('distance') border-red-500 @enderror">
                  @error('distance')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="duration" class="block text-sm font-medium mb-2">Durasi (jam)</label>
                  <input type="number" id="duration" name="duration" value="{{ old('duration', $route->duration) }}"
                    min="1"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('duration') border-red-500 @enderror">
                  @error('duration')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <label for="price" class="block text-sm font-medium mb-2">Harga (Rp)</label>
                  <input type="number" id="price" name="price" value="{{ old('price', $route->price) }}"
                    min="1000"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('price') border-red-500 @enderror">
                  @error('price')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="flex justify-end gap-x-2">
                <a href="{{ route('routes.index') }}"
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
