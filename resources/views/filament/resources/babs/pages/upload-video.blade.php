<div class="mt-6">
    <style>
        <?php
        if (auth()->user()?->role === 'siswa') {
        ?>.fi-topbar-open-sidebar-btn {
            display: none !important;
        }

        <?php
        }
        ?>
    </style>
    <form wire:submit="submit">
        {{ $this->form }}
        <div class="mt-6">
            <x-filament::button type="submit">حفظ الفيديو</x-filament::button>
        </div>
    </form>
    <div style="height: 100px;">

    </div>
    {{-- MOBILE NAV --}}
    <div class="bottom-nav">
        <a href="/app" class="nav-item active">
            <span class="icon">🏠</span>
            <small>Home</small>
        </a>

        <a href="/app/search" class="nav-item">
            <span class="icon">🔍</span>
            <small>Search</small>
        </a>

        <a href="/app/chat" class="nav-item">
            <span class="icon">💬</span>
            <small>Chat</small>
        </a>

        <a href="/app/profile" class="nav-item">
            <span class="icon">👤</span>
            <small>Profile</small>
        </a>
    </div>
</div>