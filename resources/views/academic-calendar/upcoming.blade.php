@extends('layouts.app')

@section('title', 'Kalender Akademik - Acara Mendatang')

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
                    <h1 class="text-4xl font-bold mb-4">Acara Mendatang</h1>
                    <p class="text-xl text-primary-100">Acara yang akan datang</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Upcoming List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('academic-calendar.partials.upcoming-list', ['upcomingEvents' => $events])
    </div>
</div>
@endsection
