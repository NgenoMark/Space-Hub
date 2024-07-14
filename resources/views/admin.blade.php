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
            <!-- First row with three columns -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-64 w-full">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <p class="text-lg">Owned Spaces</p>
                        <p class="font-bold text-2xl">{{ $ownedSpacesCount }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-64 w-full">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <p class="text-lg">Approved Bookings</p>
                        <p class="font-bold text-2xl">{{ $approvedBookingsCount }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-64 w-full">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <p class="text-lg">Total Income</p>
                        <p class="font-bold text-2xl">{{ $totalIncome }}</p>
                    </div>
                </div>
            </div>

            <!-- Second row with two columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Income Graph -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-120 w-full">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <p class="text-lg">Income Graph</p>
                        <canvas id="incomeChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Bookings Analysis Bar Chart -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-120 w-full">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="text-lg text-center">Bookings Analysis</p>
                        <canvas id="bookingAnalysisChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch data for income chart
            fetch('{{ route('admin.income.graph.data') }}')
                .then(response => response.json())
                .then(data => {
                    const ctxIncome = document.getElementById('incomeChart').getContext('2d');
                    new Chart(ctxIncome, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Income',
                                data: data.incomeData,
                                borderColor: 'rgb(54, 162, 235)',
                                borderWidth: 2,
                                fill: false
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Date'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Income'
                                    }
                                }
                            }
                        }
                    });
                });

            // Fetch data for booking analysis chart
            fetch('{{ route('admin.booking.analysis.data') }}')
                .then(response => response.json())
                .then(data => {
                    const ctxBookingAnalysis = document.getElementById('bookingAnalysisChart').getContext('2d');
                    new Chart(ctxBookingAnalysis, {
                        type: 'bar',
                        data: {
                            labels: data.spaceNames,
                            datasets: [{
                                label: 'Number of Bookings',
                                data: data.bookingCounts,
                                backgroundColor: 'rgb(75, 192, 192)', // Adjust color as needed
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Space'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Bookings'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script>
</x-app-layout>
