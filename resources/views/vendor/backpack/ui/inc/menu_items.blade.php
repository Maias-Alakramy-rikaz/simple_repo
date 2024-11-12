{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>لوحة التحكم</a></li>

@if(backpack_user()->hasAnyPermission(['manage-users','manage-roles','manage-permissions']))
<x-backpack::menu-dropdown title="إدارة مستخدمين" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="الإدارة" />
    
    @if(backpack_user()->hasPermissionTo('manage-users'))
    <x-backpack::menu-dropdown-item title="مستخدمين" icon="la la-user" :link="backpack_url('user')" />
    @endif

    @if(backpack_user()->hasPermissionTo('manage-roles'))
    <x-backpack::menu-dropdown-item title="أدوار" icon="la la-group" :link="backpack_url('role')" />
    @endif
    
    @if(backpack_user()->hasPermissionTo('manage-permissions'))
    <x-backpack::menu-dropdown-item title="صلاحيات" icon="la la-key" :link="backpack_url('permission')" />
    @endif

</x-backpack::menu-dropdown>
@endif
<x-backpack::menu-item title="موردين" icon="la la-user" :link="backpack_url('importer')" />
<x-backpack::menu-item title="زبائن" icon="la la-user" :link="backpack_url('exporter')" />
<x-backpack::menu-item title="مجموعات" icon="la la-tag" :link="backpack_url('group')" />
<x-backpack::menu-item title="منتجات" icon="la la-tag" :link="backpack_url('product')" />
<x-backpack::menu-item title="واردات" icon="la la-tag" :link="backpack_url('import')" />
<x-backpack::menu-item title="صادرات" icon="la la-tag" :link="backpack_url('export')" />
{{-- <x-backpack::menu-item title=" ProductImages" icon="la la-tag" :link="backpack_url('product-image')" /> #TODO --}}