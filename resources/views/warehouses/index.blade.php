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
        {{--<x-nav-link href="{{ route('warehouses.index') }}" :active="request()->routeIs('warehouses.index')">
            {{ __('Warehouses') }}
        </x-nav-link> --}}
        <x-nav-link href="{{ route('spaces.book') }}" :active="request()->routeIs('spaces.book')">
    {{ __('My Bookings') }}
</x-nav-link>

    </div>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="searchForm" method="GET" action="{{ route('search') }}">
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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div id="searchResults" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Search results will be injected here by JavaScript -->
            </div>
        </div>

        <div id="bookingSection" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 hidden">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Book a Space</h3>
                    <form id="bookingForm" method="POST" action="{{ route('book') }}">
                        @csrf
                        <input type="hidden" name="platform_id" id="platform_id">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="bookingLocation" class="mt-1 block w-full" readonly>
                        </div>
                        <div class="mt-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="bookingDate" class="mt-1 block w-full" required>
                        </div>
                        <div class="mt-4">
                            <label for="place_name" class="block text-sm font-medium text-gray-700">Name of the Place</label>
                            <input type="text" name="place_name" id="bookingPlaceName" class="mt-1 block w-full" readonly>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function (event) {
    event.preventDefault();
    fetchSearchResults();
});

function fetchSearchResults() {
    const form = document.getElementById('searchForm');
    const formData = new FormData(form);
    const queryParams = new URLSearchParams(formData).toString();

    fetch(`{{ route('search') }}?${queryParams}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        displaySearchResults(data);
    });
}

function displaySearchResults(results) {
    const searchResultsDiv = document.getElementById('searchResults');
    searchResultsDiv.innerHTML = '';
    results.forEach(result => {
        const resultDiv = document.createElement('div');
        resultDiv.classList.add('p-6', 'border-b', 'border-gray-200');
        resultDiv.innerHTML = `
            <h3 class="text-lg font-medium text-gray-900">${result.name}</h3>
            <p class="mt-2">${result.location}</p>
            <p class="mt-2">Capacity: ${result.capacity}</p>
            <p class="mt-2">Price: ${result.price}</p>
            <button onclick="selectPlatform(${result.id}, '${result.location}', '${result.name}')" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md">Select</button>
        `;
        searchResultsDiv.appendChild(resultDiv);
    });
}

function selectPlatform(id, location, name) {
    document.getElementById('platform_id').value = id;
    document.getElementById('bookingLocation').value = location;
    document.getElementById('bookingPlaceName').value = name;
    document.getElementById('bookingSection').classList.remove('hidden');
    window.scrollTo(0, document.getElementById('bookingSection').offsetTop);
}
</script>
</x-app-layout>
