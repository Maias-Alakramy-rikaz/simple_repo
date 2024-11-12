@php
    $Products = App\Models\Product::with(['exports'])->get()->map(function ($product) {
            $totalExports = $product->exports->sum('quantity');
            $product->total_exports = $totalExports;
            return $product;
        })->sortByDesc('total_exports')->take(10)->values();
@endphp

<div class="col-sm-6 col-md-4">
	<div class="card text-white bg-primary">
	  <div class="card-header">أكثر عدد المواد تصديراً</div>
	  <div class="card-body">
        <ol>
            @foreach($Products as $product)
                <li>{{$product->name.": كمية الصادرات: ".$product->total_exports}}</li>
            @endforeach
        </ol>

	  </div>
	</div>
  </div>