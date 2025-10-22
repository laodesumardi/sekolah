<!-- Calendar Grid -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <!-- Calendar Header -->
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">
                {{ $currentMonth->format('F Y') }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('academic-calendar.calendar', ['month' => $currentMonth->copy()->subMonth()->format('Y-m')]) }}" 
                   class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <a href="{{ route('academic-calendar.calendar') }}" 
                   class="px-3 py-1 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded transition-colors">
                    Hari Ini
                </a>
                <a href="{{ route('academic-calendar.calendar', ['month' => $currentMonth->copy()->addMonth()->format('Y-m')]) }}" 
                   class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="p-6">
        <!-- Days of Week Header -->
        <div class="grid grid-cols-7 gap-1 mb-4">
            @foreach(['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                <div class="text-center text-sm font-medium text-gray-500 py-2">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        <!-- Calendar Days -->
        <div class="grid grid-cols-7 gap-1">
            @foreach($calendarDays as $week)
                @foreach($week as $day)
                    <div class="min-h-[100px] border border-gray-200 rounded-lg p-2
                        @if($day['is_current_month']) bg-white
                        @else bg-gray-50 @endif
                        @if($day['is_today']) ring-2 ring-primary-500 @endif">
                        
                        <!-- Day Number -->
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium
                                @if($day['is_today']) text-primary-600
                                @elseif($day['is_current_month']) text-gray-900
                                @else text-gray-400 @endif">
                                {{ $day['date']->day }}
                            </span>
                            
                            @if($day['is_today'])
                                <span class="w-2 h-2 bg-primary-500 rounded-full"></span>
                            @endif
                        </div>

                        <!-- Events for this day -->
                        <div class="space-y-1">
                            @foreach($day['events'] as $event)
                                <div class="text-xs p-1 rounded cursor-pointer hover:bg-gray-100 transition-colors
                                    @if($event->type === 'academic') bg-blue-100 text-blue-800
                                    @elseif($event->type === 'holiday') bg-green-100 text-green-800
                                    @elseif($event->type === 'exam') bg-red-100 text-red-800
                                    @elseif($event->type === 'event') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif"
                                    title="{{ $event->title }} - {{ $event->start_time ?? 'Sepanjang hari' }}">
                                    <div class="truncate font-medium">{{ $event->title }}</div>
                                    @if($event->start_time)
                                        <div class="text-xs opacity-75">{{ $event->start_time }}</div>
                                    @endif
                                </div>
                            @endforeach
                            
                            @if(count($day['events']) > 3)
                                <div class="text-xs text-gray-500 text-center">
                                    +{{ count($day['events']) - 3 }} lagi
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Legend -->
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        <div class="flex flex-wrap items-center gap-4 text-sm">
            <span class="text-gray-600 font-medium">Legenda:</span>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 bg-blue-100 rounded"></span>
                <span class="text-gray-600">Akademik</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 bg-green-100 rounded"></span>
                <span class="text-gray-600">Libur</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 bg-red-100 rounded"></span>
                <span class="text-gray-600">Ujian</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 bg-purple-100 rounded"></span>
                <span class="text-gray-600">Acara</span>
            </div>
        </div>
    </div>
</div>

<!-- Event Details Modal (if needed) -->
<div id="event-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-event-title">Event Title</h3>
                    <button onclick="closeEventModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="modal-event-details" class="text-gray-600">
                    <!-- Event details will be populated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showEventModal(eventData) {
    document.getElementById('modal-event-title').textContent = eventData.title;
    document.getElementById('modal-event-details').innerHTML = `
        <div class="space-y-2">
            <p><strong>Tanggal:</strong> ${eventData.date}</p>
            ${eventData.time ? `<p><strong>Waktu:</strong> ${eventData.time}</p>` : ''}
            ${eventData.location ? `<p><strong>Lokasi:</strong> ${eventData.location}</p>` : ''}
            ${eventData.description ? `<p><strong>Deskripsi:</strong> ${eventData.description}</p>` : ''}
        </div>
    `;
    document.getElementById('event-modal').classList.remove('hidden');
}

function closeEventModal() {
    document.getElementById('event-modal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('event-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEventModal();
    }
});
</script>
