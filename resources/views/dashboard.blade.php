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
        <x-nav-link href="{{ route('bookings.index') }}" :active="request()->routeIs('bookings.index')">
    {{ __('My Bookings') }}
</x-nav-link>
    </div>


    <div id="content" class="py-12">
        <!-- Dynamic content will be loaded here -->
    </div>


</x-app-layout>
