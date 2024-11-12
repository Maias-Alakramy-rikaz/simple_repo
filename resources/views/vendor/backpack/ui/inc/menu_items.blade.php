{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>لوحة التحكم</a></li>

<x-backpack::menu-item title="مستخدمين" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="موردين" icon="la la-user" :link="backpack_url('importer')" />
<x-backpack::menu-item title="زبائن" icon="la la-user" :link="backpack_url('exporter')" />
<x-backpack::menu-item title="مجموعات" icon="la la-tag" :link="backpack_url('group')" />
<x-backpack::menu-item title="منتجات" icon="la la-tag" :link="backpack_url('product')" />
<x-backpack::menu-item title="واردات" icon="la la-tag" :link="backpack_url('import')" />
<x-backpack::menu-item title="صادرات" icon="la la-tag" :link="backpack_url('export')" />
{{-- <x-backpack::menu-item title=" ProductImages" icon="la la-tag" :link="backpack_url('product-image')" /> #TODO --}}