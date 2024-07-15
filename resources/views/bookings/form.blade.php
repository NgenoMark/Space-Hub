<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Summary Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-4">Summary of {{ $space->space_name }}</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-bold">Type</label>
                            <p class="mt-1 text-gray-900">{{ $space->space_type }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold">Description</label>
                            <p class="mt-1 text-gray-900">{{ $space->description }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold">Price</label>
                            <p class="mt-1 text-gray-900">${{ $space->price }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold">Images</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-1">
                                @if(!empty($space->images) && count($space->images) > 0)
                                    @foreach($space->images as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $space->space_name }}" class="w-64 h-64 object-cover rounded-md shadow-sm">
                                    @endforeach
                                @else
                                    <p class="mt-1 text-gray-900">No images found for this space.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End of Summary Section -->

                    <h2 class="text-2xl font-bold mb-4">Booking Form for {{ $space->space_name }}</h2>

                    <form method="POST" action="{{ route('booking.submit', ['space_id' => $space->space_id]) }}">
                        @csrf
                        <input type="hidden" name="space_id" value="{{ $space->space_id }}">
                        <input type="hidden" name="space_name" value="{{ $space->space_name }}">
                        <input type="hidden" name="provider_id" value="{{ $space->provider_id }}">

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
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full" min="{{ date('Y-m-d') }}" required>
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
