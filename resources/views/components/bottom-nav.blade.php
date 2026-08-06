@if(auth()->user()->role === 'siswa')
<div class="bottom-nav">

    <a href="/app" class="nav-item {{ request()->is('app') || request()->is('app/kitabs*') || request()->is('app/babs*')  ? 'active' : '' }}">
        <span class="icon">🏠</span>
        <small>{{ __('Home') }}</small>
    </a>

    <a href="/app/search" class="nav-item {{ request()->is('app/search') ? 'active' : '' }}">
        <span class="icon">🔍</span>
        <small>{{ __('Search') }}</small>
    </a>

    <a href="/app/chat" class="nav-item {{ request()->is('app/chat') ? 'active' : '' }}">
        <span class="icon">💬</span>
        <small>{{ __('Notifications') }}</small>
    </a>

    <a href="/app/profile" class="nav-item {{ request()->is('app/profile') ? 'active' : '' }}">
        <span class="icon">👤</span>
        <small>{{ __('Profile') }}</small>
    </a>

</div>
@endif