@php
    $inactiveProducts = App\Models\Product::where('activated', false)->get();
@endphp

<div class="col-sm-6 col-md-4">
	<div class="card text-white bg-primary">
	  <div class="card-header">المواد غير الفعّالة</div>
	  <div class="card-body">
		
		@if($inactiveProducts->isEmpty())
            <p>لا يوجد مواد غير فعّالة.</p>
        @else
            <ul>
                @foreach($inactiveProducts as $product)
                    <li>{{ $product->name }}</li>
                @endforeach
            </ul>
        @endif

	  </div>
	</div>
  </div>