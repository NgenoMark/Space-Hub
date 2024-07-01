<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-4">
            {{ __('Bookings') }}
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
                </div>
            </div>
        </div>
    </div>





    <script>
        function loadContent(url) {
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('content').innerHTML = data.view;
            })
            .catch(error => console.error('Error loading content:', error));
        }
    </script>
</x-app-layout>
