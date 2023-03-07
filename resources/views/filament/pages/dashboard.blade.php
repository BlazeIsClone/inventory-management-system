<x-filament::page>
    <div
        class="filament-stats-card relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800 filament-stats-overview-widget-card">
        <div class="space-y-2">
            <div
                class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span>Date</span>
            </div>
            <div class="text-3xl">
                {{ date('D m Y') }}
            </div>
        </div>
    </div>

</x-filament::page>
