{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Exports" icon="la la-question" :link="backpack_url('export')" />
<x-backpack::menu-item title="Exporters" icon="la la-question" :link="backpack_url('exporter')" />
<x-backpack::menu-item title="Groups" icon="la la-question" :link="backpack_url('group')" />
<x-backpack::menu-item title="Imports" icon="la la-question" :link="backpack_url('import')" />
<x-backpack::menu-item title="Importers" icon="la la-question" :link="backpack_url('importer')" />
<x-backpack::menu-item title="Products" icon="la la-question" :link="backpack_url('product')" />
<x-backpack::menu-item title="Product images" icon="la la-question" :link="backpack_url('product-image')" />
<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />