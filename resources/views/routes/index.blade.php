<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Daftar Rute</h2>
            <a href="{{ route('routes.create') }}"
              class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
              Tambah Rute
            </a>
          </div>

          @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-sm text-green-800 rounded-lg p-4 mb-4" role="alert">
              {{ session('success') }}
            </div>
          @endif

          @if (session('error'))
            <div class="bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 mb-4" role="alert">
              {{ session('error') }}
            </div>
          @endif

          <!-- Search dan Filter -->
          <div class="mb-4 flex flex-wrap gap-4">
            <div class="flex-1">
              <label for="hs-table-search" class="sr-only">Search</label>
              <div class="relative">
                <input type="text" id="hs-table-search" name="hs-table-search"
                  class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                  placeholder="Cari rute...">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                  <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                  </svg>
                </div>
              </div>
            </div>

            <div class="flex items-center gap-2">
              <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                <button id="hs-dropdown-transform-origin" type="button"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                  <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M3 6h18" />
                    <path d="M7 12h10" />
                    <path d="M10 18h4" />
                  </svg>
                  Tampilkan
                </button>
                <div
                  class="hs-dropdown-menu hs-dropdown-menu-transform transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 w-48 hidden z-10 mt-2 min-w-[15rem] bg-white shadow-md rounded-lg p-2">
                  <div class="relative flex flex-col">
                    <select
                      class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                      <option value="10">10 Data</option>
                      <option value="25">25 Data</option>
                      <option value="50">50 Data</option>
                      <option value="100">100 Data</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Table -->
          <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
              <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                  <table id="routeTable" class="min-w-full divide-y divide-gray-200">
                    <thead>
                      <tr>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Kota Asal
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Kota Tujuan
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Jarak (km)
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Durasi (jam)
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Harga (Rp)
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Aksi
                        </th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      @foreach ($routes as $route)
                        <tr>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $route->fromCity->name }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ $route->toCity->name }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ number_format($route->distance, 0, ',', '.') }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ number_format($route->duration, 0, ',', '.') }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ number_format($route->price, 0, ',', '.') }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('routes.edit', $route) }}"
                              class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="{{ route('routes.destroy', $route) }}" method="POST"
                              class="inline-block ml-2">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus rute ini?')">Hapus</button>
                            </form>
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
            {{ $routes->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new HSDataTable('#routeTable');

        // Search functionality
        const searchInput = document.getElementById('hs-table-search');
        searchInput.addEventListener('input', function(e) {
          dataTable.search(this.value).draw();
        });

        // Jumlah data per halaman
        const perPageSelect = document.querySelector('.hs-dropdown-menu select');
        perPageSelect.addEventListener('change', function() {
          dataTable.page.len(this.value).draw();
        });
      });
    </script>
  @endpush
</x-app-layout>
