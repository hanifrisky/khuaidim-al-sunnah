<x-filament-panels::page>

    <style>
        .hadits-wrapper {
            margin: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .hadits-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px 24px;

            border: 1px solid rgba(34, 197, 94, 0.35);
            /* hijau tipis */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);

            transition: transform .2s ease, box-shadow .2s ease;
        }

        .hadits-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        .hadits-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #166534;
            /* green-800 */
            margin-bottom: 8px;
        }

        .hadits-content {
            font-size: 1.05rem;
            line-height: 1.9;
            color: #111827;
            margin-bottom: 12px;
            direction: rtl;
            text-align: right;
        }

        .hadits-translate {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #374151;
            margin-bottom: 10px;
            border-left: 4px solid #22c55e;
            padding-left: 12px;
        }

        .hadits-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 12px;
        }


        .hadits-badge {

            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 600;
        }

        .badge-read {
            background: #dcfce7;
            color: #166534;
        }

        .badge-unread {
            background: #F7F7B1;
            color: #F7B400;
        }
    </style>
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
    <!-- SEARCH -->

    <div class="hadits-wrapper">
        @php
        $results = $this->getResults();
        @endphp

        {{-- Tidak ada isi --}}
        @if($results->isEmpty())
        <div style="text-align:center; margin-top:40px; color:#6b7280;">
            <div style="font-size:1.1rem; font-weight:600;">
                Belum ada notifikasi masuk
            </div>
        </div>


        @else
        {{-- List Notifikasi --}}
        @foreach ($results as $item)
        <button href="{{$item->action}}"
            wire:click="aksiPesan({{ $item }})"
            class="hadits-card">
            <div class="hadits-title">
                {!! $item->pesan !!}
            </div>
            <div class="hadits-meta">
                @if($item->status)
                <span class="hadits-badge badge-{{$item->status}}">
                    {{ $item->status }}
                </span>
                @endif
            </div>
        </button>
        @endforeach
        @endif
    </div>


    <div style="height:2px"></div>
    {{-- MOBILE NAV --}}
    <div class="bottom-nav">
        <a href="/app" class="nav-item">
            <span class="icon">🏠</span>
            <small>Home</small>
        </a>

        <a href="/app/search" class="nav-item">
            <span class="icon">🔍</span>
            <small>Search</small>
        </a>

        <a href="/app/chat" class="nav-item active">
            <span class="icon">💬</span>
            <small>Chat</small>
        </a>

        <a href="/app/profile" class="nav-item">
            <span class="icon">👤</span>
            <small>Profile</small>
        </a>
    </div>

</x-filament-panels::page>