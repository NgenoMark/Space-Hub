<!-- resources/views/booking/form.blade.php -->

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Book a Space</h3>
                    <form method="POST" action="{{ route('book') }}">
                        @csrf
                        <input type="hidden" name="space_id" value="{{ $space->space_id }}">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="bookingLocation" value="{{ $space->location }}" class="mt-1 block w-full" readonly>
                        </div>
                        <div class="mt-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="bookingDate" class="mt-1 block w-full" required>
                        </div>
                        <div class="mt-4">
                            <label for="place_name" class="block text-sm font-medium text-gray-700">Name of the Place</label>
                            <input type="text" name="place_name" id="bookingPlaceName" value="{{ $space->space_name }}" class="mt-1 block w-full" readonly>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
