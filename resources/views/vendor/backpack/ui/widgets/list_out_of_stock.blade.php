@php
    $Products = App\Models\Product::with(['imports', 'exports'])->get()->filter(function ($product)
    {
      return $product->current_quantity <= $product->min_quan;
    });
@endphp

<div class="col-sm-6 col-md-4">
	<div class="card text-white bg-danger">
	  <div class="card-header">المواد التي وصلت أو قطعت الحد الأدنى</div>
	  <div class="card-body">
        <ol>
          @if($Products->isEmpty())
            <p>لا يوجد مواد.</p>
          @else
            @foreach($Products as $product)
            <li>{{$product->name.":"}}
                <ul>
                <li>{{"الكمية الحالية: ".$product->current_quantity}}</li>
                <li>{{"الحد الأدنى: ".$product->min_quan}}</li>
                </ul>
            </li>
            @endforeach
          @endif
        </ol>

	  </div>
	</div>
  </div>