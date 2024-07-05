<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Booking') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <form method="POST" action="{{ route('admin.bookings.update', $booking->booking_id) }}">
                @csrf
                @method('PUT')

                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="booking_date">Booking Date</label>
                        <input type="date" name="booking_date" id="booking_date" value="{{ $booking->booking_date }}" required class="mt-1 block w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                        <select name="status" id="status" required class="mt-1 block w-full">
                            <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Accepted" {{ $booking->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="Denied" {{ $booking->status == 'Denied' ? 'selected' : '' }}>Denied</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="total_price">Total Price</label>
                        <input type="text" name="total_price" id="total_price" value="{{ $booking->total_price }}" required class="mt-1 block w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" value="{{ $booking->full_name }}" required class="mt-1 block w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ $booking->email }}" required class="mt-1 block w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ $booking->phone_number }}" required class="mt-1 block w-full">
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
