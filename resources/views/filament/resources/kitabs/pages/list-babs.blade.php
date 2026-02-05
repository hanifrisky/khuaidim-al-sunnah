<x-filament-panels::page>

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
    <?php
    $kitab = $this->GetKitab();
    ?>
    <div class="home-app">

        <!-- HEADER IMAGE -->
        <div class="home-header">
            <img src="{{ $kitab->media
                    ? asset($kitab->media) :
                    asset('image/book.png')
                    }}" class="header-bg">
            <div class="header-overlay">
                <h1>صحيح مسلم</h1>
            </div>
        </div>

        <!-- SEARCH FORM -->
        <div class="search-wrapper">
            <form class="search-box" action="/app/search" method="GET">
                <input
                    type="text"
                    name="q"
                    placeholder="ابحث عن حديث، كتاب أو موضوع"
                    required>
                <button type="submit">🔍</button>
            </form>
        </div>


        <!-- MENU -->
        <div class="menu">
            <button
                id='btn-upload-video'
                type="button"
                class="menu-item"
                wire:click="openVideoModal">
                🎥 <span>فيديو</span>
            </button>

            <a href="/app/kitabs/{{$kitab->id}}/soal" class="menu-item">
                📚 <span>أقسام الحديث</span>
            </a>

            <a href="/app/kitabs/{{$kitab->id}}/soal" class="menu-item">
                ❓ <span>أسئلة</span>
            </a>
        </div>


        <!-- CONTENT -->
        <div class="content">
            @foreach ($this->GetBabs() as $item)
            <a href="/app/babs/{{$item->id}}/hadits" class="book-card">
                <div class="book-card-image">
                    <img src="{{ $item->media
                    ? asset($item->media) :
                    asset('image/book.png')
                    }}">
                </div>

                <div class="book-card-body">
                    <h3>{{ $item->name }}</h3>
                </div>
            </a>
            @endforeach
        </div>
        <div style="height:50px"></div>
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
    {{-- MODAL VIDEO --}}
    @if($showVideoModal)
    <div id='modal-list-video' class="modal-backdrop" wire:click.self="closeVideoModal">
        <div class="modal-box">
            <h3>قائمة الأبواب</h3>

            <div class="modal-list">
                @foreach($videoBabs as $bab)
                <button
                    id='btn-upload-{{ $bab->id }}'
                    type="button"
                    class="modal-item"
                    wire:click="selectBab({{ $bab->id }})">
                    📖 {{ $bab->name }}
                </button>
                @endforeach
            </div>

            <button id='btn-close-list-video' class="modal-close" wire:click="closeVideoModal">✕</button>
        </div>
    </div>
    @endif

    <style>
        .home-app {
            max-width: 480px;
            margin: auto;
        }

        /* HEADER */
        .home-header {
            position: relative;
            height: 200px;
            border-radius: 16px;
            overflow: hidden;
        }

        .header-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-overlay h1 {
            color: #fff;
            font-size: 26px;
        }

        /* MENU */
        .menu {
            margin-top: 18px;
            display: flex;
            gap: 10px;
        }

        .menu-item {
            flex: 1;
            background: #e8f5e9;
            height: 80px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 14px;
        }

        /* CONTENT */
        /* GRID */
        .content {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        /* CARD */
        .book-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .18);
        }

        /* IMAGE HEADER */
        .book-card-image img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        /* BODY */
        .book-card-body {
            padding: 12px;
        }

        .book-card-body h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .book-card-body p {
            margin-top: 6px;
            font-size: 13px;
            color: #666;
        }

        /* DESKTOP */
        @media (min-width: 768px) {
            .content {
                grid-template-columns: repeat(4, 1fr);
            }
        }


        /* DESKTOP */
        @media (min-width: 768px) {
            .home-app {
                max-width: 900px;
            }

            .content {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* MODAL */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        .modal-box {
            background: #fff;
            width: 90%;
            max-width: 360px;
            border-radius: 16px;
            padding: 16px;
            position: relative;
            animation: fadeUp .25s ease;
        }

        .modal-box h3 {
            margin-bottom: 12px;
            text-align: center;
        }

        .modal-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 300px;
            overflow-y: auto;
        }

        .modal-item {
            padding: 12px;
            border-radius: 12px;
            background: #f5f5f5;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .modal-item:hover {
            background: #e8f5e9;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            border: none;
            background: #ff5252;
            color: #fff;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            cursor: pointer;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</x-filament-panels::page>