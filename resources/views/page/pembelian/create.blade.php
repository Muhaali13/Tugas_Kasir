<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="gap-5 items-start flex">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-full p-4">
                    <div class="p-4 bg-gray-100 mb-6 rounded-xl font-bold">
                        <div class="flex items-center justify-between">
                            <div class="w-full">
                                FORM INPUT PEMBELIAN
                            </div>
                        </div>
                    </div>
                    {{-- FORM INPUT PEMBELIAN --}}
                        <div>
                            <form class="w-full mx-auto" method="POST" action="{{ route('pembelian.store') }}">
                                @csrf
                                <div class="flex gap-5">
                                    <div class="mb-5 w-full">
                                        <label for="kode_pembelian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pembelian</label>
                                        <input type="text" id="kode_pembelian" name="kode_pembelian" value="{{ $kodePembelian }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Kode Penjualan" readonly required />
                                    </div>
                                    <div class="mb-5 w-full">
                                        <label for="tgl_pembelian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pembelian</label>
                                        <input type="date" id="tgl_pembelian" name="tgl_pembelian" value="{{ date('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                                    </div>
                                </div>
                                <div class="flex gap-5">
                                    <div class="mb-5 w-full">
                                        <label for="supplier"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier</label>
                                        <select class="js-example-placeholder-single js-states form-control w-full m-6"
                                            id="id_supplier" name="id_supplier" data-placeholder="Pilih supllier">
                                            <option value="">Pilih...</option>
                                            @foreach ($supplier as $k)
                                                <option value="{{ $k->id }}">{{ $k->nama_supplier }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- DETAIL PEMBELIAN PRODUK --}}
                                    <div class="p-4 bg-gray-100 mb-6 rounded-xl font-bold">
                                        <div class="flex items-center justify-between">
                                            <div class="w-full">
                                                DETAIL PRODUK PEMBELIAN
                                            </div>
                                            <div><button id="addRowBtn"
                                                class="bg-sky-400 hover:bg-sky-500 text-white px-2 rounded-xl">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="border border-2 rounded-xl p-2 mb-2" id="produkContainer">
                                        </div>
                                    </div>
                                {{-- ======================= --}}
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </form>
                        </div>
                    {{-- =================== --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // MENAMBAH ROW DETAIL PRODUK 
            $('#addRowBtn').click(function(event) {
                event.preventDefault();
                addRow();
            });

            let rowCount = 0;

            function addRow() {
                rowCount++;
                const newRow = `<div class="border border-2 rounded-xl mb-2 p-2" id="row${rowCount}">
                                <div class="flex mb-2 gap-2">
                                    <div class="mb-5 w-full">
                                        <label for="produk${rowCount}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Produk</label>
                                        <select id="produk${rowCount}" name="produk[]" class="form-control w-full"
                                            onchange="getProduk(${rowCount})">
                                            <option value="">Pilih...</option>
                                            @foreach ($produk as $k)
                                                <option value="{{ $k->kode_produk }}">{{ $k->produk }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-5 w-full">
                                        <label for="harga${rowCount}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                                        <input type="number" id="harga${rowCount}" name="harga[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                    </div>
                                    <div class="mb-5 w-full">
                                        <label for="qty${rowCount}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Qty</label>
                                        <input type="number" id="qty${rowCount}" name="qty[]"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required value="0"/>
                                    </div>
                                    <div class="mb-5 w-full">
                                        <label for="total_harga${rowCount}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Harga</label>
                                        <input type="number" id="total_harga${rowCount}" name="total_harga"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required readonly/>
                                    </div>
                                    <button type="button" class="px-2 bg-red-100" onclick="removeRow(${rowCount})">
                                        Hapus
                                    </button>
                                </div>
                            </div>`;
                $('#produkContainer').append(newRow);
                $(`#produk${rowCount}`).select2({
                    placeholder: "Pilih Produk"
                });

                // tambahin ini
                bindRowEvents(rowCount);
            }

            function bindRowEvents(rowId) {
                const hargaInput = document.getElementById(`harga${rowId}`);
                const qtyInput = document.getElementById(`qty${rowId}`);
                const totalHargaInput = document.getElementById(`total_harga${rowId}`);

                // Perhitungan total harga
                const calculateTotalHarga = () => {
                    const harga = parseFloat(hargaInput.value) || 0;
                    const qty = parseInt(qtyInput.value) || 0;
                    totalHargaInput.value = harga * qty;
                };
                qtyInput.addEventListener("input", calculateTotalHarga);
            }
        });

        // MENGHAPUS ROW DETAIL PRODUK PENJUALAN
        function removeRow(rowId) {
            $(`#row${rowId}`).remove();
            updateRowNumbers();
        }
    </script>

    <script>
        const getProduk = (rowCount) => {
            const produkId = document.getElementById(`produk${rowCount}`).value;

            if (!produkId) {
                document.getElementById(`harga${rowCount}`).value = "";
                return;
            }

            axios.get(`/produk/produk_name/${produkId}`)
                .then(response => {
                    const produk = response.data.produk;

                    document.getElementById(`harga${rowCount}`).value = produk ? produk.harga_jual : "";
                })
                .catch(error => {
                    console.error("Gagal memuat data produk:", error);
                    document.getElementById(`harga${rowCount}`).value = "";
                });
        };
    </script>

</x-app-layout>
