<li class="menu-header small text-uppercase"><span class="menu-header-text">Menu Dapur</span></li>

<li class="menu-item {{ Route::is('orders.*') ? 'active' : '' }}">
    <a href="{{ route('orders.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-clipboard"></i>
        <div data-i18n="Analytics">Pesanan</div>
    </a>
</li>

<li class="menu-item {{ Route::is('orders.*') ? 'active' : '' }}">
    <a href="{{ route('orders.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-clipboard"></i>
        <div data-i18n="Analytics">Pembayaran</div>
    </a>
</li>

