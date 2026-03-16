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
            <x-filament::button type="submit">يحفظ</x-filament::button>
        </div>
    </form>
    @include('components.bottom-nav')
</div>