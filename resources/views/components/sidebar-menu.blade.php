<!-- Dashboard -->
<li class="menu-item">
    <a href="index.html" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
    </a>
</li>

@role('admin')
@include('components.menu-admin')
@endrole

@role('waiter')
@include('components.menu-waiter')
@endrole

@role('kitchen')
@include('components.menu-kitchen')
@endrole


@role('cashier')
@include('components.menu-cashier')
@endrole
