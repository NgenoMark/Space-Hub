<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-4">
            {{ __('Home Page') }}
        </h2>
        <div class="flex space-x-8 mt-4 ml-4">
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Home Page') }}
            </x-nav-link>
            <x-nav-link href="{{ route('admin.spaces.index') }}" :active="request()->routeIs('admin.spaces.index')">
                {{ __('My Space') }}
            </x-nav-link>
            <x-nav-link href="{{ route('admin.bookings.list') }}" :active="request()->routeIs('admin.bookings.list')">
                {{ __('Bookings') }}
            </x-nav-link>
            <x-nav-link href="{{ route('admin.spaces.create') }}" :active="request()->routeIs('admin.spaces.create')">
                {{ __('Create Space') }}
            </x-nav-link> 
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="content" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Welcome to your admin dashboard!</p>

                    <!-- Canvas for the chart -->
                    <canvas id="spaceOwnerChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Function to fetch chart data and render the chart
        function loadChart() {
            fetch('{{ route('spaceowner.chartdata') }}')
                .then(response => response.json())
                .then(data => {
                    // Prepare data for Chart.js
                    const labels = data.map(item => item.spaceName);
                    const values = data.map(item => item.bookingsCount);

                    // Create the chart
                    const ctx = document.getElementById('spaceOwnerChart').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'bar', // You can change this to the type of chart you want
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Bookings Count',
                                data: values,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading chart data:', error));
        }

        // Load the chart when the page is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            loadChart();
        });
    </script>
</x-app-layout>
