@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-4">
            {{ __('Edit Space') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Space</h3>
                    <form method="POST" action="{{ route('admin.spaces.update', $space->space_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="space_name" class="block text-sm font-medium text-gray-700">Space Name</label>
                            <input type="text" name="space_name" id="space_name" value="{{ $space->space_name }}" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="space_type" class="block text-sm font-medium text-gray-700">Space Type</label>
                            <input type="text" name="space_type" id="space_type" value="{{ $space->space_type }}" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ $space->location }}" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                            <input type="number" name="capacity" id="capacity" value="{{ $space->capacity }}" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" class="mt-1 block w-full" required>{{ $space->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="text" name="price" id="price" value="{{ $space->price }}" class="mt-1 block w-full" required>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update Space</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('admin.spaces.destroy', $space->space_id) }}" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <!--<button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Delete Space</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
