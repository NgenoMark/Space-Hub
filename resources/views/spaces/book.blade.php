<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="flex space-x-8 mt-4 ml-4">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Home Page') }}
        </x-nav-link>
        <x-nav-link href="{{ route('spaces.index') }}" :active="request()->routeIs('spaces.index')">
            {{ __('Spaces') }}
        </x-nav-link>
        <x-nav-link href="{{ route('warehouses.index') }}" :active="request()->routeIs('warehouses.index')">
            {{ __('Warehouses') }}
        </x-nav-link>
        <x-nav-link href="{{ route('spaces.book') }}" :active="request()->routeIs('spaces.book')">
            {{ __('My Bookings') }}
        </x-nav-link>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($bookings->isEmpty())
                        <p>No bookings found.</p>
                    @else
                        <h2 class="text-xl font-semibold mb-4">My Bookings</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($bookings as $booking)
                                <div class="p-4 border rounded-lg bg-gray-100">
                                    <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                                    <p><strong>Location:</strong> {{ $booking->space->location }}</p>
                                    <p><strong>Date:</strong> {{ $booking->booking_date }}</p>
                                    {{-- Add more booking details as needed --}}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
