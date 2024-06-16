<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        @vite(['resources/js/app.js'])
        <h1><b>Screen Locked</b></h1>
        <form method="post" action="{{ route('unlock') }}">
            @csrf
            <div class="px-4 py-5 bg-white sm:p-6">
                <label for="password">Enter your password to unlock:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                    Confirm
                </button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
