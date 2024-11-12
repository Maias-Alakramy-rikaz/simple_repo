@if (backpack_user()->hasPermissionTo('block'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/toggle-block') }}" class="btn btn-xs btn-default">
        @if ($entry->blocked)
            <i class="fa fa-toggle-on"></i> السماح بالتعامل
        @else
            <i class="fa fa-toggle-off"></i> منع التعامل
        @endif
    </a>
@endif
