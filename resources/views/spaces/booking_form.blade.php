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
        {{-- <x-nav-link href="{{ route('warehouses.index') }}" :active="request()->routeIs('warehouses.index')">
            {{ __('Warehouses') }}
        </x-nav-link> --}}
        <x-nav-link href="{{ route('spaces.book') }}" :active="request()->routeIs('spaces.book')">
            {{ __('My Bookings') }}
        </x-nav-link>
    </div>



    <!-- resources/views/spaces/booking_form.blade.php -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Booking Form for {{ $space->space_name }}</h2>

                    <form method="POST" action="{{ route('booking.submit', ['space_id' => $space->id]) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="full_name" id="full_name" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="booking_date" class="block text-sm font-medium text-gray-700">Booking Date</label>
                            <input type="date" name="booking_date" id="booking_date" class="mt-1 block w-full" required>
                        </div>

                        <!-- Add more fields as per your booking form requirements -->

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Submit Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
