<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-4">
            {{ __('Create a Space') }}
        </h2>
        <div class="flex space-x-8 mt-4 ml-4">
            <x-nav-link href="{{ route('admin') }}" :active="request()->routeIs('admin')">
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
                    <form method="POST" action="{{ route('admin.spaces.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Space Name -->
                        <div class="mt-4">
                            <x-label for="space_name" :value="__('Space Name')" />
                            <x-input id="space_name" class="block mt-1 w-full" type="text" name="space_name" :value="old('space_name')" required autofocus />
                        </div>

                        <!-- Space Type -->
                        <div class="mt-4">
                            <x-label for="space_type" :value="__('Space Type')" />
                            <x-input id="space_type" class="block mt-1 w-full" type="text" name="space_type" :value="old('space_type')" required />
                        </div>

                        <!-- Location -->
                        <div class="mt-4">
                            <x-label for="location" :value="__('Location')" />
                            <x-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                        </div>

                        <!-- Capacity -->
                        <div class="mt-4">
                            <x-label for="capacity" :value="__('Capacity')" />
                            <x-input id="capacity" class="block mt-1 w-full" type="text" name="capacity" :value="old('capacity')" required />
                        </div>

                        <!-- Description -->
                        <div class="mt-4">
                            <x-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <x-label for="price" :value="__('Price')" />
                            <x-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" required />
                        </div>

                        <!-- Images -->
                        <div class="mt-4">
                            <x-label for="images" :value="__('Images')" />
                            <input id="images" class="block mt-1 w-full" type="file" name="images[]" multiple />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button>
                                {{ __('Create Space') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
