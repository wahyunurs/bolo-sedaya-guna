@component('user.components.user-layout')
    @include('user.components.navbar')

    <!-- SECTION PESANAN -->
    <section class="pt-20 sm:pt-24 pb-8 bg-[#e9ffe1] min-h-screen">
        <!-- Modal Flash Message -->
        @include('user.components.message-modal')

        <!-- JUDUL -->
        <h1
            class="text-center text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-wide text-green-800 mb-6 sm:mb-8 mt-4 sm:mt-8">
            RIWAYAT PESANAN
        </h1>

        <!-- SEARCH + FILTER + DELETE -->
        <div class="px-4 sm:px-6 lg:px-10 mb-8 sm:mb-12">
            <!-- Mobile: Single Row Layout -->
            <div class="flex items-center justify-center gap-2 lg:hidden">
                <!-- SEARCH BAR (Compact) -->
                <div class="flex items-center rounded-lg bg-white shadow-sm flex-1 max-w-md">
                    <div class="relative w-full">
                        <svg class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                        </svg>
                        <input id="pesananSearch" name="q" type="text" placeholder="Cari..."
                            value="{{ request('q') }}"
                            class="w-full pl-8 pr-2 py-2 text-xs text-gray-600 border-0 focus:outline-none focus:ring-0" />
                    </div>
                </div>

                <!-- FILTER STATUS (Compact) -->
                <select id="pesananStatus" name="status"
                    class="h-8 px-2 bg-white rounded-lg border-gray-300 text-xs text-gray-700 focus:ring-green-600 focus:border-green-600 flex-shrink-0">
                    <option value="">Semua</option>
                    <option value="Menunggu Verifikasi" {{ request('status') == 'Menunggu Verifikasi' ? 'selected' : '' }}>
                        Menunggu</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Dalam Pengiriman" {{ request('status') == 'Dalam Pengiriman' ? 'selected' : '' }}>Kirim
                    </option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                <!-- DELETE ALL (Compact) -->
                <button id="bulkDeleteBtn"
                    class="bg-red-500 hover:bg-red-600 text-white h-8 w-8 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                        <path d="M3 6h18" />
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    </svg>
                </button>
            </div>

            <!-- Desktop: Original Layout -->
            <div class="hidden lg:flex items-center justify-center gap-3">
                <!-- SEARCH BAR -->
                <div class="flex items-center rounded-xl w-full max-w-3xl overflow-hidden bg-white shadow-sm">
                    <div class="relative w-full">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                        </svg>
                        <input id="pesananSearchDesktop" name="q" type="text" placeholder="Cari pesanan..."
                            value="{{ request('q') }}"
                            class="w-full pl-11 pr-4 py-3 text-base text-gray-600 border-0 focus:outline-none focus:ring-0" />
                    </div>
                    <button class="bg-[#4CD137] px-6 py-3 text-white hover:bg-green-600 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <span>Cari</span>
                    </button>
                </div>

                <!-- FILTER STATUS -->
                <select id="pesananStatusDesktop" name="status"
                    class="h-12 px-8 bg-white rounded-xl border-gray-300 text-base text-gray-700 focus:ring-green-600 focus:border-green-600">
                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Menunggu Verifikasi" {{ request('status') == 'Menunggu Verifikasi' ? 'selected' : '' }}>
                        Menunggu Verifikasi</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Dalam Pengiriman" {{ request('status') == 'Dalam Pengiriman' ? 'selected' : '' }}>Dalam
                        Pengiriman
                    </option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                <!-- DELETE ALL -->
                <button id="bulkDeleteBtnDesktop"
                    class="bg-red-500 hover:bg-red-600 text-white h-12 w-12 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                        <path d="M3 6h18" />
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    </svg>
                </button>
            </div>

            <form id="selectDestroyForm" method="POST" action="{{ route('user.pesanan.selectDestroy') }}"
                style="display:none">
                @csrf
                <div id="selectedIdsContainer"></div>
            </form>

            {{-- include confirmation modal (reused) --}}
            @include('user.keranjang.konfirmasi-hapus')

        </div>

        <!-- LIST PESANAN -->
        <div id="pesananList" class="px-4 sm:px-6 lg:px-12 xl:px-28 space-y-4 sm:space-y-6 lg:space-y-8">
            @forelse ($pesanans as $pesanan)
                @php
                    $firstItem = $pesanan->items->first();
                    $img = optional(optional($firstItem)->produk->gambarProduks->first())->gambar ?? null;
                    $imgPath = $img ? asset('storage/img/produk/' . $img) : asset('img/card/produk1.png');
                    $totalJumlah = $pesanan->items->sum('kuantitas');
                    $status = $pesanan->status ?? '';
                    $badgeClass = 'bg-gray-200 text-gray-800';

                    // Exact enum mapping (case-sensitive):
                    // 'Menunggu Verifikasi', 'Ditolak', 'Diterima', 'Dalam Pengiriman', 'Selesai'
                    if ($status === 'Menunggu Verifikasi') {
                        $badgeClass = 'bg-gray-200 text-gray-800';
                    } elseif ($status === 'Ditolak') {
                        $badgeClass = 'bg-red-100 text-red-800';
                    } elseif ($status === 'Diterima') {
                        $badgeClass = 'bg-blue-100 text-blue-800';
                    } elseif ($status === 'Dalam Pengiriman') {
                        $badgeClass = 'bg-yellow-300 text-yellow-800';
                    } elseif ($status === 'Selesai') {
                        $badgeClass = 'bg-green-100 text-green-800';
                    }

                    // Disable interactions (checkbox + trash) for these statuses.
                    $disabledStatuses = ['Menunggu Verifikasi', 'Ditolak', 'Diterima', 'Dalam Pengiriman'];
                    $isDisabled = in_array($status, $disabledStatuses, true);
                @endphp

                <div data-id="{{ $pesanan->id }}"
                    class="pesanan-card bg-white rounded-xl sm:rounded-2xl shadow px-4 sm:px-6 lg:px-10 py-4 sm:py-6 grid grid-cols-1 lg:grid-cols-[22rem_minmax(0,1fr)_18rem] gap-4 lg:gap-x-4 items-start lg:items-center">

                    <!-- KIRI -->
                    <div class="flex items-start gap-6 self-start">

                        <!-- CHECKBOX -->
                        <input type="checkbox"
                            class="pesanan-checkbox self-center w-7 h-7 rounded-lg {{ $isDisabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                            value="{{ $pesanan->id }}" {{ $isDisabled ? 'disabled' : '' }}>

                        <!-- FOTO PRODUK -->
                        <img src="{{ $imgPath }}" class="h-24 w-24 rounded-xl object-cover">

                        <!-- INFO PESANAN -->
                        <div>
                            <p class="font-bold text-2xl text-gray-800 truncate max-w-[14rem]">
                                {{ optional($firstItem->produk)->nama ?? 'Produk' }}</p>

                            <p class="text-gray-600 mt-1">
                                Jumlah: <span class="font-semibold">{{ $totalJumlah }}</span>
                                {{ optional($firstItem->produk)->satuan_produk ?? '' }}
                            </p>

                            <!-- STATUS PESANAN -->
                            <span class="inline-block mt-2 {{ $badgeClass }} font-semibold px-3 py-1 rounded-lg">
                                {{ $pesanan->status ?? '-' }}
                            </span>
                        </div>
                    </div>
                    <!-- MIDDLE COLUMN: rejection message centered between left and right -->
                    <div class="px-4 min-w-0 flex items-center border-l border-r border-gray-100">
                        @if ($status === 'Ditolak')
                            <p
                                class="text-sm text-red-600 font-medium text-left break-words break-all whitespace-normal max-w-full">
                                Pesan: {{ $pesanan->keterangan ?? '-' }}</p>
                        @endif
                    </div>

                    <!-- KANAN (TOTAL HARGA + DELETE) -->
                    <div class="flex items-center gap-10 justify-end">

                        <!-- TOTAL HARGA -->
                        <p class="text-green-700 font-bold text-2xl whitespace-nowrap">
                            Rp {{ number_format($pesanan->total_bayar ?? 0, 0, ',', '.') }},-
                        </p>

                        <!-- EDIT DELIVERY (visible only when Ditolak) -->
                        @if ($status === 'Ditolak')
                            <a href="{{ route('user.pesanan.edit', $pesanan->id) }}" title="Ubah pesanan"
                                class="editDeliveryBtn p-2 rounded-lg text-blue-600 border border-blue-600 hover:bg-blue-600 hover:text-white transition mr-2 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                </svg>
                            </a>
                        @endif

                        <!-- ICON DELETE (opens confirmation modal) -->
                        <button type="button" data-id="{{ $pesanan->id }}" {{ $isDisabled ? 'disabled' : '' }}
                            class="singleDeleteBtn p-2 rounded-lg transition {{ $isDisabled ? 'text-gray-400 border-gray-200 cursor-not-allowed bg-transparent' : 'text-red-600 border border-red-600 hover:bg-red-600 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                <path d="M3 6h18" />
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
                        </button>

                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600">Tidak ada pesanan ditemukan.</p>
                </div>
            @endforelse
        </div>

    </section>

    <script>
        (function() {
            const urlBase = "{{ route('user.pesanan.index') }}";
            const input = document.getElementById('pesananSearch');
            const select = document.getElementById('pesananStatus');
            const listContainer = document.getElementById('pesananList');

            if (!listContainer) return;

            function debounce(fn, wait) {
                let t;
                return function() {
                    const args = arguments;
                    clearTimeout(t);
                    t = setTimeout(function() {
                        fn.apply(null, args);
                    }, wait);
                };
            }

            function submitAndReplace() {
                const params = new URLSearchParams();
                if (input && input.value.trim() !== '') params.set('q', input.value.trim());
                if (select && select.value) params.set('status', select.value);

                const url = urlBase + (params.toString() ? ('?' + params.toString()) : '');

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(function(res) {
                        if (!res.ok) throw new Error('Network error');
                        return res.text();
                    })
                    .then(function(html) {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newList = doc.getElementById('pesananList');
                        if (newList) {
                            listContainer.innerHTML = newList.innerHTML;
                        }
                    })
                    .catch(function(err) {
                        console.error('Fetch error:', err);
                    });
            }

            const debounced = debounce(submitAndReplace, 300);

            if (input) input.addEventListener('input', debounced);
            if (select) select.addEventListener('change', submitAndReplace);

            // Bulk and single delete handler (uses shared confirmation modal)
            const bulkBtn = document.getElementById('bulkDeleteBtn');
            const selectForm = document.getElementById('selectDestroyForm');
            const selectedContainer = document.getElementById('selectedIdsContainer');
            const singleForm = document.getElementById('singleDeleteForm');
            const destroyUrlTemplate = "{{ route('user.pesanan.destroy', ['id' => '__ID__']) }}";

            if (bulkBtn && selectForm && selectedContainer && singleForm) {
                let pendingBulkIds = [];
                let pendingSingleId = null;
                let mode = null; // 'bulk' or 'single'

                const modal = document.getElementById('bulkDeleteModal');
                const modalCountEl = document.getElementById('bulkDeleteCount');
                const modalCancel = document.getElementById('bulkDeleteCancel');
                const modalCloseTop = document.getElementById('btnCloseModalTop');
                const modalConfirm = document.getElementById('bulkDeleteConfirm');

                function openModalForBulk(ids) {
                    pendingBulkIds = ids;
                    pendingSingleId = null;
                    mode = 'bulk';
                    if (modal) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    }
                    if (modalCountEl) modalCountEl.textContent = String(ids.length);
                }

                function openModalForSingle(id) {
                    pendingSingleId = id;
                    pendingBulkIds = [];
                    mode = 'single';
                    if (modal) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    }
                    if (modalCountEl) modalCountEl.textContent = '1';
                }

                function closeModal() {
                    if (modal) {
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                    }
                }

                bulkBtn.addEventListener('click', function() {
                    const checked = Array.from(document.querySelectorAll('.pesanan-checkbox:checked'))
                        .map(function(el) {
                            return el.value;
                        });
                    if (checked.length === 0) {
                        alert('Pilih minimal satu pesanan untuk dihapus.');
                        return;
                    }
                    openModalForBulk(checked);
                });

                // single delete buttons
                document.querySelectorAll('.singleDeleteBtn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const id = btn.getAttribute('data-id');
                        if (!id) return;
                        openModalForSingle(id);
                    });
                });

                if (modalCancel) modalCancel.addEventListener('click', closeModal);
                if (modalCloseTop) modalCloseTop.addEventListener('click', closeModal);

                if (modalConfirm) modalConfirm.addEventListener('click', function() {
                    if (mode === 'single' && pendingSingleId) {
                        // set action on single form and submit
                        const action = destroyUrlTemplate.replace('__ID__', pendingSingleId);
                        singleForm.action = action;
                        singleForm.submit();
                        return;
                    }

                    if (mode === 'bulk' && pendingBulkIds.length > 0) {
                        selectedContainer.innerHTML = '';
                        pendingBulkIds.forEach(function(id) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = id;
                            selectedContainer.appendChild(input);
                        });
                        selectForm.submit();
                        return;
                    }

                    closeModal();
                });
            }

            // Card click -> open detail modal
            document.querySelectorAll('.pesanan-card').forEach(function(card) {
                card.addEventListener('click', function(e) {
                    // ignore clicks on checkbox or buttons inside card
                    if (e.target.closest('input') || e.target.closest('button')) return;
                    const id = card.getAttribute('data-id');
                    if (!id) return;
                    const url = "{{ url('user/pesanan') }}" + '/' + id;
                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(function(res) {
                            if (!res.ok) throw new Error('Network error');
                            return res.text();
                        })
                        .then(function(html) {
                            // append modal HTML and it's self-handling close
                            const wrapper = document.createElement('div');
                            wrapper.innerHTML = html;
                            document.body.appendChild(wrapper);
                        }).catch(function(err) {
                            console.error(err);
                        });
                });
            });
        })();
    </script>
@endcomponent
