<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-4">
            {{ __('My Space') }}
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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('spaces.update', $space->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="space_name" class="block text-sm font-medium text-gray-700">{{ __('Space Name') }}</label>
                            <input type="text" name="space_name" id="space_name" value="{{ old('space_name', $space->space_name) }}" class="mt-1 form-input block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="space_type" class="block text-sm font-medium text-gray-700">{{ __('Space Type') }}</label>
                            <input type="text" name="space_type" id="space_type" value="{{ old('space_type', $space->space_type) }}" class="mt-1 form-input block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="mt-1 form-textarea block w-full">{{ old('description', $space->description) }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
                            <input type="text" name="price" id="price" value="{{ old('price', $space->price) }}" class="mt-1 form-input block w-full" required>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Update Space') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
