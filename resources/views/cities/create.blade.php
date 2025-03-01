<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h2 class="text-2xl font-semibold mb-6">Tambah Kota Baru</h2>

          <form action="{{ route('cities.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-medium mb-2">Nama Kota</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('name') border-red-500 @enderror">
                @error('name')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-sm font-medium mb-2">Tempat Wisata</label>
                <div id="tourist-attractions" class="space-y-3">
                  @foreach ($tourist_attractions as $index => $attraction)
                    <div class="flex gap-x-2">
                      <input type="text" name="tourist_attractions[]" value="{{ $attraction }}"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('tourist_attractions.' . $index) border-red-500 @enderror"
                        placeholder="Masukkan nama tempat wisata">
                      @if ($loop->first)
                        <button type="button" id="add-attraction"
                          class="py-2 px-3 inline-flex flex-shrink-0 justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                          +
                        </button>
                      @else
                        <button type="button" onclick="removeAttraction(this)"
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
                  Simpan
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
      document.addEventListener('DOMContentLoaded', function() {
        const addButton = document.getElementById('add-attraction');
        addButton.addEventListener('click', addTouristAttraction);
      });

      function addTouristAttraction() {
        const container = document.getElementById('tourist-attractions');
        const div = document.createElement('div');
        div.className = 'flex gap-x-2';

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'tourist_attractions[]';
        input.className =
          'py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none';
        input.placeholder = 'Masukkan nama tempat wisata';

        const button = document.createElement('button');
        button.type = 'button';
        button.className =
          'py-2 px-3 inline-flex flex-shrink-0 justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none';
        button.textContent = '×';
        button.onclick = function() {
          removeAttraction(this);
        };

        div.appendChild(input);
        div.appendChild(button);
        container.appendChild(div);
      }

      function removeAttraction(button) {
        button.parentElement.remove();
      }
    </script>
  @endpush
</x-app-layout>
