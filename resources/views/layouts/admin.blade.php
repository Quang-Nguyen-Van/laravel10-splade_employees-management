<div class="min-h-screen bg-gray-100">
    @include('layouts.admin-navigation')

    <div class="flex space-x-4">
        <sidebar />

    <!-- Page Content -->
    <main class="flex-1">
        <div class="max-w-6x1 mx-auto">
            {{ $slot }}
        </div>
    </main>
    </div>
</div>
