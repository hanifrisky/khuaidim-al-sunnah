<div class="card-wrapper">

    <!-- Background -->
    <div
        class="glass-card-bg"
        style="background-image:url('{{ $getRecord()->cover_url }}')">
    </div>

    <!-- Overlay -->
    <div class="glass-card-overlay"></div>

    <!-- Glass Text -->
    <div class="glass-card-content">
        <h3 class="glass-card-title">
            {{ $getRecord()->name }}
        </h3>
        <p class="glass-card-desc">
            {{ $getRecord()->author }}
        </p>

    </div>

</div>