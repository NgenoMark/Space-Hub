<!-- resources/views/your_booking_form.blade.php -->

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Booking Form for {{ $space->space_name }}</h2>

                    <form method="POST" action="{{ route('booking.submit', ['space_id' => $space->space_id]) }}">
                        @csrf
                        <input type="hidden" name="space_id" value="{{ $space->space_id }}">
                        <input type="hidden" name="space_name" value="{{ $space->space_name }}">
                        <input type="hidden" name="provider_id" value="{{ $space->provider_id }}"> {{-- Assuming this data is available --}}
                        
                        <div class="mb-4">
                            <label for="place_name" class="block text-sm font-medium text-gray-700">Name of the Place</label>
                            <input type="text" name="place_name" id="place_name" value="{{ $space->space_name }}" class="mt-1 block w-full" readonly>
                        </div>
                        
                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ $space->location }}" class="mt-1 block w-full" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="full_name" id="full_name" value="{{ Auth::user()->name }}" class="mt-1 block w-full" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone_number" id="phone_number" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="booking_date" class="block text-sm font-medium text-gray-700">Booking Date</label>
                            <input type="date" name="booking_date" id="booking_date" class="mt-1 block w-full" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Submit Booking</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
