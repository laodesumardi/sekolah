@extends('layouts.app')

@section('title', 'Kalender Akademik - Tampilan Bulanan')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                @if($academicCalendarSection && $academicCalendarSection->is_active)
                    <h1 class="text-4xl font-bold mb-4">{{ $academicCalendarSection->title }}</h1>
                    @if($academicCalendarSection->subtitle)
                        <p class="text-xl text-primary-100 mb-3">{{ $academicCalendarSection->subtitle }}</p>
                    @endif
                    @if($academicCalendarSection->description)
                        <p class="text-lg text-gray-300 max-w-3xl mx-auto">{{ $academicCalendarSection->description }}</p>
                    @endif
                @else
                    <h1 class="text-4xl font-bold mb-4">Kalender Akademik</h1>
                    <p class="text-xl text-primary-100">Tampilan kalender bulanan untuk jadwal sekolah</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Month/Year Navigation -->
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <a href="{{ route('academic-calendar.calendar', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}" 
                       class="bg-white border border-gray-300 rounded-lg px-3 py-2 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <span class="text-lg font-semibold text-gray-900">{{ $monthName }} {{ $year }}</span>
                    <a href="{{ route('academic-calendar.calendar', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}" 
                       class="bg-white border border-gray-300 rounded-lg px-3 py-2 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Links to other views -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('academic-calendar.index') }}" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">Semua Acara</a>
                    <a href="{{ route('academic-calendar.upcoming') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">Mendatang</a>
                </div>
            </div>
        </div>
    </div>

    @include('academic-calendar.partials.calendar-grid', [
        'calendarDays' => $calendarData,
        'currentMonth' => \Carbon\Carbon::create($year, $month, 1),
        'events' => $events
    ])
</div>
@endsection
