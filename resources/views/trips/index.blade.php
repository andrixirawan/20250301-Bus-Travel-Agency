<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Daftar Perjalanan</h2>
            <a href="{{ route('trips.create') }}"
              class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
              Tambah Perjalanan
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
                          Bus
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Rute
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Keberangkatan
                        </th>
                        <th scope="col"
                          class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Kedatangan
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
                      @foreach ($trips as $trip)
                        <tr>
                          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            {{ $trip->bus->name }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ $trip->route->fromCity->name }} - {{ $trip->route->toCity->name }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ $trip->departure_time->format('d/m/Y H:i') }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            {{ $trip->arrival_time->format('d/m/Y H:i') }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                            @switch($trip->status)
                              @case('scheduled')
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                  Terjadwal
                                </span>
                              @break

                              @case('departed')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                  Berangkat
                                </span>
                              @break

                              @case('arrived')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                  Sampai
                                </span>
                              @break

                              @case('cancelled')
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                  Batal
                                </span>
                              @break
                            @endswitch
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('trips.edit', $trip) }}"
                              class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="inline-block ml-2"
                              onsubmit="return confirmDelete(event)">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="text-red-600 hover:text-red-900">
                                Hapus
                              </button>
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
            {{ $trips->links() }}
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

      // Confirm delete
      function confirmDelete(event) {
        event.preventDefault();
        const form = event.target;

        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data perjalanan akan dihapus permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
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
