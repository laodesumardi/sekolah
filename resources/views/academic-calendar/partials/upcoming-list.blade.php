<!-- Upcoming Events List -->
<div class="space-y-6">
    <!-- Filter Options -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <!-- Days Filter -->
                <select id="filter-days" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="7">7 Hari ke Depan</option>
                    <option value="14">14 Hari ke Depan</option>
                    <option value="30">30 Hari ke Depan</option>
                    <option value="90">3 Bulan ke Depan</option>
                </select>

                <!-- Type Filter -->
                <select id="filter-type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Jenis</option>
                    <option value="academic">Akademik</option>
                    <option value="holiday">Libur</option>
                    <option value="exam">Ujian</option>
                    <option value="event">Acara</option>
                </select>
            </div>

            <!-- View Toggle -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('academic-calendar.index') }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-list mr-2"></i>Semua Acara
                </a>
                <a href="{{ route('academic-calendar.calendar') }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-calendar mr-2"></i>Kalender
                </a>
                <a href="{{ route('academic-calendar.upcoming') }}" 
                   class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <i class="fas fa-clock mr-2"></i>Mendatang
                </a>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="space-y-4" id="upcoming-events">
        @forelse($upcomingEvents as $event)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden upcoming-event-item" 
                 data-type="{{ $event->type ?? '' }}" 
                 data-date="{{ $event->start_date }}">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <!-- Event Info -->
                        <div class="flex-1">
                            <div class="flex items-start space-x-4">
                                <!-- Date Badge -->
                                <div class="flex-shrink-0">
                                    <div class="bg-primary-100 text-primary-800 rounded-lg p-3 text-center min-w-[80px]">
                                        <div class="text-sm font-medium">{{ date('M', strtotime($event->start_date)) }}</div>
                                        <div class="text-2xl font-bold">{{ date('d', strtotime($event->start_date)) }}</div>
                                        <div class="text-xs text-primary-600">{{ date('Y', strtotime($event->start_date)) }}</div>
                                    </div>
                                </div>

                                <!-- Event Details -->
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $event->title }}</h3>
                                        
                                        <!-- Days Until -->
                                        @php
                                            $daysUntil = \Carbon\Carbon::parse($event->start_date)->diffInDays(\Carbon\Carbon::now());
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            @if($daysUntil <= 1) bg-red-100 text-red-800
                                            @elseif($daysUntil <= 3) bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            @if($daysUntil == 0) Hari ini
                                            @elseif($daysUntil == 1) Besok
                                            @else {{ $daysUntil }} hari lagi
                                            @endif
                                        </span>
                                    </div>
                                    
                                    @if($event->description)
                                        <p class="text-gray-600 mb-3 line-clamp-2">{{ $event->description }}</p>
                                    @endif

                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                        <!-- Date -->
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            @if($event->end_date && $event->end_date != $event->start_date)
                                                {{ date('d M Y', strtotime($event->start_date)) }} - {{ date('d M Y', strtotime($event->end_date)) }}
                                            @else
                                                {{ date('d M Y', strtotime($event->start_date)) }}
                                            @endif
                                        </div>

                                        <!-- Time -->
                                        @if($event->start_time)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $event->start_time }}
                                                @if($event->end_time)
                                                    - {{ $event->end_time }}
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Location -->
                                        @if($event->location)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $event->location }}
                                            </div>
                                        @endif

                                        <!-- Type -->
                                        @if($event->type)
                                            <div class="flex items-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($event->type === 'academic') bg-blue-100 text-blue-800
                                                    @elseif($event->type === 'holiday') bg-green-100 text-green-800
                                                    @elseif($event->type === 'exam') bg-red-100 text-red-800
                                                    @elseif($event->type === 'event') bg-purple-100 text-purple-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    @if($event->type === 'academic') Akademik
                                                    @elseif($event->type === 'holiday') Libur
                                                    @elseif($event->type === 'exam') Ujian
                                                    @elseif($event->type === 'event') Acara
                                                    @else {{ ucfirst($event->type) }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 lg:mt-0 lg:ml-4 flex items-center space-x-2">
                            @if($event->attachment)
                                <a href="{{ route('academic-calendar.download', $event->id) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada acara mendatang</h3>
                <p class="text-gray-500 mb-6">Belum ada acara yang dijadwalkan dalam periode ini.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('academic-calendar.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Lihat Semua Acara
                    </a>
                    <a href="{{ route('academic-calendar.calendar') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Lihat Kalender
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($upcomingEvents, 'hasPages') && $upcomingEvents->hasPages())
        <div class="mt-8">
            {{ $upcomingEvents->links() }}
        </div>
    @endif
</div>

<!-- JavaScript for filtering -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const daysFilter = document.getElementById('filter-days');
    const typeFilter = document.getElementById('filter-type');
    const eventItems = document.querySelectorAll('.upcoming-event-item');

    function filterEvents() {
        const selectedDays = parseInt(daysFilter.value);
        const selectedType = typeFilter.value;
        const today = new Date();

        eventItems.forEach(item => {
            const eventDate = new Date(item.dataset.date);
            const daysDiff = Math.ceil((eventDate - today) / (1000 * 60 * 60 * 24));
            const eventType = item.dataset.type;
            
            const matchesDays = daysDiff <= selectedDays && daysDiff >= 0;
            const matchesType = !selectedType || eventType === selectedType;
            
            if (matchesDays && matchesType) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    daysFilter.addEventListener('change', filterEvents);
    typeFilter.addEventListener('change', filterEvents);
});
</script>
