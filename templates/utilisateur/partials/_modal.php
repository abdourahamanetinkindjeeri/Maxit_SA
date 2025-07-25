<div id="customModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm mx-4 shadow-2xl transform transition-all">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full bg-maxitOrange/10 flex items-center justify-center mr-3">
                <svg id="modalIcon" class="w-6 h-6 text-maxitOrange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Information</h3>
        </div>
        <p id="modalMessage" class="text-gray-600 mb-6 text-sm leading-relaxed">Message du popup</p>
        <div class="flex gap-3">
            <button id="modalCancel" class="flex-1 px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium hidden">
                Annuler
            </button>
            <button id="modalConfirm" class="flex-1 px-4 py-2 bg-maxitOrange text-white rounded-lg hover:bg-maxitOrangeDark transition-colors text-sm font-medium">
                OK
            </button>
        </div>
    </div>
</div> 