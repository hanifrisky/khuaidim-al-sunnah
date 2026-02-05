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
        padding: 20px;
    }

    .welcome h1 {
        font-size: 22px;
        font-weight: 700;
    }

    .welcome p {
        font-size: 12px;
        color: #555;
    }

    .hero {
        position: relative;
        padding: 20px;
        min-height: 220px;
        margin-top: -50px;
    }

    .books-title {
        color: black;
        font-size: 22px;
        font-weight: 700;

        padding: 0 20px;
        margin: 10px 0 12px;

        letter-spacing: .5px;
    }

    /* BUKU */
    .book-stack {
        position: absolute;
        left: -20px;
        top: 20px;
        width: 200px;
        z-index: 5;
        /* di atas quote */
    }

    /* QUOTE */
    .quote {
        position: absolute;
        left: 0;
        top: 100px;
        /* di bawah buku */
        right: 200px;
        /* space dari sisi kanan layar */

        background: #0f3c4c;
        color: white;
        border-radius: 0 20px 20px 0;
        padding: 18px 20px 18px 160px;
        /* geser teks dari buku */

        z-index: 1;
    }

    .quote p {
        margin: 0;
        font-size: 14px;
        line-height: 1.4;
    }

    .quote small {
        display: block;
        margin-top: 6px;
        opacity: .8;
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

    .book-card {
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease;
        padding: 14px;
        border-radius: 12px;
        min-height: 200px;
    }

    .book-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
    }

    .book-card h3 {
        font-size: 14px;
    }

    .book-card p {
        font-size: 11px;
        opacity: .85;
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
                <h1>أهلاً وسهلاً</h1>
                <p>زهرة الصالحة النور جنة</p>
            </div>
        </div>
        {{-- HERO --}}
        <div class="hero">
            <img src="{{ asset('image/book.png') }}" class="book-stack">

            <div class="quote">
                <p>
                    لا يستطيع العلم براحة الجسم
                </p>
                <small>رواه مسلم</small>
            </div>

        </div>
        <h2 class="books-title">الكتب المقررة</h2>
        {{-- BOOKS --}}
        <div class="books">


            <div class="book-grid">
                @foreach ($this->GetKitabs() as $item)
                <?php
                $stringurl = '/app/kitabs/' . $item->id;
                if ($siswa) {
                    $stringurl = '/app/kitabs/' . $item->id . '/bab';
                }
                ?>
                <a href="{{ url($stringurl) }}" class="book-card-link">
                    <div class="book-card"
                        style="
                background:
                {{ $item->media
                    ? 'url('.asset($item->media).')'
                    : 'hsl('.($item->id * 57 % 360).',60%,45%)'
                }};
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            ">
                        <h3>{{ $item->name }}</h3>
                        <p>{{ $item->author }}</p>
                    </div>
                </a>
                @endforeach

            </div>
        </div>
        <div style="height:200px">

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
</div>