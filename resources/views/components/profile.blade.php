<nav class="py-6">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-primary">Dashboard</h1>
            <span class="text-sm text-tertiary">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
        <a href="{{ route('patients.profile.edit') }}">
            <x-avatar value="{{ auth()->user()->name }}" size="sm" expand />
        </a>
    </div>
</nav>
