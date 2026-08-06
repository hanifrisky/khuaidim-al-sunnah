<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Reem+Kufi:wght@400..700&family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

<style>
    /* RESET FILAMENT */
    .filament-page,
    .fi-page,
    .fi-main,
    .fi-main-content {
        max-width: 100% !important;
        padding: 0 !important;
    }

    .fi-body {

        /* fallback */
        background-image: url('/image/pattern.png');
        background-repeat: repeat;
    }

    /* OVERLAY GRADIENT */
    .fi-body::before {
        content: "";
        position: fixed;
        inset: 0;

        background: linear-gradient(to bottom,
                rgba(255, 255, 255, 0.15),
                rgba(31, 111, 92, 0.65));

        pointer-events: none;
        z-index: 0;
    }

    /* KONTEN DI ATAS OVERLAY */
    .fi-main,
    .fi-page,
    .fi-main-content,
    .beranda-wrapper {
        position: relative;
        z-index: 1;
    }

    /* ROOT */
    .beranda-wrapper {
        width: 100vw;
        height: 100dvh;
        background: transparent;
        display: flex;
        justify-content: center;
        overflow-y: auto;
    }

    /* CONTAINER */
    .beranda-container {
        width: 100%;
        display: flex;
        flex-direction: column;
        margin-bottom: 400px;
    }

    /* HEADER */
    .header {
        display: flex;
        justify-content: space-between;
        padding: 24px 20px 16px;
    }

    .welcome h1 {
        font-family: 'Cairo', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
    }

    .welcome p {
        font-family: 'Cairo', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-top: 2px;
    }

    .hero {
        position: relative;
        padding: 20px;
        min-height: 220px;
        margin-top: -30px;
    }

    .books-title {
        color: #0f172a;
        font-size: 22px;
        font-weight: 800;
        font-family: 'Cairo', sans-serif;
        padding: 0 20px;
        margin: 20px 0 14px;
    }

    /* BUKU */
    .book-stack {
        position: absolute;
        left: -15px;
        top: 10px;
        width: 175px;
        z-index: 5;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.25));
    }

    /* QUOTE */
    .quote {
        position: absolute;
        left: 0;
        top: 85px;
        right: 200px;

        background: linear-gradient(135deg, rgba(15, 60, 76, 0.95), rgba(8, 43, 56, 0.95));
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: white;
        border-radius: 0 24px 24px 0;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-left: none;
        padding: 20px 24px 20px 150px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        z-index: 1;
    }

    .quote p {
        margin: 0;
        font-family: 'Amiri', serif;
        font-size: 1.15rem;
        line-height: 1.6;
        direction: rtl;
        text-align: right;
    }

    .quote small {
        display: block;
        margin-top: 8px;
        font-family: 'Cairo', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        opacity: .85;
    }

    .header-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* BOOK LIST */
    .books {
        padding: 20px;
        color: white;
    }

    .book-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .book-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    /* CARD */
    .book-card {
        position: relative;
        width: 100%;
        aspect-ratio: 3/4;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    /* OVERLAY GRADIENT */
    .book-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(15, 23, 42, 0.95) 15%,
                rgba(15, 23, 42, 0.55) 50%,
                rgba(15, 23, 42, 0) 100%);
        transition: all 0.3s ease;
        z-index: 1;
    }

    /* TEKS DI BAWAH */
    .book-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 16px 12px;
        z-index: 2;
        color: #fff;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.3) 60%, transparent 100%);
        backdrop-filter: blur(2px);
    }

    /* TEKS */
    .book-card h3 {
        font-family: 'Cairo', sans-serif;
        font-weight: 700;
        font-size: 13.5px;
        margin: 0 0 5px;
        line-height: 1.4;
    }

    .book-card p {
        font-family: 'Cairo', sans-serif;
        font-weight: 400;
        font-size: 11px;
        color: #cbd5e1;
        opacity: .95;
    }

    /* HOVER */
    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.22);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .book-card:hover .book-overlay {
        opacity: 0.8;
    }




    /* DESKTOP MODE */

    @media (min-width: 1024px) {
        .beranda-container {
            margin-right: 400px;
        }

        .book-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .bottom-nav {
            display: none;
        }

        .quote {
            right: 200px;
        }

        .book-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quote {
            right: 20px;
        }
    }
</style>

<div class="beranda-wrapper">
    <style>
        <?php
        $siswa = auth()->user()->siswa;
        if (auth()->user()?->role === 'siswa') {
        ?>.fi-topbar-open-sidebar-btn {
            display: none !important;
        }

        <?php
        }
        ?>
    </style>
    <div class="beranda-container">

        {{-- HEADER --}}
        <div class="header">
            <div class="welcome">
                <h1>{{ __('Welcome') }}</h1>
                <p>{{ auth()->user()->name }}</p>
            </div>
        </div>
        {{-- HERO --}}
        <div class="hero">
            <img src="{{ asset('image/book.png') }}" class="book-stack">

            <div class="quote">
                {!! $this->getQuote() !!}
                <!--<p>
                    لا يستطيع العلم براحة الجسم
                </p>
                <small>رواه مسلم</small>
                -->
            </div>


        </div>
        <h2 class="books-title">{{ __('Required Books') }}</h2>
        {{-- BOOKS --}}
        <div class="books" style="padding-bottom: 100px;">


            <div class="book-grid">
                @foreach ($this->GetKitabs() as $item)
                <?php
                $stringurl = '/app/kitabs/' . $item->id;
                if ($siswa) {
                    $stringurl = '/app/kitabs/' . $item->id . '/bab';
                }
                $background = $item->media
                    ? 'url(' . asset('storage/' . $item->media) . ')'
                    : 'hsl(' . ($item->id * 57 % 360) . ',60%,45%)';
                ?>

                <a href="{{ url($stringurl) }}" class="book-card-link">
                    <div class="book-card"
                        style="
            background:
            {{ 
            $background
            }};
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        ">
                        {{-- Overlay --}}
                        <div class="book-overlay"></div>

                        {{-- Konten --}}
                        <div class="book-content">
                            <h3>{{ $item->name }}</h3>
                            <p>{{ $item->author }}</p>
                        </div>
                    </div>
                </a>

                @endforeach

            </div>
        </div>


        @include('components.bottom-nav')
    </div>
</div>