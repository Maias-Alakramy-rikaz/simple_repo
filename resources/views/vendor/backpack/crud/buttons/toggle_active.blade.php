@if (backpack_user()->hasPermissionTo('activate'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/toggle-active') }}" class="btn btn-xs btn-default">
        @if ($entry->activated)
            <i class="fa fa-toggle-on"></i> إلغاءالتفعيل
        @else
            <i class="fa fa-toggle-off"></i> تفعيل
        @endif
    </a>
@endif
