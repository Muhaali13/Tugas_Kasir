<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="gap-5 items-start flex">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-full p-4">
                    <div class="p-4 bg-gray-100 mb-2 rounded-xl font-bold">
                        <div class="flex items-center justify-between">
                            <div class="w-full">
                                PENJUALAN
                            </div>
                            {{-- BUTTON REDIRECT HALAMAN ADD PENJUALAN --}}
                            <div>
                                <a href="{{ route('penjualan.create') }}"
                                    class="bg-sky-400 p-1 text-white rounded-xl px-4">Tambah</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 bg-gray-100">
                                            NO
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            KODE PENJUALAN
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            TGL PENJUALAN
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            KONSUMEN
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            STATUS PEMBELIAN
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            TOTAL HARGA
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            TOTAL BAYAR
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            ACTION
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $f)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white bg-gray-100">
                                                {{ $no++ }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $f->kode_penjualan }}
                                            </td>
                                            <td class="px-6 py-4 bg-gray-100">
                                                {{ $f->tgl_penjualan }}
                                            </td>
                                            <td class="px-6 py-4 bg-gray-100">
                                                {{ $f->konsumen->nama_konsumen }}
                                            </td>
                                            <td class="px-6 py-4 bg-gray-100">
                                                {{ $f->status_pembelian }}
                                            </td>
                                            <td class="px-6 py-4 bg-gray-100">
                                                {{ $f->total_jual }}
                                            </td>
                                            <td class="px-6 py-4 bg-gray-100">
                                                {{ $f->total_bayar }}
                                            </td>
                                            @can('role-A')
                                            <td class="px-6 py-4 bg-gray-100">
                                                <button
                                                    class="bg-red-400 p-3 w-10 h-10 rounded-xl text-white hover:bg-red-500"
                                                    onclick="return dataDelete('{{ $f->id }}','{{ $f->konsumen->nama_konsumen }}')">
                                                    <i class="fi fi-sr-delete-document"></i>
                                                </button>
                                            </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        const dataDelete = async (id, nama_konsumen) => {
            let tanya = confirm(`Apakah anda yakin untuk menghapus transaksi ${nama_konsumen}?`);
            if (tanya) {
                try {
                    const response = await axios.post(`/penjualan/${id}`, {
                        '_method': 'DELETE',
                        '_token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    });

                    if (response.status === 200) {
                        alert('Transaksi berhasil dihapus');
                        location.reload();
                    } else {
                        alert('Gagal menghapus transaksi. Silakan coba lagi.');
                    }
                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan saat menghapus transaksi. Silakan cek konsol untuk detail.');
                }
            }
        };
    </script>
</x-app-layout>