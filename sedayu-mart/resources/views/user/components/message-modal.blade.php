<!-- Modal Flash Message -->
@if (session('success') || session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2" x-init="setTimeout(() => show = false, 4500)" class="fixed top-16 right-4 z-50">

        <div
            class="w-80 max-w-sm rounded-lg shadow-lg overflow-hidden relative
            {{ session('success') ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }}">

            <div class="p-4 flex items-start gap-3">

                {{-- ICON --}}
                @if (session('success'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-green-700"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                @elseif (session('error'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-red-700"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V6a1 1 0 112 0v3a1 1 0 11-2 0zm0 4a1 1 0 112 0 1 1 0 11-2 0z"
                            clip-rule="evenodd" />
                    </svg>
                @endif

                {{-- TEXT --}}
                <div class="flex-1">
                    <p class="font-semibold">
                        {{ session('success') ? 'Berhasil' : 'Gagal' }}
                    </p>
                    <p class="text-sm {{ session('success') ? 'text-green-900' : 'text-red-900' }}">
                        {{ session('success') ?? session('error') }}
                    </p>
                </div>

                {{-- CLOSE BUTTON --}}
                <button @click="show = false"
                    class="cursor-pointer {{ session('success') ? 'text-green-700 hover:text-green-900' : 'text-red-700 hover:text-red-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
