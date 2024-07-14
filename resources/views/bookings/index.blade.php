<x-app-layout>
    {{-- Uncomment this section if you want to include a header --}}
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot> --}}

    <div class="flex space-x-8 mt-4 ml-4">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Home') }}
        </x-nav-link>
        <x-nav-link href="{{ route('spaces.index') }}" :active="request()->routeIs('spaces.index')">
            {{ __('Spaces') }}
        </x-nav-link>
        {{-- <x-nav-link href="{{ route('warehouses.index') }}" :active="request()->routeIs('warehouses.index')">
            {{ __('Warehouses') }}
        </x-nav-link> --}}
        <x-nav-link href="{{ route('bookings.index') }}" :active="request()->routeIs('bookings.index')">
            {{ __('My Bookings') }}
        </x-nav-link>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">My Bookings</h2>

                    @if ($bookings->isEmpty())
                        <p>No bookings found.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Space Name
                                    </th>
                                    <th scope="col" class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Full Name
                                    </th>
                                    <th scope="col" class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Phone Number
                                    </th>
                                    <th scope="col" class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Start Date
                                    </th>
                                    <th scope="col" class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        End Date
                                    </th>
                                    <th scope="col" class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->space_name }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->full_name }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->email }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->phone_number }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->end_date)->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="px-2 py-1 rounded-md text-white
                                                @if($booking->status === 'Accepted') bg-green-500
                                                @elseif($booking->status === 'Denied') bg-red-500
                                                @elseif($booking->status === 'pending') bg-yellow-500
                                                @else bg-gray-500
                                                @endif">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <form id="cancel-booking-{{ $booking->booking_id }}" action="{{ route('bookings.cancel', $booking->booking_id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                            <button onclick="confirmCancellation({{ $booking->booking_id }})" class="px-4 py-2 bg-red-500 text-white rounded-md">Cancel</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmCancellation(bookingId) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                document.getElementById('cancel-booking-' + bookingId).submit();
            }
        }
    </script>
</x-app-layout>
