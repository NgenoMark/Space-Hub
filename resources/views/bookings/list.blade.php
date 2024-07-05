<div class="p-6 bg-white border-b border-gray-200">
    <h3 class="text-lg font-medium text-gray-900">Bookings</h3>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($bookings as $booking)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->status }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->total_price }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->full_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->phone_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.bookings.edit', $booking->booking_id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
