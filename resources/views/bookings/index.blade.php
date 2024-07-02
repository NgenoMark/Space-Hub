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
            <x-nav-link href="{{ route('admin.bookings.list') }}" :active="request()->routeIs('admin.bookings.list')" onclick="loadContent('{{ route('admin.bookings.list') }}'); return false;">
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
                @include('bookings.list', ['bookings' => $bookings])
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.update-status-button').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('tr').querySelector('.update-status-form');
                    form.querySelector('.submit-status-button').click();
                });
            });

            document.querySelectorAll('.update-status-form').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const formData = new FormData(form);
                    const status = formData.get('status');
                    const action = form.getAttribute('action');

                    fetch(action, {
    method: 'POST',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({ status: status })
})
.then(response => {
    if (!response.ok) {
        return response.json().then(err => { throw err; });
    }
    return response.json();
})
.then(data => {
    if (data.success) {
        alert('Status updated successfully');
    } else {
        alert('Error updating status: ' + data.message);
    }
})
.catch(error => {
    console.error('Error:', error);
    alert('Error updating status: ' + error.message);
});

                });
            });
        });
    </script>
</x-app-layout>
