<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h2 class="text-2xl font-semibold mb-6">Edit Bus</h2>

          <form action="{{ route('buses.update', $bus) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-medium mb-2">Nama Bus</label>
                <input type="text" id="name" name="name" value="{{ old('name', $bus->name) }}"
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('name') border-red-500 @enderror">
                @error('name')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="capacity" class="block text-sm font-medium mb-2">Kapasitas</label>
                <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $bus->capacity) }}"
                  class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('capacity') border-red-500 @enderror">
                @error('capacity')
                  <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div class="flex justify-end gap-x-2">
                <a href="{{ route('buses.index') }}"
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
