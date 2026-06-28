@props([
    'id' => '',
    'title' => ''
])

<div id="{{ $id }}" class="fixed inset-0 z-50 items-center justify-center hidden p-4 bg-slate-900/50 backdrop-blur-sm transition-all duration-300">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-xl border border-slate-100 overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-150 flex items-center justify-between bg-slate-50">
            <h3 class="text-base font-bold text-slate-800">{{ $title }}</h3>
            <button type="button" onclick="closeModal('{{ $id }}')" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <!-- Modal Body -->
        <div class="px-6 py-5 text-sm text-slate-600">
            {{ $slot }}
        </div>
    </div>
</div>

<script>
    if (typeof openModal === 'undefined') {
        window.openModal = function(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }
        }
        window.closeModal = function(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }
        }
    }
</script>
