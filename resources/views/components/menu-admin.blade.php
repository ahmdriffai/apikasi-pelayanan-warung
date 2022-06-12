<!-- Dashboard -->
<li class="menu-header small text-uppercase"><span class="menu-header-text">Menu Admin</span></li>

<li class="menu-item {{ Route::is('employees.*') ? 'active' : '' }}">
    <a href="{{ route('employees.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Analytics">Karyawan</div>
    </a>
</li>


<li class="menu-item {{ Route::is('menus.*') ? 'active' : '' }}">
    <a href="{{ route('menus.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-food-menu"></i>
        <div data-i18n="Analytics">Daftar Menu</div>
    </a>
</li>

<li class="menu-item {{ Route::is('categories.*') ? 'active' : '' }}">
    <a href="{{ route('categories.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-list-ul"></i>
        <div data-i18n="Analytics">Kategory Menu</div>
    </a>
</li>

<li class="menu-item {{ Route::is('tables.*') ? 'active' : '' }}">
    <a href="{{ route('menus.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-chalkboard"></i>
        <div data-i18n="Analytics">Meja</div>
    </a>
</li>

<li class="menu-item {{ Route::is('tables.*') ? 'active' : '' }}">
    <a href="{{ route('menus.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-clipboard"></i>
        <div data-i18n="Analytics">Pesanan</div>
    </a>
</li>
<li class="menu-item {{ Route::is('tables.*') ? 'active' : '' }}">
    <a href="{{ route('menus.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-credit-card"></i>
        <div data-i18n="Analytics">Pembayaran</div>
    </a>
</li>

{{--<li class="menu-item {{ Route::is('users.*') ? 'active open' : '' }}">--}}
{{--    <a href="javascript:void(0);" class="menu-link menu-toggle">--}}
{{--        <i class="menu-icon tf-icons bx bx-user-circle"></i>--}}
{{--        <div data-i18n="Form Elements">User Manajemen</div>--}}
{{--    </a>--}}
{{--    <ul class="menu-sub">--}}
{{--        <li class="menu-item  {{ Route::is('users.*') ? 'active' : '' }}">--}}
{{--            <a href="{{ route('users.index') }}" class="menu-link">--}}
{{--                <div data-i18n="Basic Inputs">User</div>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="menu-item">--}}
{{--            <a href="forms-input-groups.html" class="menu-link">--}}
{{--                <div data-i18n="Input groups">Hak Akses</div>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</li>--}}
