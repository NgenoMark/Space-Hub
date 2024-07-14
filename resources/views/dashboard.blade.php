<x-app-layout>
    <div class="flex space-x-8 mt-4 ml-4">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Home Page') }}
        </x-nav-link>
        <x-nav-link href="{{ route('spaces.index') }}" :active="request()->routeIs('spaces.index')">
            {{ __('Spaces') }}
        </x-nav-link>
        <x-nav-link href="{{ route('bookings.index') }}" :active="request()->routeIs('bookings.index')">
            {{ __('My Bookings') }}
        </x-nav-link>
    </div>

 
</x-app-layout>
