<x-filament::page>
    {{-- Search & Filter --}}
    <div class="flex flex-col md:flex-row md:items-center gap-4 mb-6">
        <div class="flex-1">
            {{ $this->form->getComponent('search') }}
        </div>

        <div class="w-full md:w-64">
            {{ $this->form->getComponent('author') }}
        </div>
    </div>

    {{-- Grid Cards --}}
    <div
        class="
            grid
            grid-cols-1
            sm:grid-cols-2
            md:grid-cols-3
            lg:grid-cols-4
            xl:grid-cols-5
            gap-6
        ">
        @forelse ($this->kitabs as $kitab)
        <div class="rounded-xl shadow bg-white dark:bg-gray-900 overflow-hidden">
            {{-- Media --}}
            <div class="h-40 bg-gray-200">
                @if ($kitab->media)
                <img
                    src="{{ asset('storage/' . $kitab->media) }}"
                    class="h-full w-full object-cover">
                @endif
            </div>

            {{-- Content --}}
            <div class="p-4 space-y-2">
                <h3 class="font-semibold text-lg">
                    {{ $kitab->name }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ $kitab->author }}
                </p>

                <p class="text-sm text-gray-600 line-clamp-3">
                    {{ $kitab->description }}
                </p>

                <div class="pt-3">
                    <x-filament::button
                        size="sm"
                        color="primary"
                        tag="a"
                        href="{{ route('filament.admin.resources.kitabs.edit', $kitab) }}">
                        Detail
                    </x-filament::button>
                </div>
            </div>
        </div>
        @empty
        <p class="text-gray-500 col-span-full">
            Tidak ada data kitab
        </p>
        @endforelse
    </div>
</x-filament::page>