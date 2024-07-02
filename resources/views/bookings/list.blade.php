<div class="p-6 bg-white border-b border-gray-200">
    <h3 class="text-lg font-medium text-gray-900">Bookings</h3>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($bookings as $booking)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking->booking_id) }}" class="update-status-form">
                            @csrf
                            <select name="status" class="status-dropdown" data-id="{{ $booking->booking_id }}">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $booking->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="denied" {{ $booking->status == 'denied' ? 'selected' : '' }}>Denied</option>
                            </select>
                            <button type="submit" class="hidden submit-status-button"></button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->total_price }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button class="update-status-button px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
