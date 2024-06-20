<!-- resources/views/users/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h2 class="mb-4">Edit User</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-4 border rounded shadow-sm bg-light">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="name" class="form-label" style="font-size: 1.2em;">Name</label>
        <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ $user->name }}" required>
    </div>
    <div class="mb-4">
        <label for="email" class="form-label" style="font-size: 1.2em;">Email address</label>
        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div class="mb-4">
        <label for="role" class="form-label" style="font-size: 1.2em;">Role</label>
        <input type="text" class="form-control form-control-lg" id="role" name="role" value="{{ $user->role }}" required>
    </div>
    <button type="submit" class="btn btn-primary btn-lg">Update User</button>
</form>

    </div>
</x-app-layout>
