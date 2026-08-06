<x-filament-panels::page>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Reem+Kufi:wght@400..700&family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

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
                    ? asset('storage/'.$kitab->media) :
                    asset('image/book.png')
                    }}" class="header-bg">
            <div class="header-overlay">
                <h1>{{ $kitab->name }}</h1>
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
        <div class="modern-menu-container">
            <button
                id='btn-upload-video'
                type="button"
                class="modern-menu-item video-btn"
                wire:click="openVideoModal">
                <div class="icon-circle">🎥</div>
                <span>فيديو</span>
            </button>

            <a href="/app/kitabs/{{$kitab->id}}/soal" class="modern-menu-item soal-btn">
                <div class="icon-circle">📚</div>
                <span>الاستيعاب</span>
            </a>

            <a href="/app/kitabs/{{$kitab->id}}/melanjutkan" class="modern-menu-item melanjutkan-btn">
                <div class="icon-circle">❓</div>
                <span>إكمال الحديث</span>
            </a>
        </div>


        <!-- CONTENT -->
        <div class="content">
            @foreach ($this->GetBabs() as $item)
            <a href="/app/babs/{{$item->id}}/hadits" class="book-card">
                <div class="book-card-image">
                    @if($item->media)
                        <img src="{{ asset('storage/'. $item->media) }}">
                    @else
                        @php
                            $gradients = [
                                'linear-gradient(135deg, #11998e, #38ef7d)', // green/teal
                                'linear-gradient(135deg, #3f2b96, #a8c0ff)', // purple/blue
                                'linear-gradient(135deg, #ff9966, #ff5e62)', // orange/red
                                'linear-gradient(135deg, #0f2027, #203a43, #2c5364)', // dark slate
                                'linear-gradient(135deg, #36d1dc, #5b86e5)', // cyan/blue
                                'linear-gradient(135deg, #7f00ff, #e100ff)', // violet/magenta
                                'linear-gradient(135deg, #00b4db, #0083b0)', // sky blue
                                'linear-gradient(135deg, #1e3c72, #2a5298)', // deep blue
                            ];
                            $gradient = $gradients[$item->id % count($gradients)];
                            $arabic_numerals = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
                            $num = str_replace(range(0, 9), $arabic_numerals, $loop->iteration);
                        @endphp
                        <div class="book-card-placeholder" style="background: {{ $gradient }};">
                            <span class="arabic-numeral">{{ $num }}</span>
                            <span class="arabic-text">الباب</span>
                        </div>
                    @endif
                </div>

                <div class="book-card-body">
                    <h3>{{ $item->name }}</h3>
                </div>
            </a>
            @endforeach
        </div>
        <div style="height:50px"></div>
        @include('components.bottom-nav')

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

        /* MODERN MENU */
        .modern-menu-container {
            margin-top: 24px;
            display: flex;
            gap: 12px;
            width: 100%;
        }

        .modern-menu-item {
            flex: 1;
            height: 95px;
            border-radius: 18px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
            text-decoration: none;
            color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            background: #fff;
        }

        .modern-menu-item::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        /* Specific item themes */
        .modern-menu-item.video-btn {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-color: rgba(34, 197, 94, 0.2);
            color: #166534;
        }
        .modern-menu-item.video-btn::before {
            background: linear-gradient(135deg, #22c55e, #15803d);
        }

        .modern-menu-item.soal-btn {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-color: rgba(59, 130, 246, 0.2);
            color: #1e40af;
        }
        .modern-menu-item.soal-btn::before {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .modern-menu-item.melanjutkan-btn {
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border-color: rgba(245, 158, 11, 0.2);
            color: #92400e;
        }
        .modern-menu-item.melanjutkan-btn::before {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        /* Icon containers */
        .icon-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            margin-bottom: 8px;
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .modern-menu-item span {
            z-index: 2;
            transition: color 0.3s ease;
        }

        /* Hover animations */
        .modern-menu-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            color: #fff;
        }

        .modern-menu-item:hover::before {
            opacity: 1;
        }

        .modern-menu-item:hover .icon-circle {
            background: #fff;
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .modern-menu-item:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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
            font-size: 15px;
            font-weight: 700;
            font-family: 'Amiri', serif;
            direction: rtl;
            text-align: right;
            line-height: 1.6;
            color: #1e293b;
        }

        /* PLACEHOLDER CARD */
        .book-card-placeholder {
            width: 100%;
            height: 140px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            color: #fff;
            overflow: hidden;
        }

        .book-card-placeholder::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.25), transparent 65%);
            pointer-events: none;
        }

        .arabic-numeral {
            font-family: 'Reem Kufi', sans-serif;
            font-size: 3.4rem;
            font-weight: 700;
            line-height: 1;
            opacity: 0.95;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            font-size: 1.15rem;
            font-weight: 700;
            opacity: 0.9;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            margin-top: 2px;
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