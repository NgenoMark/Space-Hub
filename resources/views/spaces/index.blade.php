<!-- resources/views/spaces/index.blade.php -->
<x-app-layout>
    <div class="flex space-x-8 mt-4 ml-4">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Home Page') }}
        </x-nav-link>
        <x-nav-link href="{{ route('spaces.index') }}" :active="request()->routeIs('spaces.index') ">
            {{ __('Spaces') }}
        </x-nav-link>
        <x-nav-link href="{{ route('bookings.index') }}" :active="request()->routeIs('bookings.index') ">
            {{ __('My Bookings') }}
        </x-nav-link>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('search') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" id="location" class="mt-1 block w-full" required>
                            </div>
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                                <input type="number" name="capacity" id="capacity" class="mt-1 block w-full" required>
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price Range</label>
                                <div class="flex space-x-2">
                                    <input type="number" name="price_min" id="price_min" placeholder="Min" class="mt-1 block w-full">
                                    <input type="number" name="price_max" id="price_max" placeholder="Max" class="mt-1 block w-full">
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @isset($spaces)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($spaces as $space)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $space->space_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $space->location }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $space->capacity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $space->price }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form method="GET" action="{{ route('booking.form', ['space_id' => $space->space_id]) }}">
                                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Select</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endisset
    </div>
</x-app-layout>
