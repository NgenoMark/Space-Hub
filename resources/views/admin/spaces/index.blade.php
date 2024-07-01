<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-4">
            {{ __('My Spaces') }}
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



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Space Name') }}
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Space Type') }}
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Description') }}
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Price') }}
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($spaces as $space)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $space->space_name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $space->space_type }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $space->description }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $space->price }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <a href="{{ route('spaces.edit', $space->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
