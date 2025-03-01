<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h2 class="text-2xl font-semibold mb-6">Edit Kota</h2>

          <form action="{{ route('cities.update', $city) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-medium mb-2">Nama Kota</label>
                <input type="text" id="name" name="name" value="{{ old('name', $city->name) }}"
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('name') border-red-500 @enderror">
                @error('name')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-sm font-medium mb-2">Tempat Wisata</label>
                <div id="tourist-attractions" class="space-y-3">
                  @foreach ($city->tourist_attractions as $index => $attraction)
                    <div class="flex gap-x-2">
                      <input type="text" name="tourist_attractions[]"
                        value="{{ old("tourist_attractions.$index", $attraction) }}"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error("tourist_attractions.$index") border-red-500 @enderror"
                        placeholder="Masukkan nama tempat wisata">
                      @if ($loop->first)
                        <button type="button" onclick="addTouristAttraction()"
                          class="py-2 px-3 inline-flex flex-shrink-0 justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                          +
                        </button>
                      @else
                        <button type="button" onclick="this.parentElement.remove()"
                          class="py-2 px-3 inline-flex flex-shrink-0 justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                          ×
                        </button>
                      @endif
                    </div>
                  @endforeach
                </div>
                @error('tourist_attractions')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
                @error('tourist_attractions.*')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div class="flex justify-end gap-x-2">
                <a href="{{ route('cities.index') }}"
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

  @push('scripts')
    <script>
      function addTouristAttraction() {
        const container = document.getElementById('tourist-attractions');
        const div = document.createElement('div');
        div.className = 'flex gap-x-2';
        div.innerHTML = `
          <input type="text" name="tourist_attractions[]" 
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            placeholder="Masukkan nama tempat wisata">
          <button type="button" onclick="this.parentElement.remove()" 
            class="py-2 px-3 inline-flex flex-shrink-0 justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
            ×
          </button>
        `;
        container.appendChild(div);
      }
    </script>
  @endpush
</x-app-layout>
