<li class="menu-header small text-uppercase"><span class="menu-header-text">Menu Pelayan</span></li>

<li class="menu-item {{ Route::is('menus.*') ? 'active' : '' }}">
    <a href="{{ route('menus.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-food-menu"></i>
        <div data-i18n="Analytics">Menu</div>
    </a>
</li>

<li class="menu-item {{ Route::is('orders.*') ? 'active' : '' }}">
    <a href="{{ route('orders.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-clipboard"></i>
        <div data-i18n="Analytics">Pesanan</div>
    </a>
</li>



